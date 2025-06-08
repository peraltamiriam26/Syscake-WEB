<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $plans = Plan::searchAllPlanUser();
        $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $typesFood = ['Desayuno', 'Almuerzo', 'Merienda', 'Cena'];

        // Organizar datos por día y tipo de comida
        $planesOrdenados = [];

        foreach ($plans as $plan) {
            $daysOfWeek = Carbon::parse($plan->fecha)->dayOfWeek; // 0 = Domingo, 6 = Sábado
            $plansOrder[$daysOfWeek][$plan->tipoComida_id][] = $plan;
        }

        return view('index', [
                                'plansOrder' => $plansOrder,
                                'days' => $days,
                                'typesFood' => $typesFood
                            ]
                    );
    }

}
