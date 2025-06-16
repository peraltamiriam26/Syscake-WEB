<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        /** filtrar por la semana actual */
        $startWeek =  Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endWeek =  Carbon::now()->endOfWeek(Carbon::SATURDAY);
        $plans = Plan::searchAllPlanUser($startWeek, $endWeek); 
        $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $typesFood = [1 => 'Desayuno', 2 => 'Almuerzo', 3 => 'Merienda', 4 => 'Cena'];

        // Organizar datos por día y tipo de comida
        $plansOrder = [];

        foreach ($plans as  $plans_week) {
            foreach ($plans_week as $index => $plan) {
                $daysOfWeek = Carbon::parse($plan->fecha)->dayOfWeek; // 0 = Domingo, 6 = Sábado
                $plansOrder[$daysOfWeek][$plan->tipoComida_id][] = $plan;
            }
        }
        

        return view('index', [
                                'plansOrder' => $plansOrder,
                                'days' => $days,
                                'typesFood' => $typesFood,
                                'startWeek' => $startWeek,
                                'endWeek' => $endWeek
                            ]
                    );
    }

}
