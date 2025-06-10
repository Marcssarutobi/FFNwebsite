<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login',[UserController::class, 'login']);

//Image Profils
Route::post('/uploadimg', [UserController::class, 'uploadImg']);
Route::post('/deleteimg', [UserController::class, 'deleteImage']);

Route::middleware('auth:sanctum')->group( function () {

    //CurrentUser
    Route::get('/user', [UserController::class, 'getUser']);
    //logout
    Route::post('/logout',[UserController::class, 'logout']);

    //roles
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/role/{id}', [RoleController::class, 'show']);
    Route::post('/addrole', [RoleController::class, 'store']);
    Route::put('/updaterole/{id}', [RoleController::class, 'update']);
    Route::delete('/deleterole/{id}', [RoleController::class, 'destroy']);

    //Permissions
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::get('/permission/{id}', [PermissionController::class, 'show']);
    Route::post('/addpermission', [PermissionController::class, 'store']);
    Route::put('/updatepermission/{id}', [PermissionController::class, 'update']);
    Route::delete('/deletepermission/{id}', [PermissionController::class, 'destroy']);


});
