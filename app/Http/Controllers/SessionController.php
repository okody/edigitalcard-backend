<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTraits;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Participaction;
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

            // if ($request->header("platform") == "applicatoin")
                $data =  Session::whereHas('participactions', function ($query) {
                    return $query->where('username', "1111");
                })->get();
            // else
            $data =  Session::with("participactions")->get();
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



    public function get_participactions(Request $request)
    {
        $message = 'participactions fetched successfully';
        $success = true;
        $data = [];

        try {

            $data =  Participaction::where("session_id", $request->session_id)->get();;
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ParticipactionController error fetching participactions: $error";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }

    public function create_participaction(Request $request)
    {
        $message = 'participaction created successfully';
        $success = true;
        $data = [];


        try {

            $requestData =  $request->data;

            $requestData["session_id"] = $request->session_id;

            $participaction = Participaction::create($requestData);
            array_push($data, $participaction);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ParticipactionController error creating participaction: $error ";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }


    public function update_participaction(Request $request)
    {
        $message = 'participaction updated successfully';
        $success = true;
        $data = [];

        try {

            $requestData =  $request->data;
            $requestData["session_id"] = $request->session_id;


            DB::table('participactions')->where("id", $request->record_id)->update($requestData);
            $participaction = Participaction::where("id", $request->record_id)->firstOrFail();
            array_push($data, $participaction);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ParticipactionController error updating participaction with id {$request->record_id}: $error";
            $success = false;
        }
        return $this->responseForm($message, $success, $data);
    }

    public function remove_participaction(Request $request)
    {
        $message = 'participaction deleted successfully';
        $success = true;
        $data = [];

        try {
            $participaction = Participaction::where("id", $request->record_id)->firstOrFail();
            array_push($data, $participaction);
            $participaction->delete();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "ParticipactionController error deleting participaction with id {$request->record_id}: $error";
            $success = false;
        }


        return $this->responseForm($message, $success, $data);
    }
}
