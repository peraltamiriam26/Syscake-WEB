<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente_has_receta extends Model
{
    use HasFactory;

    protected $table = 'ingrediente_has_recetas'; // Asegúrate de que el nombre de la tabla sea correcto si no sigue la convención de pluralización

    protected $fillable = [
        'ingrediente_id',
        'receta_id',
        'cantidad',
        'tipounidad_id', // ¡Crucial! Debe coincidir con la columna en tu migración y el valor que recibes
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class);
    }

    public function tipoUnidad() // Renombrado a camelCase y más descriptivo
    {
        return $this->belongsTo(Tipounidad::class, 'tipounidad_id'); // Usar 'tipounidad_id' como FK
    }
}
