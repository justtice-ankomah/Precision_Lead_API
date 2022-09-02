<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\User;
use Validator;


class ProductCategoryController extends Controller{


        //   Get All Categeories
           public function getAllproductCategory(Request $request){
            try{
                $prdctCategory = ProductCategory::all();
                return response()->json([
                    "success" => true,
                    "categories" =>$prdctCategory
                    ],200);
            }
            catch(Exception $e){
                return response()->json([
                            'success'=>false,
                            'error'=> $e->getMessage()
                        ], 401);
                }
        }

        // add a Category
        public function addProductCategory(Request $request, $adminId)  {
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
                    $validator = Validator::make($request->all(), [
                        'categoryName' => 'required|min:2'
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
                        $newProductCategory = ProductCategory::create([
                            'categoryName' => $request->categoryName,
                            'addedByAdminId' => $adminId,
                        ]);
                        return response()->json([
                            'success'=>true,
                            'message'=> 'New product category successfully added',
                            "user"=>$newProductCategory
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

        // Delete Category
        public function deleteProductCategory(Request $request, $adminId, $categoryId)
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
                         $productCategory = ProductCategory::find($categoryId);
                         if($productCategory==null){
                             return response()->json([
                                 "success" => true,
                                 "message" =>"Product Category not found"
                                 ],200);
                         }
                         else if($productCategory!=null){
                             $productCategory->delete();
                             return response()->json([
                                 "success" => true,
                                 "message" =>"Product Category with id $categoryId successfully deleted"
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
                        "data" =>"Sorry, only admin can delete a Product Category"
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

        // upate category details
        public function updatePCategoryDetails(Request $request, $adminId, $categoryId){
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
                         $productCategory = ProductCategory::find($categoryId);
                         if($productCategory==null){
                             return response()->json([
                                 "success" => true,
                                 "message" =>"Product Category not found"
                                 ],200);
                         }
                         else if($productCategory!=null){
                            $productCategory->categoryName=$request->categoryName;
                            $productCategory->addedByAdminId=$request->$adminId;
                             $productCategory->save();

                             return response()->json([
                                 "success" => true,
                                 "message" =>"Product Category with id $categoryId successfully Updated"
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
                        "data" =>"Sorry, only admin can update a Product Category"
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

        public function getPCategoryDetails($categoryId){
            try{
         $productCategory = ProductCategory::find($categoryId);
            // If productCategory id not found...
            if(!$productCategory){
                return response()->json([
                "success" => true,
                "messgae" => "Product Category with id ".$categoryId." not found"
                ],200);
            }
            // If productCategory id found...
             else if($productCategory){
                return response()->json([
                "success" => true,
                "rider" => $productCategory->toArray()
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
