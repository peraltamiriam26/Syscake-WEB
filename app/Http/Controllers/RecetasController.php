<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\TipounidadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class RecetasController extends Controller
{
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        // // Por ejemplo, para mostrar una lista de recetas
        // $recetas = Receta::with(['instrucciones.archivo', 'tipoReceta'])
        //                     ->orderBy('created_at', 'desc')
        //                     ->paginate(10); // Pagina 10 recetas por página
        // return view('recipe.index', compact('recetas'));
        return view('recipe.index');
    }

    public function create()
    {
        $controllerIngrediente = new IngredienteController();
        $ingredients = $controllerIngrediente->search();

        $controllerTipoUnidad = new TipounidadController();
        $tipoUnidads = $controllerTipoUnidad->search();
        return view('recipe/createRecipe', ['recipe' => new Receta(), 
                    'ingredients' => $ingredients,
                    'tipoUnidads' => $tipoUnidads]);
    }
    
    public function edit(Receta $receta) // Laravel inyecta la receta por su ID
    {
        Gate::authorize('update-receta', $receta); // Asegura que el usuario tenga permiso
        return view('recipe.edit', compact('receta')); // Necesitarás 'resources/views/recetas/edit.blade.php'
    }

    public function destroy(Request $recipe)
    {
        $model = new Receta();
        Log::debug($recipe['id']);
        if ($model->deleteRecipe($recipe['id'])){
            return ['flag' => true, 'mensaje' => 'Se elimino la receta.', 'ruta' => 'recetas'];
        }else{
            return ['flag' => false, 'mensaje' => 'No se pudo eliminar la receta.'];
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Receta::findModel($id);
        $steps = $recipe->instrucciones()->orderBy('orden', 'asc')->get();
        $ingredients = $recipe->ingredientes_receta()->get();
        return view('/recipe/view', [
            'recipe' => $recipe, 
            'steps' => $steps,
            'ingredients' => $ingredients
        ]);
    }


    //     public function destroy(Receta $receta) // Usamos Route Model Binding
    // {
    //     // 1. Autorización: Muy importante para la seguridad.
    //     // Asegúrate de que el usuario tenga permiso para eliminar esta receta.
    //     // Si no tienes un Gate 'delete-receta' o la lógica es diferente, ajústalo.
    //     // Por ejemplo, solo el creador o un administrador.
    //     // Gate::authorize('delete-receta', $receta);

    //     try {
    //         DB::beginTransaction(); // Iniciar una transacción de base de datos

    //         // 2. Eliminar archivos de imágenes de los pasos (instrucciones) y sus registros en la tabla 'archivos'
    //         // Es CRÍTICO obtener las instrucciones *antes* de eliminarlas para acceder a sus archivos.
    //         foreach ($receta->instrucciones()->with('archivo')->get() as $instruccion) {
    //             if ($instruccion->archivo) { // Si esta instrucción tiene un archivo asociado
    //                 Storage::disk('public')->delete($instruccion->archivo->ruta); // Eliminar el archivo físico
    //                 $instruccion->archivo->delete(); // Eliminar el registro de la tabla 'archivos'
    //             }
    //             // Si instruccion.blade.php tiene un wire:model="pasos.X.imagen_path"
    //             // y el campo imagen_path se guarda directo en instrucciones, aquí también se borra.
    //             // Sin embargo, tu esquema usa archivo_id, así que lo anterior es lo correcto.
    //         }

    //         // 3. Eliminar la imagen principal de la receta y su registro en la tabla 'archivos'
    //         if ($receta->archivo_id) { // Asumiendo que Receta tiene un archivo_id para su imagen principal
    //             $archivoPrincipal = Archivo::find($receta->archivo_id);
    //             if ($archivoPrincipal) {
    //                 Storage::disk('public')->delete($archivoPrincipal->ruta); // Eliminar el archivo físico
    //                 $archivoPrincipal->delete(); // Eliminar el registro de la tabla 'archivos'
    //             }
    //         }

    //         // 4. Eliminar registros de las tablas relacionadas (si no usas onDelete('cascade') en las migraciones)
    //         // Si tus migraciones tienen onDelete('cascade') en las FK, estas líneas pueden ser redundantes,
    //         // pero no causan daño. El orden importa si no hay cascada en la BD: hijos primero, luego padre.

    //         // Eliminar entradas en la tabla pivote de ingredientes (muchos a muchos)
    //         $receta->ingredientes()->detach(); // Elimina las entradas de 'ingrediente_has_receta'

    //         // Eliminar instrucciones (pasos)
    //         $receta->instrucciones()->delete(); // Elimina todos los registros de 'instruccions' asociados a esta receta

    //         // 5. Finalmente, eliminar la receta principal
    //         $receta->delete();

    //         DB::commit(); // Confirmar la transacción si todo fue exitoso
    //         session()->flash('message', 'Receta eliminada exitosamente.');

    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Revertir la transacción si ocurre cualquier error
    //         Log::error("Error al eliminar receta {$receta->id}: " . $e->getMessage());
    //         session()->flash('error', 'Hubo un error al eliminar la receta: ' . $e->getMessage());
    //     }

    //     return redirect()->route('recipe.index'); // Redirigir de vuelta al listado
    // }
}
