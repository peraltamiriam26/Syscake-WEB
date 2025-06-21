<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente_has_receta extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingrediente_id',
        'receta_id',
        'cantidad',
        'tipounidad_id',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class); // Suponiendo que tienes un modelo Ingrediente
    }

    public function unidad()
    {
        return $this->belongsTo(Tipounidad::class, 'unidad_id'); // Suponiendo que tienes un modelo UnidadMedida y tu clave foránea es 'unidad_id'
    }
}
