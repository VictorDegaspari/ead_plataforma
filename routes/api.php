<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManageCoursesController;
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
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::get('loggedUser', [RegisterController::class, 'loggedUser']);

    Route::resource('courses', CourseController::class);

    Route::get('recommended', [CategoryController::class, 'recommended']);
    Route::resource('categories', CategoryController::class);

    Route::resource('comments', CommentController::class);

    Route::resource('users', UserController::class);

    Route::post('attachCourse', [ManageCoursesController::class, 'attachCourse']);  //atribui curso ao usuário
    Route::post('detachCourses', [ManageCoursesController::class, 'detachCourse']); //desatribui curso ao usuário

});
