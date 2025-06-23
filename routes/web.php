<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\RecetasController; // Asegúrate de que este es tu controlador de Recetas
use App\Models\Ingrediente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate; // Agrega esta línea para usar Gate en Livewire si es necesario

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

// Agregué el middleware 'auth' aquí para asegurar que solo usuarios logueados accedan a /home
// Y el middleware 'web' ya está aplicado por defecto a todas las rutas en web.php
Route::get('/home', function () {
    return view('index');
})->name('home')->middleware('auth'); // Usar el middleware 'auth' de Laravel

/** INCIO Y CIERRE DE SESIÓN */
// Estas rutas no suelen llevar middleware 'auth' ya que son para loguearse/desloguearse
Route::post('/logout', [UsuariosController::class, 'logout'])->name('logout');
Route::post('/login', [UsuariosController::class, 'login'])->name('login');


Route::view('/register', 'user/register')->name('register'); // Si es un registro para usuarios ya logueados, sino quitar 'auth'
Route::post('/validate-register', [UsuariosController::class, 'register'])->name('validate-register'); // Igual que arriba


/** RUTAS PROTEGIDAS CON AUTH */
// Es una buena práctica agrupar las rutas que requieren autenticación.
// El middleware 'auth' asegura que el usuario esté logueado.
// Luego puedes agregar 'can' para permisos específicos.
Route::middleware(['auth'])->group(function () {

    /** ABM DE USUARIOS */
    // Solo puedes ver y modificar tu propia cuenta si estás logueado
    Route::get('/close-account', [UsuariosController::class, 'destroy'])->name('close-account');
    Route::get('/delete-account', [UsuariosController::class, 'destroy'])->name('delete-account');

    Route::get('/update', [UsuariosController::class, 'update'])->name('update-user');
    Route::post('/update', [UsuariosController::class, 'update'])->name('update-user');

    /** INGREDIENTES */
    // Si la administración de ingredientes debe ser solo para ciertos roles, podrías usar 'can' aquí también.
    // Por ahora, asumimos que cualquier usuario autenticado puede crear/editar/ver ingredientes.
    Route::get('/create-ingredient', [IngredienteController::class, 'create'])->name('create-ingredient');
    Route::get('/edit/{id}', [IngredienteController::class, 'edit'])->name('edit-ingredient');
    Route::post('/store-ingredient', [IngredienteController::class, 'store'])->name('store-ingredient');
    Route::get('/index-ingredients', [IngredienteController::class, 'index'])->name('index-ingredients');
    Route::get('/delete-ingredient', [IngredienteController::class, 'destroy'])->name('delete-ingredient');

    /** PLAN */
    // Similar a ingredientes, si la creación de planes tiene restricciones, aplica 'can'.
    Route::get('/create', [PlanController::class, 'create'])->name('create-plan');
    Route::get('/index-plan', [PlanController::class, 'index'])->name('index-plan');
    Route::post('/store', [PlanController::class, 'store'])->name('store-plan');
    Route::get('/add-recipe', [PlanController::class, 'addRecipe'])->name('add-recipe');
    Route::get('/search-recipe', [PlanController::class, 'searchRecipe'])->name('search-recipe');

    /** ABM DE RECETAS */

    // **Ruta para ver el listado de recetas (recetas.index):**
    // Asumo que esta ruta debería ser accesible para todos los usuarios autenticados.
    // Si aún no tienes un listado de recetas, podrías crear una ruta simple.
    Route::get('/recetas', [RecetasController::class, 'index'])->name('recipe.index'); // <-- Agrega esta para el listado

    // **Ruta para "Crear receta" (create-recipe):**
    // Protegida con el middleware 'can:create-receta'
    Route::get('/receta', function () {
        return view('/recipe/create');
    })->name('recetas.create')->middleware('can:create-receta'); // <-- Nombre de ruta cambiado

    Route::get('/recetas/{receta}/edit', [RecetasController::class, 'edit'])->name('recetas.edit');
    // Route::get('/recetas/{receta}/edit', function (Receta $receta) {
    // return view('recetas.edit', compact('receta'));
    // })->name('recetas.edit');
    Route::put('/recetas/{receta}', [RecetasController::class, 'update'])->name('recetas.update');
    Route::get('/delete-recipe', [RecetasController::class, 'destroy'])->name('delete-recipe');
    // Route::delete('/recetas/{receta}', [RecetasController::class, 'destroy'])->name('recetas.destroy');
    
    // **Ruta para guardar la receta (store-recipe):**
    // También debe estar protegida con el mismo middleware.
    // Si estás enviando el formulario a un método de un controlador, así:
    // Route::post('/receta', [RecetasController::class, 'store'])->name('store-recipe')->middleware('can:create-receta');

    // Si tu formulario de receta es un componente Livewire y el guardado ocurre dentro de 'saveRecipe()',
    // la protección en el componente Livewire con Gate::authorize('create-receta') es lo principal.
    // Sin embargo, si tienes una ruta POST explícita para enviar el formulario (a veces Livewire lo hace internamente),
    // asegúrate de protegerla aquí también.
});