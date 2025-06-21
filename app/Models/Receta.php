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

    public function ingredientes()
    {
        return $this->hasMany(Ingrediente_has_receta::class);
    }

    public function pasos()
    {
        return $this->hasMany(Instruccion::class)->orderBy('orden');
    }

    // Si tienes un modelo Ingrediente y Unidad, y tu tabla pivote es 'ingrediente_recetas'
    // public function ingredientesRelacionados()
    // {
    //     return $this->belongsToMany(Ingrediente::class, 'ingrediente_recetas')
    //                 ->withPivot('cantidad', 'unidad_id'); // Asegúrate de incluir los campos pivot que necesitas
    // }

}
