<?php

namespace App\Http\Livewire;

use App\Models\Receta;
use App\Models\TipoComida;
use Livewire\Component;
use Livewire\WithPagination;

class RecipesTable extends Component
{
    use WithPagination;

    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage(); // Reinicia la paginación al buscar
    }

    public function render()
    {
        $recipes = Receta::searchAll($this->search);

        return view('recipe.recipes-table', [
            'recipes' => $recipes
        ]);
    }
}
