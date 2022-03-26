<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user/revoke', function (Request $request) {
    $user = $request->user();
    $user->tokens()->delete();
    return $user;
});



Route::post('sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);



    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }


    return $user->createToken($request->device_name)->plainTextToken;
});



Route::group(["namespace" => "App\Http\Controllers"], function () {



    Route::group(
        ['prefix' => 'session'],
        function () {

            // General
            // Get all sessions for application and dashbaord and also get session belonging to user with user_id
            Route::get("/", "SessionController@index");

            // Dashboard
            Route::post("/create", "SessionController@create_session");
            Route::delete("/delete/{record_id}", "SessionController@remove_session");
            Route::put("/update/{record_id}", "SessionController@update_session");

            // Application
            Route::group(
                ['prefix' => '{session_id}/participaction'],
                function () {

                    // General
                    // Get all sessions for application and dashbaord and also get session belonging to user with user_id
                    Route::get("/", "SessionController@get_participactions");

                    // Dashboard
                    Route::post("/create", "SessionController@create_participaction");
                    Route::delete("/delete/{record_id}", "SessionController@remove_participaction");
                    Route::put("/update/{record_id}", "SessionController@update_participaction");

                    // Application
                    // Route::post("/join/{record_id}", "SessoinController@join_session");
                    // Route::post("/leave/{record_id}", "SessoinController@leave_session");

                }
            );
        }
    );


    Route::group(
        ['prefix' => 'sport'],
        function () {

            // General
            // Get all sports for application and dashbaord and also get sport belonging to user with user_id
            Route::get("/", "SportController@index");

            // Dashboard
            Route::post("/create", "SportController@create_sport");
            Route::delete("/delete/{record_id}", "SportController@remove_sport");
            Route::put("/update/{record_id}", "SportController@update_sport");

            // Application

        }
    );

    Route::group(
        ['prefix' => 'student'],
        function () {

            // General
            // Get all students for application and dashbaord and also get student belonging to user with user_id
            Route::get("/", "StudentController@index");

            // Dashboard
            Route::post("/create", "StudentController@create_student");
            Route::delete("/delete/{record_id}", "StudentController@remove_student");
            Route::put("/update/{record_id}", "StudentController@update_student");

            // Application
            Route::post("/authenticate", "StudentController@authenticate");


            Route::group(
                ['prefix' => '{student_id}/collectedpoint'],
                function () {

                    // General
                    // Get all sessions for application and dashbaord and also get session belonging to user with user_id
                    Route::get("/", "StudentController@get_collectedPoints");

                    // Dashboard
                    Route::post("/create", "StudentController@create_collectedPoint");
                    Route::delete("/delete/{record_id}", "StudentController@remove_collectedPoint");
                    Route::put("/update/{record_id}", "StudentController@update_collectedPoint");
                }
            );
        }
    );


    Route::group(
        ['prefix' => 'shop'],
        function () {

            // General
            // Get all sessions for application and dashbaord and also get session belonging to user with user_id
            Route::get("/", "ShopController@index");

            // Dashboard
            Route::post("/create", "ShopController@create_shop");
            Route::delete("/delete/{record_id}", "ShopController@remove_shop");
            Route::put("/update/{record_id}", "ShopController@update_shop");

            // Application
            Route::group(
                ['prefix' => '{shop_id}/item'],
                function () {

                    // General
                    // Get all sessions for application and dashbaord and also get session belonging to user with user_id
                    Route::get("/", "ShopController@get_items");

                    // Dashboard
                    Route::post("/create", "ShopController@create_item");
                    Route::delete("/delete/{item_id}", "ShopController@remove_item");
                    Route::put("/update/{item_id}", "ShopController@update_item");
                }
            );
        }
    );
});
