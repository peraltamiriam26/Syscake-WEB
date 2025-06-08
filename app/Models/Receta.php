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

}
