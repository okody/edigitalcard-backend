<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTraits;
use App\Models\Sport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SportItem;
use Illuminate\Support\Facades\DB;

class SportController extends Controller
{
    //

    use GeneralTraits;

    public function index(Request $request)
    {
        $message = 'sports fetched successfully';
        $success = true;
        $data = [];

        try {

            $data =  Sport::all();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "SportController error fetching sports: $error";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }

    public function create_sport(Request $request)
    {
        $message = 'sport created successfully';
        $success = true;
        $data = [];


        try {
            $requestData =  $request->data;
            $requestData["image"] = $this->imageSaver($request->data["image"]);

            $sport = Sport::create($requestData);
            array_push($data, $sport);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "SportController error creating sport: $error ";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }


    public function update_sport(Request $request)
    {
        $message = 'sport updated successfully';
        $success = true;
        $data = [];

        try {

            $requestData =  $request->data;
            $requestData["image"] = $this->imageSaver($request->data["image"]);


            DB::table('sports')->where("id", $request->record_id)->update($requestData);
            $sport = Sport::where("id", $request->record_id)->firstOrFail();
            array_push($data, $sport);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "SportController error updating sport with id {$request->record_id}: $error";
            $success = false;
        }
        return $this->responseForm($message, $success, $data);
    }

    public function remove_sport(Request $request)
    {
        $message = 'sport deleted successfully';
        $success = true;
        $data = [];

        try {
            $sport = Sport::where("id", $request->record_id)->firstOrFail();
            array_push($data, $sport);
            $sport->delete();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "SportController error deleting sport with id {$request->record_id}: $error";
            $success = false;
        }


        return $this->responseForm($message, $success, $data);
    }
}
