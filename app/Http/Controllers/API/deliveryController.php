<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Deliveries;
use App\Http\Controllers\Controller;
use App\Models\User;

class deliveryController extends Controller
{

     // when a new delivery item is added with this method
    public function addDelivery(Request $request)
    {
        try{
            $deliveriesModel = new Deliveries;
            $deliveriesModel->pickUpItemName=$request->pickUpItemName;
            $deliveriesModel->pickUpItemCategory=$request->pickUpItemCategory;
            $deliveriesModel->pickUpItemDesc=$request->pickUpItemDesc;
            $deliveriesModel->senderId=$request->senderId;
            $deliveriesModel->receiverId=$request->receiverId;
            $deliveriesModel->receiverName=$request->receiverName;
            $deliveriesModel->reciverContact=$request->reciverContact;
            $deliveriesModel->reciverIdNumber=$request->reciverIdNumber;
            $deliveriesModel->riderId=$request->riderId;
            $deliveriesModel->paymentMethod=$request->paymentMethod;
            $deliveriesModel->totalCostAmount=$request->totalCostAmount;
            $deliveriesModel->paymentType=$request->paymentType;
            $deliveriesModel->deliveryCostAmount=$request->deliveryCostAmount;
            $deliveriesModel->pickUpLocationLat=$request->pickUpLocationLat;
            $deliveriesModel->pickUpLocationLnt=$request->pickUpLocationLnt;
            $deliveriesModel->pickUpLocationName=$request->pickUpLocationName;
            $deliveriesModel->pickUpLocationDesc=$request->pickUpLocationDesc;
            $deliveriesModel->destLocationLat=$request->destLocationLat;
            $deliveriesModel->destLocationLnt=$request->destLocationLnt;
            $deliveriesModel->destLocationName=$request->destLocationName;
            $deliveriesModel->destLocationDesc=$request->destLocationDesc;
            $deliveriesModel->productList=json_decode($request->productList);
            // check if user did buy a product with this delivery product
            if($request->productList !=null){
                $deliveriesModel->didUserBuyProduct="YES";
            }

            if($request->senderId ==$request->receiverId){
                $deliveriesModel->deliveryType="INCOMING";
            }
            else if($request->receiverId !=null && ($request->senderId != $request->receiverId)){
                $deliveriesModel->deliveryType="UNKNOWN";
            }
            else{
                $deliveriesModel->deliveryType="UNKNOWN";
            }
            // generate deliveryCode for this delivery
            $deliveriesModel->deliveryCode="pr".strval(time())."d";
            $deliveriesModel->save();
            return response()->json([
                'success'=>true,
                'message'=> "request successful"
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                       'success'=>false,
                       'error'=> $e->getMessage()
                   ], 401);

               }
    }

    // method to get all the deliveries of a particular user
    public function getUserDeliveries(Request $request, $userId, $userphone)
    {
        try{
         $allDeliveries =[];

    $senderDeliveries = Deliveries::where(function ($query)  use ($userId){
        $query->where('senderId', '=', $userId)
              ->orWhere('receiverId', '=',$userId);
    })->get();
     // if user has some deliveries
     if(count($senderDeliveries) >0){
        // loop through each delivery item and append it ot the array
        foreach($senderDeliveries as $delivery){
         array_push( $allDeliveries, $delivery);
        }
  }
         $otherDelivery = Deliveries::where(["reciverContact"=>$userphone])->get();
         if(count($otherDelivery) >0){
            // loop through each delivery item and append it ot the array
            foreach($otherDelivery as $delivery){
             array_push( $allDeliveries, $delivery);
            }
         }

            // append success and deliv_obj to array and cast it to object
            $delivObject=(object)array('success'=>true,"deliveries"=>$allDeliveries);
            return response()->json( $delivObject, 200);
    }
    catch(Exception $e){
        return response()->json([
                    'success'=>false,
                    'error'=> $e->getMessage()
                ], 401);
        }

    }

       // method to get all the deliveries
       public function getAllDeliveries(Request $request)
       {
           try{
            $deliveriesModel = new Deliveries;
            $deliveries = Deliveries::all();
            // if user has some deliveries
           if(count($deliveries) >0){
             // append success and deliv_obj to array and cast it to object
             $delivObject=(object)array('success'=>true,"deliveries"=>$deliveries);
             return response()->json( $delivObject, 200);
           }
           else{
               return response()->json([
                   'success'=>true,
                   'deliveries' => $deliveriesModel,
               ], 200);
           }
       }
       catch(Exception $e){
           return response()->json([
                       'success'=>false,
                       'error'=> $e->getMessage()
                   ], 401);
           }
       }

   // Delete Delivery
    public function deleteDelivery(Request $request, $id){
        try{
            $delivery = Deliveries::find($id);
            if($delivery==null){
                return response()->json([
                    "success" => true,
                    "message" =>"Not found"
                    ],200);
            }
            else{
                $delivery->delete();
                return response()->json([
                    "success" => true,
                    "message" =>"Delivery with id $id successfully deleted"
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
