<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UsuariosController;

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
    return view('auth/login');
});

Route::view('/register', 'user/register')->name('register');



Route::post('/login', [UsuariosController::class, 'login'])->name('login');
Route::post('/validate-register', [UsuariosController::class, 'register'])->name('validate-register');

Route::get('/home', function () {
    return view('home');
});
