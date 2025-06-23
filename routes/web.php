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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TipoComidaController;
use App\Http\Controllers\TipoUnidadController;
use App\Http\Controllers\TipoRecetaController;

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
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

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
    Route::get('/create-plan', [PlanController::class, 'create'])->name('create-plan');
    Route::get('/index-plan', [PlanController::class, 'index'])->name('index-plan');
    Route::post('/store-plan', [PlanController::class, 'store'])->name('store-plan');
    Route::get('/add-recipe', [PlanController::class, 'addRecipe'])->name('add-recipe');
    Route::get('/search-recipe', [PlanController::class, 'searchRecipe'])->name('search-recipe');
    Route::get('/edit-plan/{id}', [PlanController::class, 'edit'])->name('edit-plan');
    Route::get('/update-plan/{id}', [PlanController::class, 'update'])->name('update-plan');
    Route::get('/delete-plan/{id}', [PlanController::class, 'destroy'])->name('delete-plan');
    Route::get('/view-modal/{id}/{id_recipe}', [PlanController::class, 'viewModal'])->name('view-modal');
    Route::get('/update-week/{startWeek}/{endWeek}', [PlanController::class, 'updateWeek']);

    /** ABM DE TIPO DE COMIDA */
    Route::get('/create-type-food', [TipoComidaController::class, 'create'])->name('create-type-food');
    Route::get('/index-type-food', [TipoComidaController::class, 'index'])->name('index-type-food');
    Route::post('/store-type-food', [TipoComidaController::class, 'store'])->name('store-type-food');
    Route::get('/delete-type-food/{id}', [TipoComidaController::class, 'destroy'])->name('delete-type-food');
    Route::get('/edit-type-food/{id}', [TipoComidaController::class, 'edit'])->name('edit-type-food');

    /** ABM DE TIPO DE UNIDAD */
    Route::get('/create-type-unity', [TipoUnidadController::class, 'create'])->name('create-type-unity');
    Route::get('/index-type-unity', [TipoUnidadController::class, 'index'])->name('index-type-unity');
    Route::post('/store-type-unity', [TipoUnidadController::class, 'store'])->name('store-type-unity');
    Route::get('/delete-type-unity/{id}', [TipoUnidadController::class, 'destroy'])->name('delete-type-unity');
    Route::get('/edit-type-unity/{id}', [TipoUnidadController::class, 'edit'])->name('edit-type-unity');

    /** ABM DE TIPO DE UNIDAD */
    Route::get('/create-type-recipe', [TipoRecetaController::class, 'create'])->name('create-type-recipe');
    Route::get('/index-type-recipe', [TipoRecetaController::class, 'index'])->name('index-type-recipe');
    Route::post('/store-type-recipe', [TipoRecetaController::class, 'store'])->name('store-type-recipe');
    Route::get('/delete-type-recipe/{id}', [TipoRecetaController::class, 'destroy'])->name('delete-type-recipe');
    Route::get('/edit-type-recipe/{id}', [TipoRecetaController::class, 'edit'])->name('edit-type-recipe');


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

