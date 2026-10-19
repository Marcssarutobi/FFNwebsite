<?php

use App\Http\Controllers\SeoController;
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

// Plan du site pour les moteurs de recherche
Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);

// Site public (SPA Vue) : titre, description et aperçu de partage calculés côté serveur
Route::get('/{any}', [SeoController::class, 'page'])->where('any', '^(?!api/?)(?!admins/?).*$');

// route to serve admin include api
Route::get('/admins',function(){
    return view('admin');
});

Route::get('/admins/{any}',function(){
    return view('admin');
})->where('any','.*');
