<?php

namespace App\Http\Livewire;

use App\Models\Tiporeceta;
use Livewire\Component;
use Livewire\WithPagination;

class TypeRecipeTable extends Component
{
    use WithPagination;

    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage(); // Reinicia la paginación al buscar
    }

    public function render()
    {
        $typesRecipes = Tiporeceta::searchAll($this->search);

        return view('typeRecipe.type-recipe-table', [
            'typesRecipes' => $typesRecipes
        ]);
    }
}
