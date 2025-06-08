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
        
        if ($this->saveRecipesFood($recipes_breakfast, $plan_id, PlanHasReceta::BREAKFAST) && $this->saveRecipesFood($recipes_lunch, $plan_id, PlanHasReceta::LUNCH)
            && $this->saveRecipesFood($recipes_snack, $plan_id, PlanHasReceta::SNACK) && $this->saveRecipesFood($recipes_dinner, $plan_id, PlanHasReceta::DINNER) ) {
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
}