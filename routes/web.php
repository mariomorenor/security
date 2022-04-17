<?php

use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::post("getCamerasByClient",[ClientsController::class,"getCamerasByClient"])->name("getCamerasByClient");
    Route::post("getResponsiblesByClient",[ClientsController::class,"getResponsiblesByClient"])->name("getResponsiblesByClient");
});

