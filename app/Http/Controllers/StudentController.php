<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTraits;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CollectedPoint;
use App\Models\StudentItem;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{




    use GeneralTraits;







    public function index(Request $request)
    {
        $message = 'students fetched successfully';
        $success = true;
        $data = [];

        try {

            $data =  Student::with("collectedPoints:points")->get();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "StudentController error fetching students: $error";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }

    public function create_student(Request $request)
    {
        $message = 'student created successfully';
        $success = true;
        $data = [];


        try {
            $requestData =  $request->data;
            $requestData["image"] = $this->imageSaver($request->data["image"]);

            $student = Student::create($requestData);
            array_push($data, $student);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "StudentController error creating student: $error ";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }


    public function update_student(Request $request)
    {
        $message = 'student updated successfully';
        $success = true;
        $data = [];

        try {

            $requestData =  $request->data;
            $requestData["image"] = $this->imageSaver($request->data["image"]);


            DB::table('students')->where("id", $request->record_id)->update($requestData);
            $student = Student::where("id", $request->record_id)->firstOrFail();
            array_push($data, $student);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "StudentController error updating student with id {$request->record_id}: $error";
            $success = false;
        }
        return $this->responseForm($message, $success, $data);
    }

    public function remove_student(Request $request)
    {
        $message = 'student deleted successfully';
        $success = true;
        $data = [];

        try {
            $student = Student::where("id", $request->record_id)->firstOrFail();
            array_push($data, $student);
            $student->delete();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "StudentController error deleting student with id {$request->record_id}: $error";
            $success = false;
        }


        return $this->responseForm($message, $success, $data);
    }


    public function get_collectedPoints(Request $request)
    {
        $message = 'collectedPoints fetched successfully';
        $success = true;
        $data = [];

        try {

            $data =  CollectedPoint::where("student_id", $request->student_id)->get();;
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "CollectedPointController error fetching collectedPoints: $error";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }

    public function create_collectedPoint(Request $request)
    {
        $message = 'collectedPoint created successfully';
        $success = true;
        $data = [];


        try {

            $requestData =  $request->data;

            $requestData["student_id"] = $request->student_id;

            $collectedPoint = CollectedPoint::create($requestData);
            array_push($data, $collectedPoint);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "CollectedPointController error creating collectedPoint: $error ";
            $success = false;
        }

        return $this->responseForm($message, $success, $data);
    }


    public function update_collectedPoint(Request $request)
    {
        $message = 'collectedPoint updated successfully';
        $success = true;
        $data = [];

        try {

            $requestData =  $request->data;
            $requestData["student_id"] = $request->student_id;


            DB::table('collectedPoints')->where("id", $request->record_id)->update($requestData);
            $collectedPoint = CollectedPoint::where("id", $request->record_id)->firstOrFail();
            array_push($data, $collectedPoint);
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "CollectedPointController error updating collectedPoint with id {$request->record_id}: $error";
            $success = false;
        }
        return $this->responseForm($message, $success, $data);
    }

    public function remove_collectedPoint(Request $request)
    {
        $message = 'collectedPoint deleted successfully';
        $success = true;
        $data = [];

        try {
            $collectedPoint = CollectedPoint::where("id", $request->record_id)->firstOrFail();
            array_push($data, $collectedPoint);
            $collectedPoint->delete();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "CollectedPointController error deleting collectedPoint with id {$request->record_id}: $error";
            $success = false;
        }


        return $this->responseForm($message, $success, $data);
    }


    public function authenticate(Request $request)
    {
        $message = 'loged in successfully';
        $success = true;
        $data = [];

        try {

            $fetched = Student::where("username", $request->data["username"])->where("password", $request->data["password"])->first();
            if ($fetched)
                array_push($data, $fetched);
            else {
                $message = "username or password is uncorrect";
                $success = false;
            }
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $message = "StudentController error logging: $error";
            $success = false;
        }


        return $this->responseForm($message, $success, $data);
    }
}
