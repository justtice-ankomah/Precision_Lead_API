<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hamcrest\Text\IsEqualIgnoringWhiteSpace;
use Illuminate\Http\Request;
use App\Models\Deliveries;
use Validator;
Use Exception;
use Carbon\Carbon;

class RiderController extends Controller
{

        // Get All Riders
        public function getAllRiders(Request $request){
            try{
                $riders = User::where(["groupid"=>3])->get();

                $allRiders=[];

                for($i=0; $i<count($riders); $i++){
                    if(count($riders)>0){
                        $riders[$i]->groupid=(int) $riders[$i]->groupid;
                        array_push( $allRiders, $riders[$i]);
                    }
                }

                return response()->json([
                    "success" => true,
                    "riders" =>$allRiders
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
                $rider[0]->groupid=(int)  $rider[0]->groupid;
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

           // get all Accepted deliveries for a rider
           public function getAllAcceptedDelvrys($id)
           {
               try{
           $deliveries = Deliveries::where(["riderId"=> $id, "status"=>"ACCEPTED"])->get();
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
        $deliveries = Deliveries::where(["riderId"=> $id, "status"=>"PENDING", "isDelvStarted"=>"YES"])->get();
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

                 // Start delivery
                 public function startDelivery(Request $request, $id){
                    try{
                        $delivery = Deliveries::find($id);
                        //if delivery found
                        if($delivery){
                            // check if delivery already ACCEPTED
                            if($delivery["status"] =="ACCEPTED"){
                                $delivery->status="PENDING";
                                $delivery->isDelvStarted="YES";
                                // get the current dateTime to set the delivery started date
                                $currentTime = Carbon::now();
                                $delivery->delvStartDate=$currentTime->toDateTimeString();
                                $delivery->save();
                                return response()->json([
                                    "success" => true,
                                    "message" =>"Delivery started"
                                    ],200);
                            }
                            // if delivery not accepted
                            else if($delivery["status"] =="UNACCEPTED"){
                                return response()->json([
                                    "success" => true,
                                    "message" =>"Accept the delivery first"
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

                // End delivery
                // reason below should either be "PASSED" or "FAILED"
                public function endDelivery(Request $request, $id){
                try{
                    $delivery = Deliveries::find($id);
                    //if delivery found
                    if($delivery){
                        $validator = Validator::make($request->all(), [
                            'reason' => 'required'
                        ]);
                         //if validation fails
                         if ($validator->fails()) {
                            return response()->json([
                               "success"=>false,
                               "message"=>"<reason> body value is required"
                           ], 400);
                       }
                        //if reason for ending message not equals: "PASSED" or "FAILED"
                       else if ((strtoupper(trim($request->reason)) != "PASSED") || (strtoupper(trim($request->reason)) != "FAILED")){
                                return response()->json([
                                "success"=>false,
                                // "message"=>"Not equals PASSED " . $request->reason
                                "message"=>"<reason> for ending delivery must be: PASSED or FAILED " . "you entered (" . $request->reason .")"
                            ], 400);
                        }
                            //if validation passed
                        else {
                            // check if delivery is already PENDING (meaning it already started)
                            // that means you can only end a delivery when it pending/started
                            if($delivery["status"] =="PENDING"){
                                $delivery->status=$request->reason;
                                $delivery->isDelvStarted="ENDED";
                                // get the current dateTime to set the deliveryEndede date
                                $currentTime = Carbon::now();
                                $delivery->delvEndDate=$currentTime->toDateTimeString();
                                $delivery->save();
                                return response()->json([
                                    "success" => true,
                                    "message" =>"Delivery Ended"
                                    ],200);
                            }
                            // if delivery not started
                            else if($delivery["status"] =="ACCEPTED"){
                                return response()->json([
                                    "success" => flase,
                                    "message" =>"Start the delivery first"
                                    ],200);
                            }
                            else{
                                return response()->json([
                                    "success" => false,
                                    "message" =>"Not Allowed",
                                    "delivery"=>$delivery
                                    ],200);
                            }
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

                   // delete rider
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
