<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];

    public static function create($nombre){
        $ingredient = new Ingrediente();
        $ingredient->nombre = $nombre;
        return $ingredient->save();
    }
}
