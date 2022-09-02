<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserGroupsId;
use App\Models\User;
Use Exception;

class UserGroupsController extends Controller
{

    public function addUserGroupId(Request $request, $adminId) {

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
                    $userGroupsId = new UserGroupsId;
                    $userGroupsId->name=$request->name;
                    $userGroupsId->save();
                    return response()->json([
                        'success'=>true,
                        'message'=> "new usergroupid added"
                    ], 200);
                }
                catch(Exception $e){
                    return response()->json([
                               'success'=>false,
                               'error'=> $e->getMessage()
                           ], 401);
                       }
             }
             else{
                return response()->json([
                    "success" => true,
                    "data" =>"Sorry, only admin can add user groups"
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

       // Delete userGroup
       public function deleteUserGroup(Request $request, $adminId, $id){
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
                    $userGroupsId = UserGroupsId::find($id);
                    if($userGroupsId==null){
                        return response()->json([
                            "success" => true,
                            "message" =>"userGroupsId not found"
                            ],200);
                    }
                    else{
                        $userGroupsId->delete();
                        return response()->json([
                            "success" => true,
                            "message" =>"userGroupsId with id $id successfully deleted"
                            ],200);
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
                   "data" =>"Sorry, only admin can delete user groups"
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

    // Udate userGroup
    public function updateUserGroup(Request $request, $adminId, $id){
        try{
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
                $userGroupsId = UserGroupsId::find($id);
                if($userGroupsId ==null){
                    return response()->json([
                        "success" => true,
                        "message" =>"user Group not found"
                        ],200);
                }
                else{
                    $userGroupsId->name=$request->name;
                    $userGroupsId->save();
                    return response()->json([
                     "success" => true,
                     "message" =>"successful updated"
                     ],200);
                }

            }
            else{
               return response()->json([
                   "success" => true,
                   "data" =>"Sorry, only admin can add user groups"
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
        catch(Exception $e){
        return response()->json([
                    'success'=>false,
                    'error'=> $e->getMessage()
                ], 401);

        }
    }

    // get all userGroups
    public function getAllUserGroups(){
        try{
            $allUserGroupsId = UserGroupsId::all();

            return response()->json([
             "success" => true,
             "users" =>$allUserGroupsId
             ],200);
        } catch(Exception $e){
        return response()->json([
                    'success'=>false,
                    'error'=> $e->getMessage()
                ], 401);
        }
    }

    // get single userGroup details
    public function getUserGroup($id)
    {
     $userGroupsId =UserGroupsId::find($id);
        // If user id not found...
        if(!$userGroupsId){
            return response()->json([
            "success" => false,
            "messgae" => "UserGroup with id ".$id." not found"
            ],400);
        }
        // If user id found...
         else{
            return response()->json([
            "success" => true,
            "data" => $userGroupsId->toArray()
            ],200);
        }

    }

}
