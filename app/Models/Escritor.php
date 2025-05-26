<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Escritor extends Model
{
    use HasFactory;

    protected $fillable = [
        'esEscritor',
        'usuario_id',
    ];
}
