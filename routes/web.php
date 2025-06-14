<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\HomeController;

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
Route::get('/home', [HomeController::class, 'index'])->name('home');

/** agregar la condicion para que no deje ingresar al sistema si el usuario no esta logueado */
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
Route::get('/create-ingredient', [IngredienteController::class, 'create'])->name('create-ingredient');
Route::get('/edit/{id}', [IngredienteController::class, 'edit'])->name('edit-ingredient');
Route::post('/store-ingredient', [IngredienteController::class, 'store'])->name('store-ingredient');
Route::get('/index-ingredients', [IngredienteController::class, 'index'])->name('index-ingredients');
Route::get('/delete-ingredient', [IngredienteController::class, 'destroy'])->name('delete-ingredient');


/** PLAN */
Route::get('/create', [PlanController::class, 'create'])->name('create-plan');
Route::get('/index-plan', [PlanController::class, 'index'])->name('index-plan');
Route::post('/store', [PlanController::class, 'store'])->name('store-plan');
Route::get('/add-recipe', [PlanController::class, 'addRecipe'])->name('add-recipe');
Route::get('/search-recipe', [PlanController::class, 'searchRecipe'])->name('search-recipe');
Route::get('/edit-plan/{id}/{id_recipe}', [PlanController::class, 'edit'])->name('edit-plan');
Route::get('/update-plan/{id}', [PlanController::class, 'update'])->name('update-plan');
Route::get('/delete-plan/{id}', [PlanController::class, 'delete'])->name('delete-plan');




/** ABM DE RECETAS */
Route::view('/receta', 'recipe/createRecipe')->name('createRecipe');
