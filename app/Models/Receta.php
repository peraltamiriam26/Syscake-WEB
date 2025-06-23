<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
    // protected $hidden = [
    //     'id',
    // ];

    public function ingredientes_receta() // Un nombre más descriptivo
    {
        return $this->hasMany(Ingrediente_has_receta::class);
    }

    // Relación con los pasos (Instrucciones)
    public function instrucciones()
    {
        return $this->hasMany(Instruccion::class);
    }
    
    // Relación con el tipo de comida
    public function tipoReceta() // Relación con TipoReceta
    {
        return $this->belongsTo(Tiporeceta::class, 'tipoReceta_id', 'id');
    }
    
    // Relación con el usuario que creó la receta
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'escritor_usuario_id'); // O 'user_id' si es lo que usas
    }

    // Si tu receta tiene una imagen de portada asociada a un modelo Archivo
    public function archivo()
    {
        return $this->belongsTo(Archivo::class, 'archivo_id');
    }

    public static function findModel($recipe_id){
        $recipe = Receta::where('id', $recipe_id)->first();
        return $recipe;
    }

    public function planes(){
        return $this->belongsToMany(Plan::class, 'plan_has_recetas', 'receta_id', 'plan_id');
    }

}
