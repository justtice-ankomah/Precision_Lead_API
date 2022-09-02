<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\User;
use Validator;
use App\Models\ProductImages;



class ProductsController extends Controller{


        //   Get All Products
           public function getAllproducts(Request $request){
            try{
                $products = Products::all();

                $allProductImages = ProductImagesController::returnAllImages();



                for($pi=0; $pi<$products->count(); $pi++){
                    $allSingleProdtImages=[];

                    for($i=0; $i<count($allProductImages); $i++){
                        if($products[$pi]->id==$allProductImages[$i]->productId){
                            array_push( $allSingleProdtImages, $allProductImages[$i]->imageUrls);
                        }
                    }

                    $products[$pi]->productImageUrls =  $allSingleProdtImages;

                // get product category details
                $productCategoryController =  new ProductCategoryController();
                $result =  $productCategoryController->getPCategoryDetails($products[$pi]->productCategoryID);
                // the "original" is a value added by laravel by default
                if(isset($result->original)){
                    // $pCategoryDetails = $pCategory["category"];
                    $products[$pi]->productCategory= $result->original["category"];
                }
                else{
                    return response()->json([
                        'success'=>false,
                        'error'=> "couldn't fetch product category details"
                    ], 401);
                }
                }

                return response()->json([
                    "success" => true,
                    "products" =>$products
                    ],200);
            }
            catch(Exception $e){
                return response()->json([
                            'success'=>false,
                            'error'=> $e->getMessage()
                        ], 401);
                }
        }

        // Get all products in a particular category
        public function getAllproductsInCategory(Request $request, $categoryId){
            try{
                $products = Products::where("productCategoryID",$categoryId)->get();

                $allProductImages = ProductImagesController::returnAllImages();

                for($pi=0; $pi<$products->count(); $pi++){
                    $allSingleProdtImages=[];

                    for($i=0; $i<count($allProductImages); $i++){
                        if($products[$pi]->id==$allProductImages[$i]->productId){
                            array_push( $allSingleProdtImages, $allProductImages[$i]->imageUrls);
                        }
                    }

                    $products[$pi]->productImageUrls =  $allSingleProdtImages;

                // get product category details
                $productCategoryController =  new ProductCategoryController();
                $result =  $productCategoryController->getPCategoryDetails($products[$pi]->productCategoryID);
                // the "original" is a value added by laravel by default
                if(isset($result->original)){
                    // $pCategoryDetails = $pCategory["category"];
                    $products[$pi]->productCategory= $result->original["category"];
                }
                else{
                    return response()->json([
                        'success'=>false,
                        'error'=> "couldn't fetch product category details"
                    ], 401);
                }
                }

                return response()->json([
                    "success" => true,
                    "products" =>$products
                    ],200);
            }
            catch(Exception $e){
                return response()->json([
                            'success'=>false,
                            'error'=> $e->getMessage()
                        ], 401);
                }
        }


        // Get Single product details
        public function getProductDetails(Request $request, $productId){
            try{
         $products = Products::find($productId);
            // If product id not found...
            if(!$products){
                return response()->json([
                "success" => true,
                "messgae" => "Product with id ".$productId." not found"
                ],200);
            }
            // If product id found...
             else if($products){
                // get product category details
                $productCategoryController =  new ProductCategoryController();
                $result =  $productCategoryController->getPCategoryDetails($products->productCategoryID);
                // the "original" is a value added by laravel by default
                if(isset($result->original)){
                    // $pCategoryDetails = $pCategory["category"];
                    $products->productCategory= $result->original["category"];
                }
                else{
                    return response()->json([
                        'success'=>false,
                        'error'=> "couldn't fetch product category details"
                    ], 401);
                }

                $allImages = ProductImagesController::returnSingleProductImages($request, $productId);
                $products->productImageUrls= $allImages;

                return response()->json([
                "success" => true,
                "product"=>$products,
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

  // upate Product details
  public function updateProductDetails(Request $request, $adminId, $productId){
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
                 $products = Products::find($productId);
                 if($products==null){
                     return response()->json([
                         "success" => true,
                         "message" =>"Product not found"
                         ],200);
                 }
                 else if($products!=null){
                    $products->price=$request->price;
                    $products->name=$request->name;
                    $products->description=$request->description;
                    $products->productCategoryID=$request->productCategoryID;
                    $products->quantityAvailable=$request->quantityAvailable;
                     $products->save();

                     return response()->json([
                         "success" => true,
                         "message" =>"Product with id $productId successfully Updated"
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
                "data" =>"Sorry, only admin can update a Product"
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

    // Delete Product
    public function deleteProduct(Request $request, $adminId, $productId)
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
                     $products = Products::find($productId);
                     if($products==null){
                         return response()->json([
                             "success" => true,
                             "message" =>"Product not found"
                             ],200);
                     }
                     else if($products!=null){
                         $products->delete();
                         return response()->json([
                             "success" => true,
                             "message" =>"Product with id $productId successfully deleted"
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
                    "data" =>"Sorry, only admin can delete a Product"
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

        // add a Product
        public function addProduct(Request $request, $adminId) {
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
                        'name' => 'required|min:2',
                        'price' => 'required|numeric',
                        'description' => 'nullable',
                        'productCategoryID' => 'required|numeric',
                        'productImage' => 'required|image',
                        'quantityAvailable' => 'required|numeric'
                    ]);
                    // if validation fails
                    if ($validator->fails()) {
                         return response()->json([
                            "success"=>false,
                            "message"=>"Product Validation error, please check the product details"
                        ], 400);
                    }
                      //if validation passed
                    else{
                        try{
                            $imageName = time().".".$request->productImage->extension();
                            $request->productImage->move(public_path('images'),$imageName);
                            $path = "public/images/$imageName";

                        $products = Products::create([
                            'name' => $request->name,
                            'price' => (int) $request->price,
                            'description' => $request->description,
                            'productCategoryID' => (int) $request->productCategoryID,
                            'quantityAvailable' => (int) $request->quantityAvailable,
                            'addedByAdminId' => (int) $adminId,
                            'productImageUrls' => stripcslashes($path),
                        ]);

                        ProductImages::create([
                            'productID'=>$products->id,
                            'imageUrls'=>$products->productImageUrls
                        ]);

                        return response()->json([
                            'success'=>true,
                            'message'=> 'New product successfully added',
                            "product"=>$products
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
                        "data" =>"Sorry, only admin can add product"
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
