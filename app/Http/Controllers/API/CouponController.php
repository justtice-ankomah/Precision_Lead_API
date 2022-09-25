<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Coupon;

class CouponController extends Controller
{
          // Create a coupon for a user
        public function createCoupon(Request $request, $adminId)  {
            $adminUser = auth()->user()->find($adminId);
            // If admin id not found...
            if(!$adminUser){
                return response()->json([
                "success" => false,
                "messgae" => "Unknow Admin"
                ],400);
            }
            // If Admin id found...
             else if($adminUser){
                // check if user is admin
                 if($adminUser["groupid"]==1){
                    $validator = Validator::make($request->all(), [
                        'discountAmount' => 'required|numeric',
                        'toUserId' => 'required|numeric',
                    ]);
                    //if validation fails
                    if ($validator->fails()) {
                         return response()->json([
                            "success"=>false,
                            "message"=>"Validation error"
                        ], 400);
                    }
                      //if validation passed
                    else{
                        try{
                          $couponCode = substr(uniqid(), 0, 11);  // then after, select * from coupontable where code=$couponCode

                        $coupon = Coupon::create([
                            'code' => $couponCode,
                            'discountAmount' => $request->discountAmount,
                            'addedByAdminId' => $adminId,
                            'toUserId'=> $request->toUserId,
                        ]);


                        $coupon->discountAmount=(int) $coupon->discountAmount;
                        $coupon->addedByAdminId=(int) $coupon->addedByAdminId;
                        $coupon->toUserId=(int) $coupon->toUserId;

                        return response()->json([
                            'success'=>true,
                            'message'=> 'Coupon successfully generated',
                            "copon"=>$coupon
                        ], 200);

                        //send sms of the coupon to the user phone numbe with here or let micheal use the admin after genertion a coupon
                    }
                    catch(Exception $e){
                 return response()->json([
                            'success'=>false,
                            'error'=> $e->getMessage()
                        ], 401);
                    }
                }
                 }
                 else{
                    return response()->json([
                        "success" => true,
                        "data" =>"Sorry, only admin can add product category"
                        ],200);
                 }
            }
            else{
                return response()->json([
                    "success" => false,
                    "data" =>"Something went wrong"
                    ],200);
             }
        }

        // Get All couponse
        public function getAllCoupon(Request $request){
            try{
                $coupon = Coupon::all();
                if(count(json_decode($coupon)) > 0){
                    for($i=0; $i<$coupon->count(); $i++){
                        $coupon[$i]->discountAmount=(int) $coupon[$i]->discountAmount;
                        $coupon[$i]->addedByAdminId=(int) $coupon[$i]->addedByAdminId;
                        $coupon[$i]->toUserId=(int) $coupon[$i]->toUserId;
                    }
                }
                return response()->json([
                    "success" => true,
                    "coupons" =>$coupon
                    ],200);

            }
            catch(Exception $e){
                return response()->json([
                            'success'=>false,
                            'error'=> $e->getMessage()
                        ], 401);
                }
        }

         // Get Single coupon details
        public function getCouponDetails($couponId){
            try{
         $coupon = Coupon::find($couponId);
            // If Coupon id not found...
            if(!$coupon){
                return response()->json([
                "success" => true,
                "messgae" => "Invalid coupon"
                ],200);
            }
            // If coupon id found...
             else if($coupon){
                $coupon->discountAmount=(int) $coupon->discountAmount;
                $coupon->addedByAdminId=(int) $coupon->addedByAdminId;
                $coupon->toUserId=(int) $coupon->toUserId;

                return response()->json([
                "success" => true,
                "coupon" => $coupon->toArray()
                ],200);
            }
        }
        catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'error'=> $e->getMessage()
                    ], 401);
            }

        }

    // VERIFy COupon code
    public static function verifyCouponCode(Request $request){
        try{
            $coupon = Coupon::where("code",$request->code)->get();

            if(count(json_decode($coupon)) > 0){
                for($i=0; $i<$coupon->count(); $i++){
                    $coupon[$i]->discountAmount=(int) $coupon[$i]->discountAmount;
                    $coupon[$i]->addedByAdminId=(int) $coupon[$i]->addedByAdminId;
                    $coupon[$i]->toUserId=(int) $coupon[$i]->toUserId;
                }

                return response()->json([
                    "success" => true,
                    "message" =>"Coupon is valid",
                    "coupon"=> $coupon[0]
                    ],200);
            }
            else{
                return response()->json([
                    "success" => true,
                    "message" =>"Invalid coupon",
                    "code"=>$request->code
                    ],200);
            }




        }
        catch(Exception $e){
            return response()->json([
                       'success'=>false,
                       'error'=> $e->getMessage()
                   ], 401);
               }
    }

        // upate coupon details
        public function updateCoupon(Request $request, $adminId, $couponId){
            if (!$request->has('discountAmount') || !$request->has('toUserId')) {
                return response()->json(['message' => 'Missing one or more required fields'], 422);
            }

            $user = auth()->user()->find($adminId);
            // If admin id not found...
            if(!$user){
                return response()->json([
                "success" => false,
                "messgae" => "Unknow Admin"
                ],400);
            }
            // If Admin id found...
            else if($user){
                // check if user is admin
                if($user["groupid"]==1){
                    try{
                        $coupon = Coupon::find($couponId);
                        if($coupon==null){
                            return response()->json([
                                "success" => true,
                                "message" =>"coupon not found"
                                ],200);
                        }
                        else if($coupon!=null){
                            $coupon->discountAmount=$request->discountAmount;
                            $coupon->toUserId=$request->toUserId;
                            $coupon->save();

                            return response()->json([
                                "success" => true,
                                "message" =>"Coupon with id $couponId successfully Updated",
                                "coupon"=>Coupon::find($couponId)
                                ],200);
                        }
                        else{
                            return;
                        }

                    } catch(Exception $e){
                    return response()->json([
                                'success'=>false,
                                'error'=> $e->getMessage()
                            ], 401);

                    }
                }
                else{
                    return response()->json([
                        "success" => true,
                        "data" =>"Sorry, only admin can update a Coupon"
                        ],200);
                }
            }
            else{
                return response()->json([
                    "success" => false,
                    "data" =>"Something went wrong"
                    ],200);
            }
        }


         // Delete coupon
         public function deleteCoupon(Request $request, $adminId, $couponId)
         {
             $user = auth()->user()->find($adminId);
             // If admin id not found...
             if(!$user){
                 return response()->json([
                 "success" => false,
                 "messgae" => "Unknow Admin"
                 ],400);
             }
             // If Admin id found...
              else if($user){
                 // check if user is admin
                  if($user["groupid"]==1){
                      try{
                          $coupon = Coupon::find($couponId);
                          if($coupon==null){
                              return response()->json([
                                  "success" => true,
                                  "message" =>"coupon not found"
                                  ],200);
                          }
                          else if($coupon!=null){
                              $coupon->delete();
                              return response()->json([
                                  "success" => true,
                                  "message" =>"coupon with id $couponId successfully deleted"
                                  ],200);
                          }
                          else{
                              return;
                          }

                      } catch(Exception $e){
                      return response()->json([
                                  'success'=>false,
                                  'error'=> $e->getMessage()
                              ], 401);

                      }
                  }
                  else{
                     return response()->json([
                         "success" => true,
                         "data" =>"Sorry, only admin can delete a coupon"
                         ],200);
                  }
             }
             else{
                 return response()->json([
                     "success" => false,
                     "data" =>"Something went wrong"
                     ],200);
              }
         }
}
