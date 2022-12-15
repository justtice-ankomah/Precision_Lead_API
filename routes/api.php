<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserGroupsController;
use App\Http\Controllers\API\deliveryController;
use App\Http\Controllers\API\RiderController;
use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\ProductImagesController;
use App\Http\Controllers\API\CouponController;

//==USER
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
    //==POPULAR PRODUCT
Route::get('popular/product', [ProductsController::class, 'getAllPopularProduct']);
//==PRODUCT CATEGORY
Route::get('pcategory', [ProductCategoryController::class, 'getAllproductCategory']);
Route::get('pcategory/{id}', [ProductCategoryController::class, 'getPCategoryDetails']);
//==PRODUCT
Route::get('product', [ProductsController::class, 'getAllproducts']);
Route::get('product/{id}', [ProductsController::class, 'getProductDetails']);
Route::get('productcategory/{id}', [ProductsController::class, 'getAllproductsInCategory']);

Route::get('/', function () {
    return response()->json([
        "success" => true,
        "message" =>"wellcome"
        ],200);
});



// Authenticate all the route in this group with a middleware that checks the
// beareal token, and authenticate a user before allowing him to access the route
Route::middleware('auth:api')->group(function () {
    //===============USER=========
    // get single user Details
    Route::get('users/{id}', [UserController::class, 'getUser']);
    // get All users
    Route::get('users', [UserController::class, 'getAllUser']);
    // update a user
    Route::put('users/{id}', [UserController::class, 'updateUser']);
    // update profile picture
    Route::post('users/picture/{id}', [UserController::class, 'updateProfilePic']);
    // delete user
    Route::delete('users/{id}', [UserController::class, 'deleteUser']);
    //reset password
    Route::put('users/password/{id}', [UserController::class, 'resetPassword']);
    //===============Delivery======
    Route::post('delivery', [deliveryController::class, 'addDelivery']);
    Route::get('delivery/{userid}/{userphone}', [deliveryController::class, 'getUserDeliveries']);
    Route::get('delivery', [deliveryController::class, 'getAllDeliveries']);
    Route::delete('delivery/{id}', [deliveryController::class, 'deleteDelivery']);
    //===============RIDERS========
    Route::get('rider', [RiderController::class, 'getAllRiders']);
    Route::get('rider/{id}', [RiderController::class, 'getRiderDetails']);
    Route::put('rider/{id}', [RiderController::class, 'updateRiderDetails']);
    Route::get('rider/deliveries/new/{id}', [RiderController::class, 'getAllNewReqstDelvrys']);
    Route::get('rider/deliveries/accepted/{id}', [RiderController::class, 'getAllAcceptedDelvrys']);
    Route::get('rider/deliveries/pending/{id}', [RiderController::class, 'getAllPendingDelvrys']);
    Route::get('rider/deliveries/failed/{id}', [RiderController::class, 'getAllFailedDelvrys']);
    Route::get('rider/deliveries/passed/{id}', [RiderController::class, 'getAllPassedDelvrys']);
    Route::put('rider/deliveries/accept/{id}', [RiderController::class, 'acceptDelivery']);
    Route::put('rider/deliveries/decline/{id}', [RiderController::class, 'declineDelivery']);
    //===============ADMIN=========
    // register rider
    Route::post('register/rider/{adminId}', [RiderController::class, 'registerRider']);
    Route::delete('/rider/{adminId}/{id}', [RiderController::class, 'deleteRider']);
    // add userGroup
    Route::post('usersgroups/{adminId}', [UserGroupsController::class, 'addUserGroupId']);
    // get all userGroups
    Route::get('usersgroups', [UserGroupsController::class, 'getAllUserGroups']);
    // get single userGroup
    Route::get('usersgroups/{id}', [UserGroupsController::class, 'getUserGroup']);
    // update userGroup
    Route::put('usersgroups/{adminId}/{id}', [UserGroupsController::class, 'updateUserGroup']);
    // delete userGroup
    Route::delete('usersgroups/{adminId}/{id}', [UserGroupsController::class, 'deleteUserGroup']);
    //==PRODUCT CATEGORY
    Route::post('pcategory/{adminId}', [ProductCategoryController::class, 'addProductCategory']);
    Route::post('pcategory/{adminId}/{id}', [ProductCategoryController::class, 'updatePCategoryDetails']);
    Route::delete('pcategory/{adminId}/{id}', [ProductCategoryController::class, 'deleteProductCategory']);
    //==PRODUCT
    Route::put('product/{adminId}/{id}', [ProductsController::class, 'updateProductDetails']);
    Route::delete('product/{adminId}/{id}', [ProductsController::class, 'deleteProduct']);
    Route::post('product/{adminId}', [ProductsController::class, 'addProduct']);
    Route::post('productimages/{adminId}/{id}', [ProductImagesController::class, 'addMoreImagesToProduct']);
    //==COUPON
    Route::post('coupon/{adminId}', [CouponController::class, 'createCoupon']);
    Route::post('coupon/code/verify', [CouponController::class, 'verifyCouponCode']);
    Route::get('coupon', [CouponController::class, 'getAllCoupon']);
    Route::get('coupon/{id}', [CouponController::class, 'getCouponDetails']);
    Route::put('coupon/{adminId}/{id}', [CouponController::class, 'updateCoupon']);
    Route::delete('coupon/{adminId}/{id}', [CouponController::class, 'deleteCoupon']);
});







