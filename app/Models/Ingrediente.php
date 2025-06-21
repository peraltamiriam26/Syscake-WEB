<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Ingrediente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'nombre'
    ];

    public static function create($nombre){
        try {
            DB::beginTransaction();
            $ingredient = new Ingrediente();
            $ingredient->nombre = $nombre;
            if($ingredient->save()){
                DB::commit();
                return true;
            }
        } catch (Exception $th) {
            DB::rollBack();
        }
        DB::rollBack();
        return false;
    }

    public static function modify($request_ingredient){
        try {
            DB::beginTransaction();
            $ingredient = Ingrediente::findModel($request_ingredient->id);
            $ingredient->nombre = $request_ingredient->nombre;
            if ($ingredient->save()) {
                DB::commit();
                return true;
            }
        } catch (Exception $th) {
            DB::rollBack();
        }
        DB::rollBack();
        return false;
    }

    public function search(){
        return Ingrediente::paginate(5);
    }
    public static function fullSearch(){
        return Ingrediente::all();
    }

    public function deleteIngredient($id){
        try {
            DB::beginTransaction();
            $ingredient = Ingrediente::where('id', $id)->first();
            if( $ingredient->delete()){
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

    public static function findModel($id){
        $ingredient = Ingrediente::where('id', $id)->first();
        return $ingredient;
    }
}
