<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AgregarIngredienteModal extends Component
{
    public $ingrediente_id;
    public $cantidad;
    public $unidad_id;

    public $availableIngredients; // Pasado desde el padre
    public $unitTypes; // Pasado desde el padre

    // Definir las reglas de validación
    protected $rules = [
        'ingrediente_id' => 'required', // 'exists' es un ejemplo, se validaría contra la BD real
        'cantidad' => 'required|numeric|min:1',
        'unidad_id' => 'required', // 'exists' es un ejemplo
    ];

    // Propiedad que se ejecutará al iniciar el componente
    public function mount($availableIngredients, $unitTypes)
    {
        $this->availableIngredients = $availableIngredients;
        $this->unitTypes = $unitTypes;

        // Establecer valores por defecto si hay opciones
        $this->ingrediente_id = $availableIngredients[0]['id'] ?? null;
        $this->unidad_id = $unitTypes[0]['id'] ?? null;
    }

    public function addIngredientToRecipe()
    {
        $this->validate();

        $this->emitUp('ingredientAdded', [
            'ingrediente_id' => $this->ingrediente_id,
            'cantidad' => $this->cantidad,
            'unidad_id' => $this->unidad_id,
        ]);

        // Resetear los campos del formulario del modal (opcional)
        $this->reset(['ingrediente_id', 'cantidad', 'unidad_id']);
    }

    public function closeModal()
    {
        $this->emitUp('closeIngredientModal');
    }

    public function render()
    {
        return view('livewire.agregar-ingrediente-modal');
    }
}