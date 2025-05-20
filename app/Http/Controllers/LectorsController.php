<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lector;

class LectorsController extends Controller
{
    public function create($datos)
    {
        $lector = new Lector();
        $lector->esLector = 1;
        $lector->usuario_id = $datos->id;
        $lector->save();
    }
}
