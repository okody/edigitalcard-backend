<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTraits;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShopItem;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    //

    use GeneralTraits;

    public function index(Request $request)
    {
        $message = 'shops fetched successfully';
        $success = true;
        $data = [];


       
        try {
            if ($request->header('platform') == "application")
                {
                    $data =  Shop::with("shopItems")->get();
                    
                }
            else
                $data =  Shop::all();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ShopController error fetching shops: $error";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }

    public function create_shop(Request $request)
    {
        $message = 'shop created successfully';
        $success = true;
        $data = [];




        try {

            $requestData =  $request->data;
            $requestData["image"] = $this->imageSaver($request->data["image"]);


            $shop = Shop::create($requestData);
            array_push($data, $shop);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ShopController error creating shop: $error ";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }


    public function update_shop(Request $request)
    {
        $message = 'shop updated successfully';
        $success = true;
        $data = [];

        try {

            $requestData =  $request->data;
            $requestData["image"] = $this->imageSaver($request->data["image"]);


            DB::table('shops')->where("id", $request->record_id)->update($requestData);
            $shop = Shop::where("id", $request->record_id)->firstOrFail();
            array_push($data, $shop);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ShopController error updating shop with id {$request->record_id}: $error";
            $success = false;
        }
        return $this->responseForm($message, $success, $data);
    }

    public function remove_shop(Request $request)
    {
        $message = 'shop deleted successfully';
        $success = true;
        $data = [];

        try {
            $shop = Shop::where("id", $request->record_id)->firstOrFail();
            array_push($data, $shop);
            $shop->delete();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ShopController error deleting shop with id {$request->record_id}: $error";
            $success = false;
        }


        return $this->responseForm($message, $success, $data);
    }


    public function get_items(Request $request)
    {
        $message = 'items fetched successfully';
        $success = true;
        $data = [];

        try {
            $data =  ShopItem::where("shop_id", $request->shop_id)->get();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ShopController error fetching items: $error";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }

    public function create_item(Request $request)
    {
        $message = 'item created successfully';
        $success = true;
        $data = [];





        try {


            $requestData =  $request->data;
            $requestData["shop_id"] = $request->shop_id;
            $requestData["image"] = $this->imageSaver($request->data["image"]);

            $item = ShopItem::create($requestData);
            array_push($data, $item);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ShopController error creating item: $error ";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }


    public function update_item(Request $request)
    {
        $message = 'item updated successfully';
        $success = true;
        $data = [];

        try {

            $requestData =  $request->data;
            $requestData["shop_id"] = $request->shop_id;
            $requestData["image"] = $this->imageSaver($request->data["image"]);


            DB::table('shop_items')->where("id", $request->item_id)->update($requestData);
            $item = ShopItem::where("id", $request->item_id)->firstOrFail();
            array_push($data, $item);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ShopController error updating item with id {$request->item_id}: $error";
            $success = false;
        }
        return $this->responseForm($message, $success, $data);
    }

    public function remove_item(Request $request)
    {
        $message = 'item deleted successfully';
        $success = true;
        $data = [];

        try {
            $item = ShopItem::where("id", $request->item_id)->firstOrFail();
            array_push($data, $item);
            $item->delete();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ShopController error deleting item with id {$request->item_id}: $error";
            $success = false;
        }


        return $this->responseForm($message, $success, $data);
    }
}
