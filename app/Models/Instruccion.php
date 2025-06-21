<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Instruccion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'receta_id',
        'orden',
        'descripcion',
        'imagen_path',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }
}