<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plan/form', ['plan' => new Plan()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addRecipe(){
        return view('plan/modalAddRecipe')->render();

    }

    public function searchRecipe(Request $request){
            $query = $request->input('q');

        $recipes = Recetas::where('nombre', 'LIKE', "%{$query}%")
                        ->select('id', 'nombre as name')
                        ->get()
                         ->map(function ($recipe) {
                          return [
                              'id' => $recipe->id,
                              'text' => strtoupper($recipe->name) // Ejemplo: convertir el nombre a mayúsculas
                          ];
                      });
        return response()->json(['recipes' => $recipes]);
    }
}
