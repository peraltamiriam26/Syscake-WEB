<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escritor;

class EscritorsController extends Controller
{
    public function create($datos)
    {
        $escritor = new Escritor();
        $escritor->esEscritor = 1;
        $escritor->usuario_id = $datos->id;
        $escritor->save();
    }
}
