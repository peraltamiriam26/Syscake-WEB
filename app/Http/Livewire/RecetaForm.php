<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection; // Make sure to import Collection

class RecetaForm extends Component
{
    public $ingredientes = [];
    public $showIngredientModal = false;

    // Make sure these are arrays of associative arrays with 'id' and 'name'
    public $availableIngredients = [
        ['id' => 1, 'name' => 'Harina'],
        ['id' => 2, 'name' => 'Azúcar'],
        ['id' => 3, 'name' => 'Huevos'],
        ['id' => 4, 'name' => 'Leche'],
        ['id' => 5, 'name' => 'Sal'],
    ];

    public $unitTypes = [
        ['id' => 1, 'name' => 'Gramos (gr)'],
        ['id' => 2, 'name' => 'Kilogramos (kg)'],
        ['id' => 3, 'name' => 'Mililitros (ml)'],
        ['id' => 4, 'name' => 'Litros (l)'],
        ['id' => 5, 'name' => 'Unidades (u)'],
        ['id' => 6, 'name' => 'Cucharadas (cda)'],
        ['id' => 7, 'name' => 'Cucharaditas (cdita)'],
    ];

    protected $listeners = [
        'ingredientAdded' => 'addIngredient',
        'closeIngredientModal' => 'closeModal',
    ];

    public function openIngredientModal()
    {
        $this->showIngredientModal = true;
    }

    public function closeModal()
    {
        $this->showIngredientModal = false;
    }

    public function addIngredient($ingredientData)
    {
        // Use optional() helper or more explicit checks for safer access
        // It's crucial that $ingredientData['ingrediente_id'] and $ingredientData['unidad_id']
        // actually contain valid IDs from your lists.

        $selectedIngredient = collect($this->availableIngredients)->firstWhere('id', $ingredientData['ingrediente_id']);
        $selectedUnitType = collect($this->unitTypes)->firstWhere('id', $ingredientData['unidad_id']);

        $ingredientName = $selectedIngredient['name'] ?? 'Desconocido';
        $unitTypeName = $selectedUnitType['name'] ?? 'Desconocido';

        // Add null checks for robustness if $selectedIngredient or $selectedUnitType could be null
        // For example, if 'id' from dropdown is not found in your lists.
        // This makes sure you don't try to access ['name'] on a null result.
        // The ?? 'Desconocido' on the right side already handles the case where firstWhere returns null
        // and you attempt to access ['name'] on it.

        $this->ingredientes[] = [
            'ingrediente_id' => $ingredientData['ingrediente_id'],
            'ingrediente_nombre' => $ingredientName,
            'unidad_id' => $ingredientData['unidad_id'],
            'unidad_nombre' => $unitTypeName,
            'cantidad' => $ingredientData['cantidad'],
        ];

        $this->closeModal();
    }

    public function removeIngredient($index)
    {
        unset($this->ingredientes[$index]);
        $this->ingredientes = array_values($this->ingredientes);
    }

    public function render()
    {
        return view('livewire.receta-form');
    }
}