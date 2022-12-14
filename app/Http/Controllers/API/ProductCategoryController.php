<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Validator;


class ProductCategoryController extends Controller{
        //   Get All Categeories
           public function getAllproductCategory(Request $request){
            try{
                $prdctCategory = ProductCategory::all();
                for($i=0; $i<$prdctCategory->count(); $i++){
                    // convert the following to int
                    $prdctCategory[$i]->addedByAdminId=(int) $prdctCategory[$i]->addedByAdminId;
                }
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
                        'categoryName' => 'required|min:2',
                        'icon' => 'required|image',
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
                            $iconName = time().".".$request->icon->extension();
                            $request->icon->move(public_path('images'),$iconName);
                            $path = "public/images/$iconName";

                        $newProductCategory = ProductCategory::create([
                            'categoryName' => $request->categoryName,
                            'icon' => stripcslashes($path),
                            'addedByAdminId' => $adminId,
                        ]);
                        $newProductCategory->addedByAdminId=(int) $newProductCategory->addedByAdminId;
                        return response()->json([
                            'success'=>true,
                            'message'=> 'New product category successfully added',
                            "category"=>$newProductCategory
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
            if (!$request->has('icon') || !$request->has('categoryName')) {
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
                         $productCategory = ProductCategory::find($categoryId);
                         if($productCategory==null){
                             return response()->json([
                                 "success" => true,
                                 "message" =>"Product Category not found"
                                 ],200);
                         }
                         else if($productCategory!=null){
                            $iconName = time().".".$request->icon->extension();
                            $request->icon->move(public_path('images'),$iconName);
                            $path = "public/images/$iconName";

                            $productCategory->categoryName=$request->categoryName;
                            $productCategory->addedByAdminId=$request->$adminId;
                            $productCategory->icon= stripcslashes($path);
                             $productCategory->save();

                             return response()->json([
                                 "success" => true,
                                 "message" =>"Product Category with id $categoryId successfully Updated",
                                 "category"=>ProductCategory::find($categoryId)
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
                $productCategory->addedByAdminId=(int) $productCategory->addedByAdminId;
                return response()->json([
                "success" => true,
                "category" => $productCategory->toArray()
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
