<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\TipounidadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Gate;

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

    public function destroy(Receta $receta)
    {
        Gate::authorize('delete-receta', $receta); // Asegura que el usuario tenga permiso
        $receta->delete();
        // Si las instrucciones y archivos se eliminan en cascada, perfecto.
        // Sino, deberías eliminarlos manualmente aquí o configurar cascadas en la BD.
        session()->flash('message', 'Receta eliminada exitosamente.');
        return redirect()->route('recipe.index');
    }
}
