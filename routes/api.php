<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Session;

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



Route::group(["namespace" => "App\Http\Controllers\Api"], function () {

    Route::group(
        ['prefix' => 'session'],
        function () {

          ;

            Route::get("/", "SessionController@index");
            // Route::post("/create", "SessionController@create_session");
            // Route::delete("/delete/{id}", "SessionController@delete_session");
            // Route::put("/update/{id}", "SessionController@update_session");
            // Route::post("/join/{id}", "SessoinController@join_session");
        }
    );
});
