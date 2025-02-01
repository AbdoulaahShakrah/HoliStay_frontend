<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AdminHomePageController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomePageController::class, 'index'])->name('home');
Route::post('/home', [PropertyController::class, 'customSearch'])->name('customSearch');

Route::post('/search', [PropertyController::class, 'generalSearch'])->name('search');
Route::get('/properties', [PropertyController::class, 'properties'])->name('properties');
Route::get('/property/{id}', [PropertyController::class, 'show'])->name('property.details');

Route::get('/search', [PropertyController::class, 'results'])->name('search.results');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login_confirmation'])->name('login.confirmation');


Route::get('/adminHome', [AdminHomePageController::class, 'index'])->name('adminHome');

//rota para fazer testes
Route::get('/test', function(){
    return view('pages.admin.admin-homepage');
});

