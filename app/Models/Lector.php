<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lector extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'esLector',
        'usuario_id',
    ];
    
    protected $primaryKey = 'usuario_id';

        /**
     * Funcion que crea al lector y lo guarda en la base de datos
     */
    public function create($id)
    {
        $lector = new Lector();
        $lector->esLector = 1;
        $lector->usuario_id = $id;
        return $lector->save();
    }

    public static function searchReader($id){
        $reader = Lector::where('usuario_id', $id)
                        ->first();
        return $reader;
    }
}
