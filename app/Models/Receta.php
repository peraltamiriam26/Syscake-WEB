<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Receta extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'archivo_id',
        'tipoReceta_id',
        'escritor_usuario_id',
        'es_anonimo',
    ];
    
    protected $hidden = [
        'id',
    ];

    public static function findModel($recipe_id){
        $recipe = Receta::where('id', $recipe_id)->first();
        return $recipe;
    }

    public function planes(){
        return $this->belongsToMany(Plan::class, 'plan_has_recetas', 'receta_id', 'plan_id');
    }

}
