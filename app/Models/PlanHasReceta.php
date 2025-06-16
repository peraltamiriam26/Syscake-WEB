<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanHasReceta extends Model
{
    use HasFactory;
    const BREAKFAST = 1;
    const LUNCH = 2;
    const SNACK = 3;
    const DINNER = 4;

    protected $fillable = [
        'plan_id',
        'receta_id',
        'tipoComida_id'
    ];

    public function saveRecipes($request, $plan_id){
        $recipes_breakfast = $request->recipesBreakfast;
        $recipes_lunch = $request->recipesLunch;
        $recipes_snack = $request->recipesSnak;
        $recipes_dinner = $request->recipesDinner;
        
        if (self::deletePlanRecipes($plan_id) && ( $this->saveRecipesFood($recipes_breakfast, $plan_id, PlanHasReceta::BREAKFAST) && $this->saveRecipesFood($recipes_lunch, $plan_id, PlanHasReceta::LUNCH)
            && $this->saveRecipesFood($recipes_snack, $plan_id, PlanHasReceta::SNACK) && $this->saveRecipesFood($recipes_dinner, $plan_id, PlanHasReceta::DINNER) ) ) {
            return true;
        }
        return false;
    }

    public function saveRecipesFood($recipes, $plan_id, $typeFood){
        if (isset($recipes)) {
            foreach ($recipes as $key => $recipe_id) {
                $plan_has_recipe = new PlanHasReceta();
                $plan_has_recipe->plan_id = $plan_id;
                $plan_has_recipe->receta_id = $recipe_id;
                $plan_has_recipe->tipoComida_id = $typeFood;
                if (!$plan_has_recipe->save()) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function searchRecipesId($plan_id, $typeFood){
        $recipes_breakfast_id = PlanHasReceta::select('receta_id', 'recetas.nombre')
                                            ->join('recetas', 'plan_has_recetas.receta_id', '=', 'recetas.id')
                                            ->where('plan_id', $plan_id)
                                            ->where('tipoComida_id', $typeFood)
                                            ->get();
        return $recipes_breakfast_id;
    }

    /** si la cantidad de registros coincide con los registros eliminados
     * entonces devuelve true, lo cuál es correcto.
     */
    private function deletePlanRecipes($plan_id){
        $registers = PlanHasReceta::where('plan_id', $plan_id)
                                ->count();
        $delete = PlanHasReceta::where('plan_id', $plan_id)
                                ->delete();
        return $delete == $registers;
    }
}