<?php

namespace App\Http\Controllers;

use App\Models\TipoUnidad;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TipoUnidadController extends Controller
{ 
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('typeUnity/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('typeUnity/form', ['typeUnity' => new TipoUnidad()]);
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
            'nombre' => 'required|unique:tipounidads,nombre,|string|max:255',
        ]);

        /** verificar si el TipoUnidad ya no existe */
        if (isset($request->id)) {
            $savedIngredient = TipoUnidad::modify($request);
        }else{
            $savedIngredient = TipoUnidad::create($request->nombre);
        }
        // Creación del TipoUnidad
        if ($savedIngredient) {
            Alert::toast('Se creo el TipoUnidad con éxito.', 'success');
            return redirect()->route('index-type-unity');
        }

        return redirect()->route('create-type-unity');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoUnidad  $TipoUnidad
     * @return \Illuminate\Http\Response
     */
    public function show(TipoUnidad $TipoUnidad)
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
        $typeUnity = TipoUnidad::findModel($id);
        return view('typeUnity/form', ['typeUnity' => $typeUnity]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoUnidad  $TipoUnidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoUnidad $TipoUnidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoUnidad  $TipoUnidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $typeUnity)
    {
        $model = new TipoUnidad();
        if ($model->deletetypeUnity($typeUnity['id'])){
            return ['flag' => true, 'mensaje' => 'Se elimino el tipo de comida.', 'ruta' => 'index-type-unity'];
        }else{
            return ['flag' => false, 'mensaje' => 'No se pudo eliminar el tipo de comida.'];
        }
    }
}
