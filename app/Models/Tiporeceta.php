<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiporeceta extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'descripcion',
    ];

    public static function fullSearch(){
        return Tiporeceta::all();
    }
}
