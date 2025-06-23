<?php

namespace App\Http\Controllers;

use App\Models\Tiporeceta;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TipoRecetaController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('typeRecipe/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('typeRecipe/form', ['typeRecipe' => new Tiporeceta()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'nombre' => 'required|unique:tiporecetas,nombre,|string|max:255',
        ]);

        /** verificar si el TipoUnidad ya no existe */
        if (isset($request->id)) {
            $savedIngredient = Tiporeceta::modify($request);
        }else{
            $savedIngredient = Tiporeceta::create($request->nombre);
        }
        // Creación del TipoUnidad
        if ($savedIngredient) {
            Alert::toast('Se creo el TipoUnidad con éxito.', 'success');
            return redirect()->route('index-type-recipe');
        }

        return redirect()->route('create-type-recipe');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoUnidad  $TipoUnidad
     * @return \Illuminate\Http\Response
     */
    public function show(Tiporeceta $TipoUnidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoUnidad  $TipoUnidad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $typeRecipe = Tiporeceta::findModel($id);
        return view('typeRecipe/form', ['typeRecipe' => $typeRecipe]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoUnidad  $TipoUnidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tiporeceta $TipoUnidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoUnidad  $TipoUnidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $typeRecipe)
    {
        $model = new Tiporeceta();
        if ($model->deletetypeRecipe($typeRecipe['id'])){
            return ['flag' => true, 'mensaje' => 'Se elimino el tipo de comida.', 'ruta' => 'index-type-recipe'];
        }else{
            return ['flag' => false, 'mensaje' => 'No se pudo eliminar el tipo de comida.'];
        }
    }
}
