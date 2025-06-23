<?php

namespace App\Http\Livewire;

use App\Models\TipoComida;
use Livewire\Component;
use Livewire\WithPagination;

class TypeFoodTable extends Component
{
    use WithPagination;

    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage(); // Reinicia la paginación al buscar
    }

    public function render()
    {
        $typesFood = TipoComida::searchAll($this->search);

        return view('typeFood.type-food-table', [
            'typesFood' => $typesFood
        ]);
    }
}
