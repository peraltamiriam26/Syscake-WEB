<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;
use Illuminate\Support\Facades\Log;

class Tiporeceta extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $table = 'tiporecetas';
    
    protected $fillable = [
        'descripcion',
    ];

    public static function fullSearch(){
        return Tiporeceta::all();
    }

/** $typeFood es un parámetro de búsqueda, si es null es porque quiero
     * todos los tipos de comida
     */
    public static function searchAll($typeFood = null){
        if (!isset($typeFood)) {
            $typesFood = Tiporeceta::paginate(10);
        } else {
            $typesFood = Tiporeceta::where('nombre', 'like', '%' . $typeFood . '%')->paginate(10);
        }
        return $typesFood;
    }

    public static function create($nombre){
        try {
            DB::beginTransaction();
            $typeFood = new Tiporeceta();
            $typeFood->nombre = strtoupper($nombre);
            if($typeFood->save()){
                DB::commit();
                return true;
            }
        } catch (Exception $th) {
            Log::debug($th);
            DB::rollBack();
        }
        DB::rollBack();
        return false;
    }

    public static function modify($request_type_food){
        try {
            DB::beginTransaction();
            $typeFood = Tiporeceta::findModel($request_type_food->id);
            $typeFood->nombre = strtoupper($request_type_food->nombre);
            if ($typeFood->save()) {
                DB::commit();
                return true;
            }
        } catch (Exception $th) {
            DB::rollBack();
        }
        DB::rollBack();
        return false;
    }

    public static function findModel($id){
        $typeFood = Tiporeceta::where('id', $id)->first();
        return $typeFood;
    }

    public function deletetypeRecipe($id){
        try {
            DB::beginTransaction();
            $typeFood = Tiporeceta::where('id', $id)->first();
            if($typeFood->delete()){
                DB::commit();
                return true;
            }
            DB::rollBack(); // Revertir cambios si ocurre un error
            return false;
        } catch (Exception $e) {
            DB::rollBack(); // Revertir cambios si ocurre un error
            return false;
        }
    }
}
