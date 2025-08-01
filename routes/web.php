<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api/?)(?!admins/?).*$');

// route to serve admin include api
Route::get('/admins',function(){
    return view('admin');
});

Route::get('/admins/{any}',function(){
    return view('admin');
})->where('any','.*');
