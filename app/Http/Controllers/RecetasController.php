<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\TipounidadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class RecetasController extends Controller
{
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
}
