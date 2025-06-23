<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class TipoComida extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'tipocomidas';

    /** $typeFood es un parámetro de búsqueda, si es null es porque quiero
     * todos los tipos de comida
     */
    public static function searchAll($typeFood = null){
        if (!isset($typeFood)) {
            $typesFood = TipoComida::paginate(10);
        } else {
            $typesFood = TipoComida::where('descripcion', 'like', '%' . $typeFood . '%')->paginate(10);
        }
        return $typesFood;
    }

    public static function create($descripcion){
        try {
            DB::beginTransaction();
            $typeFood = new TipoComida();
            $typeFood->descripcion = strtoupper($descripcion);
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
            $typeFood = TipoComida::findModel($request_type_food->id);
            $typeFood->descripcion = strtoupper($request_type_food->descripcion);
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
        $typeFood = TipoComida::where('id', $id)->first();
        return $typeFood;
    }

    public function deleteTypeFood($id){
        try {
            DB::beginTransaction();
            $typeFood = TipoComida::where('id', $id)->first();
            if($typeFood->delete()){
                DB::commit();
                return true;
            }
            DB::rollBack(); // Revertir cambios si ocurre un error
            return false;
        } catch (Exception $e) {
            Log::debug($e);
            DB::rollBack(); // Revertir cambios si ocurre un error
            return false;
        }
    }
}
