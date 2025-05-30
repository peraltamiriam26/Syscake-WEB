<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ingrediente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'nombre'
    ];

    public static function create($nombre){
        $ingredient = new Ingrediente();
        $ingredient->nombre = $nombre;
        return $ingredient->save();
    }

    public function search(){
        return Ingrediente::paginate(15);
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
}
