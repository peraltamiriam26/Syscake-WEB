<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Support\Facades\DB; // No es necesario aquí
// use Illuminate\Support\Facades\Log; // No es necesario aquí

class Instruccion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'receta_id',
        'orden',
        'descripcion',
        'archivo_id', // <--- Cambiado a archivo_id si la imagen se guarda en el modelo Archivo
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function archivo() // Relación con el modelo Archivo
    {
        return $this->belongsTo(Archivo::class, 'archivo_id');
    }
}