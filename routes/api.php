<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ProjectController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //return $request->user();
//});

//Student Route
Route::post('/register', [StudentController::class,'register']);
Route::post('login', [StudentController::class,'login']);


Route::group(['middleware' => ['auth:sanctum']],
function (){
    Route::get('profile', [StudentController::class,'profile']);
    Route::get('logout', [ProjectController::class,'logout']);



    //project Route
    Route::post('add-Project', [ProjectController::class,'addProject']);
    Route::get('get-ProjectList', [ProjectController::class,'getProjectList']);
    Route::get('get-SingleProject/{id}', [ProjectController::class,'getSingleProject']);
    Route::delete('delete-Project/{id}', [ProjectController::class,'deleteProject']);
});
