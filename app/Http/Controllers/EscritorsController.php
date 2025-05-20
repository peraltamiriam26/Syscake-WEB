<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escritor;

class EscritorsController extends Controller
{
    /**
     * Funcion que crea al escritor y lo guarda en la base de datos
     * Requiere del id del usuario
     */
    public function create($id)
    {
        $escritor = new Escritor();
        $escritor->esEscritor = 1;
        $escritor->usuario_id = $id;
        $escritor->save();
    }
}
