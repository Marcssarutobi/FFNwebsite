<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FungiEducationController;
use App\Http\Controllers\ExpeditionsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
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
Route::post('/uploadprojectimg', [ProjectController::class, 'uploadImg']);
Route::post('/deleteprojectimg', [ProjectController::class, 'deleteImage']);

//Event Public
Route::get('/allevents', [EventController::class, 'allEvent']);
Route::get('/event/{slug}', [EventController::class, 'showUser']);
Route::post('/uploadeventtimg', [EventController::class, 'uploadImg']);
Route::post('/deleteeventimg', [EventController::class, 'deleteImage']);

//Blogs Public
Route::get('/allblogs', [BlogController::class, 'allBlog']);
Route::get('/blog/{slug}', [BlogController::class, 'showUser']);
Route::post('/uploadblogimg', [BlogController::class, 'uploadImg']);
Route::post('/deleteblogimg', [BlogController::class, 'deleteImage']);

//Categorie
Route::get('/showcategory/{id}', [CategoryController::class, 'show']);
Route::get('/allcategories', [CategoryController::class, 'index']);

//Gallery
Route::get('/allimages', [GalleryController::class, 'index']);
Route::get('/showimages/{id}', [GalleryController::class, 'showImage']);
Route::post('/uploadimagesgal', [GalleryController::class, 'UploadImage']);
Route::post('/delimagesgal', [GalleryController::class, 'SuppImage']);

//Contact
Route::post('/addcontact', [ContactController::class, 'store']);

//Teams and Advisors
Route::get('/teams', [TeamController::class, 'indexTeams']);
Route::get('/advisors', [TeamController::class, 'indexAdvisors']);
Route::get('/showteam/{slug}', [TeamController::class, 'show']);
Route::post('/uploadimagesTeams', [TeamController::class, 'uploadImg']);
Route::post('/delimagesTeams', [TeamController::class, 'deleteImage']);

//Expéditions
Route::get('/allExpeditions', [ExpeditionsController::class, 'allExpeditions']);
Route::get('/showexpedition/{slug}', [ExpeditionsController::class, 'showUser']);
Route::post('/uploadimagesExpeditions', [ExpeditionsController::class, 'uploadImg']);
Route::post('/delimagesExpeditions', [ExpeditionsController::class, 'deleteImage']);

//Fungi Education
Route::get('/allFungiEducation', [FungiEducationController::class, 'allFungiEducation']);
Route::get('/showfungieducation/{slug}', [FungiEducationController::class, 'showUser']);
Route::post('/uploadimagesFungiEducation', [FungiEducationController::class, 'uploadImg']);
Route::post('/delfungieducationimg', [FungiEducationController::class, 'deleteImage']);

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
    Route::get('/showproject/{id}', [ProjectController::class, 'show']);
    Route::post('/addproject', [ProjectController::class, 'store']);
    Route::put('/updateproject/{id}', [ProjectController::class, 'update']);
    Route::delete('/deleteproject/{id}', [ProjectController::class, 'destroy']);
    Route::get('/sendApprovalproject/{id}', [ProjectController::class, 'SendApprobationMail']);
    Route::post('/sendDeclenedproject/{id}', [ProjectController::class, 'SendDeclenedMail']);

    //Events
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/showevent/{id}', [EventController::class, 'show']);
    Route::post('/addevent', [EventController::class, 'store']);
    Route::put('/updateevent/{id}', [EventController::class, 'update']);
    Route::delete('/deleteevent/{id}', [EventController::class, 'destroy']);
    Route::get('/sendApprovalevent/{id}', [EventController::class, 'SendApprobationMail']);
    Route::post('/sendDeclenedevent/{id}', [EventController::class, 'SendDeclenedMail']);

    //Blogs
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/showblog/{id}', [BlogController::class, 'show']);
    Route::post('/addblog', [BlogController::class, 'store']);
    Route::put('/updateblog/{id}', [BlogController::class, 'update']);
    Route::delete('/deleteblog/{id}', [BlogController::class, 'destroy']);
    Route::get('/sendApprovalblog/{id}', [BlogController::class, 'SendApprobationMail']);
    Route::post('/sendDeclenedblog/{id}', [BlogController::class, 'SendDeclenedMail']);

    //Gallery
    Route::post('/addimages', [GalleryController::class, 'createGallery']);
    Route::delete('/delimages/{id}', [GalleryController::class, 'deleteImage']);

    //Contacts
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::get('/showcontact/{id}', [ContactController::class, 'show']);
    Route::put('/updatecontact/{id}', [ContactController::class, 'markAsRead']);
    Route::delete('/deletecontact/{id}', [ContactController::class, 'destroy']);

    //Teams and Advisors
    Route::post('/addteam', [TeamController::class, 'store']);
    Route::put('/updateteam/{slug}', [TeamController::class, 'update']);
    Route::delete('/deleteteam/{slug}', [TeamController::class, 'destroy']);

    //User
    Route::get('/alluser', [UserController::class, 'index']);
    Route::get('/showuser/{id}', [UserController::class, 'show']);
    Route::post('/adduser', [UserController::class, 'store']);
    Route::put('/updateuser/{id}', [UserController::class, 'update']);
    Route::put('/updatepwd/{id}', [UserController::class, 'changePassword']);
    Route::delete('/deleteuser/{id}', [UserController::class, 'destroy']);

    //fungiEducation
    Route::get('/fungieducation', [FungiEducationController::class, 'index']);
    Route::get('/fungieducationID/{id}', [FungiEducationController::class, 'show']);
    Route::post('/addfungieducation', [FungiEducationController::class, 'store']);
    Route::put('/updatefungieducation/{id}', [FungiEducationController::class, 'update']);
    Route::delete('/deletefungieducation/{id}', [FungiEducationController::class, 'destroy']);
    

    //expeditions
    Route::get('/expeditions', [ExpeditionsController::class, 'index']);
    Route::get('/showexpeditionID/{id}', [ExpeditionsController::class, 'show']);
    Route::post('/addexpedition', [ExpeditionsController::class, 'store']);
    Route::put('/updateexpedition/{id}', [ExpeditionsController::   class, 'update']);
    Route::delete('/deleteexpedition/{id}', [ExpeditionsController::class, 'destroy']);
    


});
