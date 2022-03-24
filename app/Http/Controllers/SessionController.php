<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTraits;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    //

    use GeneralTraits;

    public function index(Request $request)
    {
        $message = 'sessions fetched successfully';
        $success = true;
        $data = [];

        try {
            $data =  Session::all();
       } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "SessionController error fetching sessions: $error";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }

    public function create_session(Request $request)
    {
        $message = 'session created successfully';
        $success = true;
        $data = [];


        try {
            $session = Session::create($request->data);
            array_push($data, $session);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "SessionController error creating session: $error ";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }


    public function update_session(Request $request)
    {
        $message = 'session updated successfully';
        $success = true;
        $data = [];

        try {
            DB::table('sessions')->where("id", $request->record_id)->update($request->data);
            $session = Session::where("id", $request->record_id)->firstOrFail();
            array_push($data, $session);
       } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "SessionController error updating session with id {$request->record_id}: $error";
            $success = false;
        }
        return $this->responseForm($message, $success, $data);
    }

    public function remove_session(Request $request)
    {
        $message = 'session deleted successfully';
        $success = true;
        $data = [];

        try {
            $session = Session::where("id", $request->record_id)->firstOrFail();
            array_push($data, $session);
            $session->delete();
       } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "SessionController error deleting session with id {$request->record_id}: $error";
            $success = false;
        }


        return $this->responseForm($message, $success, $data);
    }
}
