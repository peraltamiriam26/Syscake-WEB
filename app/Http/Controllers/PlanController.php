<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanHasReceta;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::searchAllPlanUserPaginate();
        return view('plan/index', ['plans' => $plans]);
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
        if (!isset($request->id)) {
            $request->validate([
                'fecha' => 'required|unique:plans,fecha',
            ]);
        }else{
            $request->validate([
                'fecha' => ['required', Rule::unique('plans')->ignore($request->id)],
            ]);
        }
        
        $plan = new Plan();
        if ($save = $plan->savePlan($request)) {
            Alert::toast('success', "Se guardo correctamente.");
            return redirect()->route('home');
        }
        return redirect()->route('create-plan');
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
        $user_id = auth()->user()->id;
        $plan = Plan::findModel($id, $user_id);
        /** Debo buscar todas las recetas que tiene el plan según el tipo de comida */
        $plan_recipes_breakfast = PlanHasReceta::searchRecipesId($id, PlanHasReceta::BREAKFAST);
        $plan_recipes_lunch = PlanHasReceta::searchRecipesId($id, PlanHasReceta::LUNCH);
        $plan_recipes_snack = PlanHasReceta::searchRecipesId($id, PlanHasReceta::SNACK);
        $plan_recipes_dinner = PlanHasReceta::searchRecipesId($id, PlanHasReceta::DINNER);
        $selectedRecipes = PlanHasReceta::where('plan_id', $id)->pluck('receta_id')->toArray();

        return view('plan/update', [
            'plan' => $plan,
            'plan_recipes_breakfast' => $plan_recipes_breakfast,
            'plan_recipes_lunch' => $plan_recipes_lunch,
            'plan_recipes_snack' => $plan_recipes_snack,
            'plan_recipes_dinner' => $plan_recipes_dinner,
            'selectedRecipes' => $selectedRecipes
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $plan)
    {
         $model = new Plan();
        if ($model->deletePlan($plan['id'])){
            return ['flag' => true, 'mensaje' => 'Se elimino el plan.', 'ruta' => 'index-plan'];
        }else{
            return ['flag' => false, 'mensaje' => 'No se pudo eliminar el plan.'];
        }
    }

    public function addRecipe(){
        return view('plan/modalAddRecipe')->render();

    }

    public function searchRecipe(Request $request){
        $query = $request->input('q');

        $recipes = Receta::where('nombre', 'LIKE', "%{$query}%")
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

    public function viewModal($id, $id_recipe){
        $user_id = auth()->user()->id;
        $recipe = Receta::findModel($id_recipe);
        $plan = Plan::findModel($id, $user_id);
        return view('plan/modal-recipe', [
            'recipe' => $recipe,
            'plan' => $plan
        ]);
    }
}
