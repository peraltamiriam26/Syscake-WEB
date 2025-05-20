<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lector;

class LectorsController extends Controller
{
    /**
     * Funcion que crea al lector y lo guarda en la base de datos
     */
    public function create($id)
    {
        $lector = new Lector();
        $lector->esLector = 1;
        $lector->usuario_id = $id;
        $lector->save();
    }
}
