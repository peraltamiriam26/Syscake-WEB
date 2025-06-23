<?php

namespace App\Http\Controllers;

use App\Models\TipoComida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class TipoComidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('typeFood/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('typeFood/form', ['typeFood' => new TipoComida()]);
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
            'descripcion' => 'required|unique:tipocomidas,descripcion,|string|max:255',
        ]);

        /** verificar si el TipoComida ya no existe */
        if (isset($request->id)) {
            $savedIngredient = TipoComida::modify($request);
        }else{
            $savedIngredient = TipoComida::create($request->descripcion);
        }
        // Creación del TipoComida
        if ($savedIngredient) {
            Alert::toast('Se creo el TipoComida con éxito.', 'success');
            return redirect()->route('index-type-food');
        }

        return redirect()->route('create-type-food');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoComida  $tipoComida
     * @return \Illuminate\Http\Response
     */
    public function show(TipoComida $tipoComida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoComida  $tipoComida
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $typeFood = TipoComida::findModel($id);
        return view('typeFood/form', ['typeFood' => $typeFood]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoComida  $tipoComida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoComida $tipoComida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoComida  $tipoComida
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $typeFood)
    {
        
        Log::debug($typeFood);
        $model = new TipoComida();
        if ($model->deleteTypeFood($typeFood['id'])){
            return ['flag' => true, 'mensaje' => 'Se elimino el tipo de comida.', 'ruta' => 'index-type-food'];
        }else{
            return ['flag' => false, 'mensaje' => 'No se pudo eliminar el tipo de comida.'];
        }
    }
}
