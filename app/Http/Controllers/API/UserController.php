<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
// use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
Use Exception;

class UserController extends Controller
{
    /**
     * Registration a user
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|min:2',
            'username' => 'required|min:2',
            'groupid'=>'required|numeric',
            'phonenumber'=>'required|min:10|max:10',
            'address'=>'required',
            'password' => 'required|min:6',
            'locationLat'=>'nullable',
            'locationLnt'=>'nullable',
            'locationName'=>'nullable',

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
                'groupid' => $request->groupid,
                'address' => $request->address,
                'locationLat' => $request->locationLat,
                'locationLnt' => $request->locationLnt,
                'locationName' => $request->locationName,
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

    /**
     * Login Req
     */
    public function login(Request $request){
        $data = [
            'username' => $request->username,
            'password' => $request->password
        ];
        //if auth user found
        if (auth('web')->attempt($data)) {
            $token = auth('web')->user()->createToken('Laravel-9-Passport-Auth')->accessToken;
            // get the user details
           $user = User::where("username",$request->username)->get();
           // convert the groupid to int
           $user[0]->groupid = (int)$user[0]->groupid;
            return response()->json([
                'success'=>true,
                'token' => $token,
                'user'=>$user[0]
            ], 200);
        }
         //if auth user Not found
        else {
            return response()->json([
                'success'=>false,
                'error' => 'user not found'
            ], 401);
        }
    }

    public function getUser($id)
    {
     $user = auth()->user()->find($id);
        // If user id not found...
        if(!$user){
            return response()->json([
            "success" => false,
            "messgae" => "User with id ".$id." not found"
            ],400);
        }
        // If user id found...
         else{
            return response()->json([
            "success" => true,
            "data" => $user->toArray()
            ],200);
        }

    }

    public function getAllUser(){
        try{
            $allUsers = User::all();

            return response()->json([
             "success" => true,
             "users" =>$allUsers
             ],200);
        } catch(Exception $e){
        return response()->json([
                    'success'=>false,
                    'error'=> $e->getMessage()
                ], 401);

        }


    }

    public function updateUser(Request $request, $id){
        try{
            $users = User::find($id);
            $users->fullname=$request->fullname;
            $users->username=$request->username;
            $users->phonenumber=$request->phonenumber;
            $users->address=$request->address;
            $users->locationLat=$request->locationLat;
            $users->locationLnt=$request->locationLnt;
            $users->locationName=$request->locationName;
            $users->locationDesc=$request->locationDesc;
            $users->save();

            return response()->json([
             "success" => true,
             "message" =>"successfully updated"
             ],200);
        } catch(Exception $e){
        return response()->json([
                    'success'=>false,
                    'error'=> $e->getMessage()
                ], 401);

        }
    }
   // Delete user
    public function deleteUser(Request $request, $id){
        try{
            $users = User::find($id);
            if($users==null){
                return response()->json([
                    "success" => true,
                    "message" =>"User not found"
                    ],200);
            }
            else{
                $users->delete();
                return response()->json([
                    "success" => true,
                    "message" =>"User with id $id successfully deleted"
                    ],200);
            }

        } catch(Exception $e){
        return response()->json([
                    'success'=>false,
                    'error'=> $e->getMessage()
                ], 401);

        }
    }

       // Update user profile-Image
       public function updateProfilePic(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'picture' => 'nullable|image',
        ]);
        //if validation fails
        if ($validator->fails()) {
             return response()->json([
                "success"=>false,
                "message"=>"File Validation error"
            ], 400);
        }
          //if validation passed
        else{
            try{
                $users = User::find($id);
                if($users==null){
                    return response()->json([
                        "success" => true,
                        "message" =>"User not found"
                        ],200);
                }
                else{
                   // proccess is here the image here

                   // get the image file extension and add the current time to it. EG: 1200.png
                   // "picture" represent the json key the client will use to upload the image
                   $fileName = time().".".$request->picture->extension();
                   //move(path_to_move_to, when_I_move_the_file_what_name_should_i_store_it)
                   // this will move it to the public/images ( the public_path() method represent the "public" directory in your project)
                   $request->picture->move(public_path('images'),$fileName);
                   // define a variable that holds the path of the image eg: public/images/1200.png
                   $path = "public/images/$fileName";
                   // update the user profile url, so that you can open it when you fetch the api
                   $users->profileUrl=$path;
                   // update the user details in the database
                   $users->update();

                    return response()->json([
                        "success" => true,
                        "message" =>  "Profile picture successfully updated"
                        ],200);

                }

            } catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'error'=> $e->getMessage()
                    ], 401);

            }
        }
    }

    // Reset User password
    public function resetPassword(Request $request, $id){
        $validator = Validator::make($request->all(), [
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
                $users = User::find($id);
                if($users==null){
                    return response()->json([
                        "success" => true,
                        "message" =>"User not found"
                        ],200);
                }
                else{
                    $users->password=bcrypt($request->password);
                    $users->save();

                    return response()->json([
                    "success" => true,
                    "message" =>"Password successfully reset"
                    ],200);
                }

            } catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'error'=> $e->getMessage()
                    ], 401);

            }
        }
    }

}
