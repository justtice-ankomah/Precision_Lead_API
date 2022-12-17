<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\RidersLiveLocation;

class RidersLiveLocationController extends Controller
{
                    // method to add new location
                    public function addNewLiveLocation(Request $request)  {
                                $validator = Validator::make($request->all(), [
                                    'deliveryId' => 'required',
                                    'locationLat' => 'required',
                                    'locationLnt'=>'required',
                                    'locationName'=>'',
                                    'locationDesc' => ''
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
                                    $locationInfo = RidersLiveLocation::create([
                                        'deliveryId' => $request->deliveryId,
                                        'locationLat' => $request->locationLat,
                                        'locationLnt' => $request->locationLnt,
                                        'locationName' => $request->locationName,
                                        'locationDesc' => $request->locationDesc
                                    ]);
                                    return response()->json([
                                        'success'=>true,
                                        'message'=> 'Rider current location posted',
                                        "user"=>$locationInfo,
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

                    //Update Live-location of a rider
                    public function updateLiveLocation(Request $request, $id){
                        try{
                            $liveLocation = RidersLiveLocation::find($id);
                            $liveLocation->locationLat=$request->locationLat;
                            $liveLocation->locationLnt=$request->locationLnt;
                            $liveLocation->locationName=$request->locationName;
                            $liveLocation->locationDesc=$request->locationDesc;
                            $liveLocation->save();

                            $reFindliveLocation = RidersLiveLocation::find($id);
                            return response()->json([
                             "success" => true,
                             "message" =>"Rider Live location successfully updated",
                             "user"=> $reFindliveLocation
                             ],200);
                        } catch(Exception $e){
                        return response()->json([
                                    'success'=>false,
                                    'error'=> $e->getMessage()
                                ], 401);

                        }
                    }

                     // method to get the rider-live-location
                     // $id == deliveryId
                    public function getRiderLiveLocation($id){
                        try{
                        $liveLocation = RidersLiveLocation::where(["deliveryId"=>$id])->get();
                        if(count($liveLocation)==0){
                            return response()->json([
                            "success" => true,
                            "messgae" => "live Location not found for delivery with id ".$id
                            ],200);
                        }
                        else if(count($liveLocation) >0){
                            return response()->json([
                            "success" => true,
                            "liveLocation" => $liveLocation[0]->toArray()
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

}
