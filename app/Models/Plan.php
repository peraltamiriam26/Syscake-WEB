<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Plan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'fecha',
        'usuario_id'
    ];

    public function savePlan($request){
        $user_id = auth()->user()->id;
        DB::beginTransaction();
        try {
            if (isset($request->id)) {
                $plan = Plan::findModel($request->id, $user_id);
            }else{
                $plan = new Plan();
                $plan->usuario_id = $user_id;
            }
            $plan->fecha = Carbon::parse($request->fecha)->format('Y-m-d'); 
            $plan_recipes = new PlanHasReceta();
            if ($plan->save()) {
                if ($plan_recipes->saveRecipes($request, $plan->id)){
                    DB::commit();
                    return true;
                }else{
                    throw new Exception("Error al guardar las recetas");
                }
            }else{
                throw new Exception("Error al guardar el plan");
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function findModel($id, $user_id){
        $plan = Plan::where('id', $id)->where('usuario_id', $user_id)->first();
        return $plan;
    }

    public static function searchAllPlanUser(){
        $user_id = auth()->user()->id;
        /** debo buscar los planes con las recetas */
        $plans = Plan::select('plans.id', 'plans.fecha', 'phr.receta_id', 'phr.tipoComida_id')
            ->join('plan_has_recetas as phr', 'plans.id', '=', 'phr.plan_id')
            ->where('plans.usuario_id', $user_id)
            ->get();
        return $plans;
    }
    
    public function recetas(){
        return $this->belongsToMany(Receta::class, 'plan_has_recetas', 'plan_id', 'receta_id');
    }

}
