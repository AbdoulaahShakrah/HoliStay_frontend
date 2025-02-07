<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\HostPropertyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomePageController::class, 'index'])->name('home');
Route::post('/home', [PropertyController::class, 'customSearch'])->name('customSearch');

Route::post('/search', [PropertyController::class, 'generalSearch'])->name('generalSearch');
Route::post('/categorySearch', [PropertyController::class, 'catagorySearch'])->name('catagorySearch');

Route::get('/properties', [PropertyController::class, 'properties'])->name('properties');
Route::get('/property/{id}', [PropertyController::class, 'show'])->name('property.details');

Route::post('/payment/{id}', [ReservationController::class, 'payment'])->name('payment');

Route::post('/process-payment', [ReservationController::class, 'store_reservation_payment'])
    ->name('store.payment.reservation');

Route::get('/my-reservations', [ReservationController::class, 'my_reservations'])->name('my.reservations');

Route::get('/search', [PropertyController::class, 'results'])->name('search.results');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login_confirmation'])->name('login.confirmation');

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/hostProperties', [HostPropertyController::class, 'hostProperties'])->name('hostProperties');
Route::get('/hostProperty/{id}', [HostPropertyController::class, 'propertyDetails'])->name('hostProperty.details');

Route::get('/hostPropertyCreate', [HostPropertyController::class, 'create'])->name('hostProperty.create');
Route::post('/hostProperty/store', [HostPropertyController::class, 'store'])->name('hostProperty.store');

Route::get('/hostPropertyCreate/{id}', [HostPropertyController::class, 'edit'])->name('hostProperty.edit');
Route::put('/hostProperty/update/{id}', [HostPropertyController::class, 'update'])->name('hostProperty.update');

Route::delete('/hostProperty/delete/{id}', [HostPropertyController::class, 'delete'])->name('hostProperty.delete');

Route::get('/AnalyticsPage', [AnalyticsController::class, 'setAnalyticsPage'])->name('setAnalyticsPage');

//rota para fazer testes
Route::get('/test', function(){
    //return view('pages.host.host-property-details');
    return view('pages.host.host-homepage');
});


Route::get('/test2', function(){
    return view('pages.client.reservations');
})->name('test2');

