<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\LogaController;

Route::middleware('auth')->group(function (){
    Route::Resource('cliente', 'App\Http\Controllers\ClienteController');
    Route::Resource('carro', 'App\Http\Controllers\CarroController');
    Route::Resource('aluguel', 'App\Http\Controllers\AlugueisController');
    Route::Resource('marca', 'App\Http\Controllers\MarcaController');
    Route::Resource('modelo', 'App\Http\Controllers\ModeloController');
});

//Route::get('login', [LogaController::class, 'login_get'])->name('aut.loga');
Route::post('login', [LogaController::class, 'login_post'])->name('aut.login');
Route::post('login1', [LogaController::class, 'login1'])->name('aut.login1');
Route::post('register', [LogaController::class, 'register'])->name('aut.register');
Route::post('encrypt', [LogaController::class, 'login_encrypt'])->name('aut.encrypt');





