<?php

namespace App\Http\Controllers;

use App\Models\Tipounidad;
use Illuminate\Http\Request;

class TipoUnidadController extends Controller
{
    //
        public function search()
    {
        $modelTipoUnidad = new Tipounidad();
        $tipoUnidads = $modelTipoUnidad->search();
        return $tipoUnidads;
    }
}
