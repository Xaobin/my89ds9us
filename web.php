<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::prefix('v1')->middleware('mycheck')->group(function() {
 /* 
    Route::get('/marcas', 'App\Http\Controllers\HomeController@marcas')->name('marcas');
    Route::get('/clientes', 'App\Http\Controllers\HomeController@clientes')->name('clientes');
    Route::get('/modelos', 'App\Http\Controllers\HomeController@modelos')->name('modelos');
    Route::get('/carros', 'App\Http\Controllers\HomeController@carros')->name('carros');
    Route::get('/alugueis', 'App\Http\Controllers\HomeController@alugueis')->name('alugueis');
   */ 
  //});



Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('sys/v1')->group(function() {
  Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
  Route::get('/example', 'App\Http\Controllers\HomeController@index')->name('example');
  Route::get('/marcas', 'App\Http\Controllers\HomeController@marcas')->name('marcas');
  Route::get('/clientes', 'App\Http\Controllers\HomeController@clientes')->name('clientes');
  Route::get('/modelos', 'App\Http\Controllers\HomeController@modelos')->name('modelos');
  Route::get('/carros', 'App\Http\Controllers\HomeController@carros')->name('carros');
  Route::get('/alugueis', 'App\Http\Controllers\HomeController@alugueis')->name('alugueis');
});
//Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

//Route::get('/login', [App\Http\Controllers\HomeController::class, 'login_one'])->name('login_one');
//Route::post('login1', [App\Http\Controllers\HomeController::class, 'login_one'])->name('aut.login1');