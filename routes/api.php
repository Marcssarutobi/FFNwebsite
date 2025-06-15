<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
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

//Project Public
Route::get('/allprojects', [ProjectController::class, 'allProject']);
Route::get('/project/{slug}', [ProjectController::class, 'showUser']);

//Event Public
Route::get('/allevents', [EventController::class, 'allEvent']);
Route::get('/event/{slug}', [EventController::class, 'showUser']);

//Blogs Public
Route::get('/allblogs', [BlogController::class, 'allBlog']);
Route::get('/blog/{slug}', [BlogController::class, 'showUser']);


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

    //categories
    Route::post('/addcategory', [CategoryController::class, 'store']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::put('/updatecategory/{id}', [CategoryController::class, 'update']);
    Route::delete('/deletecategory/{id}', [CategoryController::class, 'destroy']);

    //projects
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/project/{id}', [ProjectController::class, 'show']);
    Route::post('/addproject', [ProjectController::class, 'store']);
    Route::put('/updateproject/{id}', [ProjectController::class, 'update']);
    Route::delete('/deleteproject/{id}', [ProjectController::class, 'destroy']);

    //Events
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/event/{id}', [EventController::class, 'show']);
    Route::post('/addevent', [EventController::class, 'store']);
    Route::put('/updateevent/{id}', [EventController::class, 'update']);
    Route::delete('/deleteevent/{id}', [EventController::class, 'destroy']);

    //Blogs
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blog/{id}', [BlogController::class, 'show']);
    Route::post('/addblog', [BlogController::class, 'store']);
    Route::put('/updateblog/{id}', [BlogController::class, 'update']);
    Route::delete('/deleteblog/{id}', [BlogController::class, 'destroy']);




});
