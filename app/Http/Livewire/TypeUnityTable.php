<?php

namespace App\Http\Livewire;

use App\Models\TipoUnidad;
use Livewire\Component;
use Livewire\WithPagination;

class TypeUnityTable extends Component
{
    use WithPagination;

    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage(); // Reinicia la paginación al buscar
    }

    public function render()
    {
        $typesUnity = TipoUnidad::searchAll($this->search);

        return view('typeUnity.type-unity-table', [
            'typesUnity' => $typesUnity
        ]);
    }
}
