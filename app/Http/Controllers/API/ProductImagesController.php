<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\User;
use Validator;


class ProductImagesController extends Controller
{


    // Get and return all the images of a single product to other functions
    public static function returnSingleProductImages(Request $request, $productId){
        try{
            $productImages = ProductImages::where("productID",$productId)->get();

            $allImages=[];

            for($i=0; $i<$productImages->count(); $i++){
                $images = $productImages[$i]->imageUrls;
                array_push( $allImages,$images);
            }

            // return all this product images
            return $allImages;
        }
        catch(Exception $e){
            return response()->json([
                       'success'=>false,
                       'error'=> $e->getMessage()
                   ], 401);
               }
    }

    // Get and return all product images to other functions
    public static function returnAllImages(){
        try{
            $productImages = ProductImages::all();

            $allImages=[];

            for($i=0; $i<$productImages->count(); $i++){
                // $images = $productImages[$i]->imageUrls;
                $pObject = (object) array("productId"=>$productImages[$i]->productID,"imageUrls"=>$productImages[$i]->imageUrls);

                array_push( $allImages,$pObject);
            }

            // return all this product images
            return $allImages;
        }
        catch(Exception $e){
            return response()->json([
                       'success'=>false,
                       'error'=> $e->getMessage()
                   ], 401);
               }
    }

        //add More images of a particular product
  public function addMoreImagesToProduct(Request $request, $adminId, $productId){
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
                'productimage' => 'nullable|image',
            ]);
            //if validation fails
            if ($validator->fails()) {
                 return response()->json([
                    "success"=>false,
                    "message"=>"Product Image Validation error, please check the product details"
                ], 400);
            }
              //if validation passed
            else{
                try{
                    // if product is not found
                    $products = Products::find($productId);
                    if($products==null){
                        return response()->json([
                            "success" => true,
                            "message" =>"Product not found"
                            ],200);
                    }
                      // if product is found
                    else{

                    $imageName = time().".".$request->productimage->extension();
                    $request->productimage->move(public_path('images'),$imageName);
                    $path = "public/images/$imageName";
                   $productImages = ProductImages::create([
                        'productID'=>$products->id,
                        'imageUrls'=>stripcslashes($path)

                    ]);
                    }


                return response()->json([
                    'success'=>true,
                    'message'=> 'Product Image successfully added',
                    "product"=>$productImages
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
                "data" =>"Sorry, only admin can add product Image"
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
