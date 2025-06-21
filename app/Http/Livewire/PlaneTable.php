<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Plan;
use App\Models\PlanHasReceta;
use App\Models\Receta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PlaneTable extends Component
{
    use WithPagination;

    public $search = '';
    public $thisWeek;
    public $startWeek;
    public $endWeek;

    public function mount()
    {
        $this->startWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY); // o la fecha que quieras como base
        $this->endWeek =  Carbon::now()->endOfWeek(Carbon::SATURDAY);

    }

    public function prevWeek()
    {
        $this->startWeek = $this->startWeek->subWeek();
        $this->endWeek = $this->endWeek->subWeek();
    }

    public function nextWeek()
    {
        $this->startWeek = $this->startWeek->addWeek();
        $this->endWeek = $this->endWeek->addWeek();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
         /** filtrar por la semana actual */
        $plans = Plan::searchAllPlanUser($this->startWeek, $this->endWeek); 
        $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $today = Carbon::now()->locale('es'); // Asegurate de establecer el locale en español
        $nameToday = $today->dayName; // Por ejemplo: 'lunes', 'martes', etc.
        $typesFood = [1 => 'Desayuno', 2 => 'Almuerzo', 3 => 'Merienda', 4 => 'Cena'];

        // Organizar datos por día y tipo de comida
        $plansOrder = [];

        foreach ($plans as  $plans_week) {
            foreach ($plans_week as $index => $plan) {
                $daysOfWeek = Carbon::parse($plan->fecha)->dayOfWeek; // 0 = Domingo, 6 = Sábado
                $plansOrder[$daysOfWeek][$plan->tipoComida_id][] = $plan;
            }
        }        

        $recipesToday = PlanHasReceta::searchRecipesPlanDayUser($today);
        return view('plan.plane-table', [
                                'plansOrder' => $plansOrder,
                                'days' => $days,
                                'typesFood' => $typesFood,
                                'startWeek' => $this->startWeek,
                                'endWeek' => $this->endWeek,
                                'nameToday' => $nameToday,
                                'recipes' => $recipesToday
                            ]
                    );
    }
}
