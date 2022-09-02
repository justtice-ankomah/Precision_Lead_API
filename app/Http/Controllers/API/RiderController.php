<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Deliveries;
use Validator;
Use Exception;

class RiderController extends Controller
{

        // Get All Riders
        public function getAllRiders(Request $request){
            try{
                $riders = User::where(["groupid"=>3])->get();
                return response()->json([
                    "success" => true,
                    "riders" =>$riders
                    ],200);

            }
            catch(Exception $e){
                return response()->json([
                            'success'=>false,
                            'error'=> $e->getMessage()
                        ], 401);
                }

        }

        public function getRiderDetails($id){
            try{
         $rider = User::where(["groupid"=>3,"id"=> $id])->get();
            // If user id not found...
            if(count($rider)==0){
                return response()->json([
                "success" => true,
                "messgae" => "Rider with id ".$id." not found"
                ],200);
            }
            // If user id found...
             else if(count($rider) >0){
                return response()->json([
                "success" => true,
                "rider" => $rider[0]->toArray()
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

        public function updateRiderDetails(Request $request, $id){
            try{
                $rider = User::find($id);
                $rider->fullname=$request->fullname;
                $rider->username=$request->username;
                $rider->phonenumber=$request->phonenumber;
                $rider->address=$request->address;
                $rider->locationLat=$request->locationLat;
                $rider->locationLnt=$request->locationLnt;
                $rider->locationName=$request->locationName;
                $rider->locationDesc=$request->locationDesc;
                $rider->save();

                return response()->json([
                 "success" => true,
                 "message" =>"successful"
                 ],200);
            } catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'error'=> $e->getMessage()
                    ], 401);

            }
        }

        // get all newly requested deliveries for a rider
        public function getAllNewReqstDelvrys($id)
        {
            try{
         $deliveries = Deliveries::where(["riderId"=> $id, "status"=>"UNACCEPTED"])->get();
                return response()->json([
                "success" => true,
                "deliveries" => $deliveries
                ],200);
        }
        catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'error'=> $e->getMessage()
                    ], 401);
            }

        }

        // get all Pending deliveries for a rider
        public function getAllPendingDelvrys($id)
        {
            try{
        $deliveries = Deliveries::where(["riderId"=> $id, "status"=>"PENDING"])->get();
                return response()->json([
                "success" => true,
                "deliveries" => $deliveries
                ],200);
        }
        catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'error'=> $e->getMessage()
                    ], 401);
            }
        }

        // get all Failed deliveries for a rider
        public function getAllFailedDelvrys($id)
        {
            try{
        $deliveries = Deliveries::where(["riderId"=> $id, "status"=>"FAILED"])->get();
                return response()->json([
                "success" => true,
                "deliveries" => $deliveries
                ],200);
        }
        catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'error'=> $e->getMessage()
                    ], 401);
            }

        }


        // get all PASSED deliveries for a rider
        public function getAllPassedDelvrys($id)
        {
            try{
        $deliveries = Deliveries::where(["riderId"=> $id, "status"=>"PASSED"])->get();
                return response()->json([
                "success" => true,
                "deliveries" => $deliveries
                ],200);
        }
        catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'error'=> $e->getMessage()
                    ], 401);
            }

        }

        // Accept delivery
        public function acceptDelivery(Request $request, $id){
            try{
                $delivery = Deliveries::find($id);
                //if delivery found
                if($delivery){
                    // check if delivery is not already accepted
                    if($delivery["status"] =="UNACCEPTED"){
                        $delivery->status="ACCEPTED";
                        $delivery->save();
                        return response()->json([
                            "success" => true,
                            "message" =>"Delivery accepted"
                            ],200);
                    }
                    // if delivery is already accepted
                    else if($delivery["status"] =="ACCEPTED"){
                        return response()->json([
                            "success" => true,
                            "message" =>"Already accepted"
                            ],200);
                    }
                    else{
                        return response()->json([
                            "success" => true,
                            "message" =>"Not Allowed",
                            "delivery"=>$delivery
                            ],200);
                    }
                }
                else{
                    return response()->json([
                        "success" => true,
                        "message" =>"Deliveery not found"
                        ],200);
                }
            } catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'error'=> $e->getMessage()
                    ], 401);

            }
        }

                // Decline delivery
                public function declineDelivery(Request $request, $id){
                    try{
                        $delivery = Deliveries::find($id);
                        //if delivery found
                        if($delivery){
                            // check if delivery is not already accepted
                            if($delivery["status"] =="UNACCEPTED"){
                                $delivery->status="DECLINED";
                                $delivery->save();
                                return response()->json([
                                    "success" => true,
                                    "message" =>"Delivery declined"
                                    ],200);
                            }
                            // if delivery is already DECLINED
                            else if($delivery["status"] =="DECLINED"){
                                return response()->json([
                                    "success" => true,
                                    "message" =>"Already Declined"
                                    ],200);
                            }
                            else{
                                return response()->json([
                                    "success" => true,
                                    "message" =>"Not Allowed",
                                    "delivery"=>$delivery
                                    ],200);
                            }
                        }
                        else{
                            return response()->json([
                                "success" => true,
                                "message" =>"Deliveery not found"
                                ],200);
                        }
                    } catch(Exception $e){
                    return response()->json([
                                'success'=>false,
                                'error'=> $e->getMessage()
                            ], 401);

                    }
                }

                // Register rider
                public function registerRider(Request $request, $adminId)  {
                    $user = auth()->user()->find($adminId);
                    // If user id not found...
                    if(!$user){
                        return response()->json([
                        "success" => false,
                        "messgae" => "Unknow Admin"
                        ],400);
                    }
                    // If user id found...
                     else if($user){
                        // check if user is admin
                         if($user["groupid"]==1){
                            $validator = Validator::make($request->all(), [
                                'fullname' => 'required|min:2',
                                'username' => 'required|min:2',
                                'phonenumber'=>'required|min:10|max:10',
                                'address'=>'required|min:2',
                                'password' => 'required|min:6',
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
                                $user = User::create([
                                    'fullname' => $request->fullname,
                                    'username' => $request->username,
                                    'phonenumber' => $request->phonenumber,
                                    'groupid' => 3,
                                    'address' => $request->address,
                                    'password' => bcrypt($request->password)
                                ]);
                             $token = $user->createToken('Laravel-9-Passport-Auth')->accessToken;
                                return response()->json([
                                    'success'=>true,
                                    'message'=> 'registration successful',
                                    "user"=>$user,
                                    'token' => $token
                                ], 200);
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
                                "data" =>"Sorry, only admin can register riders"
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

                   // Register rider
                   // $request= request_object $adminId=adminId $id=User_to_delete_ID
                   public function deleteRider(Request $request, $adminId, $id)
                   {
                       $user = auth()->user()->find($adminId);
                       // If user id not found...
                       if(!$user){
                           return response()->json([
                           "success" => false,
                           "messgae" => "Unknow Admin"
                           ],400);
                       }
                       // If user id found...
                        else if($user){
                           // check if user is admin
                            if($user["groupid"]==1){
                                try{
                                    $users = User::find($id);
                                    if($users==null){
                                        return response()->json([
                                            "success" => true,
                                            "message" =>"Rider not found"
                                            ],200);
                                    }
                                    else if($users["groupid"]==3){
                                        $users->delete();
                                        return response()->json([
                                            "success" => true,
                                            "message" =>"Rider with id $id successfully deleted"
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
                                   "data" =>"Sorry, only admin can delete riders"
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
