<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\UsuariosController;
use App\Models\Ingrediente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
Route::get('/home', function () {
    if (!Auth::check()) {
        return redirect('/');
    }
    return view('index');
})->name('home');

/** INCIO Y CIERRE DE SESIÓN */
Route::post('/logout', [UsuariosController::class, 'logout'])->name('logout');
Route::post('/login', [UsuariosController::class, 'login'])->name('login');

/** ABM DE USUARIOS */
Route::view('/register', 'user/register')->name('register');
Route::post('/validate-register', [UsuariosController::class, 'register'])->name('validate-register');
Route::get('/close-account', [UsuariosController::class, 'destroy'])->name('close-account');
Route::get('/delete-account', [UsuariosController::class, 'destroy'])->name('delete-account');

Route::get('/update',  [UsuariosController::class, 'update'] )->name('update-user');
Route::post('/update',  [UsuariosController::class, 'update'] )->name('update-user');

/** INGREDIENTES */
Route::get('/create', [IngredienteController::class, 'create'])->name('create-ingredient');
Route::get('/edit/{id}', [IngredienteController::class, 'edit'])->name('edit-ingredient');
Route::post('/store', [IngredienteController::class, 'store'])->name('store-ingredient');
Route::get('/index-ingredients', [IngredienteController::class, 'index'])->name('index-ingredients');
Route::get('/delete-ingredient', [IngredienteController::class, 'destroy'])->name('delete-ingredient');
