<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class IngredienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelIngredient = new Ingrediente();
        $ingredients = $modelIngredient->search();
        return view('ingredient/index', ['ingredients' => $ingredients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ingredient/form', ['ingredient' => new Ingrediente()]);
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
            'nombre' => 'required|unique:ingredientes,nombre,|string|max:255',
        ]);

        /** verificar si el ingrediente ya no existe */
        if (isset($request->id)) {
            $savedIngredient = Ingrediente::modify($request);
        }else{
            $savedIngredient = Ingrediente::create($request->nombre);
        }
        // Creación del ingrediente
        if ($savedIngredient) {
            Alert::toast('Se creo el ingrediente con éxito.', 'success');
            return redirect()->route('index-ingredients');
        }

        return redirect()->route('create-ingredient');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingrediente  $ingrediente
     * @return \Illuminate\Http\Response
     */
    public function show(Ingrediente $ingrediente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ingrediente  $ingrediente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ingredient = Ingrediente::findModel($id);
        return view('ingredient/form', ['ingredient' => $ingredient]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingrediente  $ingrediente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $ingrediente)
    {
        $model = new Ingrediente();
        Log::debug($ingrediente['id']);
        if ($model->deleteIngredient($ingrediente['id'])){
            return ['flag' => true, 'mensaje' => 'Se elimino el ingrediente.', 'ruta' => 'index-ingredients'];
        }else{
            return ['flag' => false, 'mensaje' => 'No se pudo eliminar el ingrediente.'];
        }
    }
}
