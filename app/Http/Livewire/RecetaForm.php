<?php

namespace App\Http\Livewire;
use App\Models\Ingrediente;
use App\Models\Tipounidad;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Collection; // Make sure to import Collection

class RecetaForm extends Component
{
    public $ingredientes = [];
    public $showIngredientModal = false;
    public $showPasoModal = false;
    // Make sure these are arrays of associative arrays with 'id' and 'nombre'
    public $availableIngredients = [];
    public $unitTypes = [];
    public $pasos = []; // Nueva propiedad para almacenar los pasos
    public $nombre;
    public $tipoReceta;
    public $anonimo = false;

    // Propiedades para controlar el detalle de cada paso
    public $expandedPasoIndex = null;

    protected $listeners = [
        'pasoAdded' => 'addPaso',
        'closePasoModal' => 'closePasoModal',
        'ingredientAdded' => 'addIngredient',
        'closeIngredientModal' => 'closeIngredientModal',
    ];

     public function mount()
    {
        // Carga los ingredientes disponibles aquí
        // Suponiendo que fullSearch() devuelve una colección o array de ingredientes
        $this->availableIngredients = Ingrediente::fullSearch()->toArray(); // O ->all() si devuelve una colección Eloquent
        $this->unitTypes = Tipounidad::fullSearch()->toArray(); // O ->all() si devuelve una colección Eloquent
    }

    public function addPaso($pasoData)
    {
        $this->pasos[] = [
            'descripcion' => $pasoData['descripcion'],
            'imagen_path' => $pasoData['imagen_path'],
            'expanded' => false, // Para controlar el despliegue del detalle
        ];
        // Opcional: ordenar los pasos o asignar un número de paso
    }

        public function removePaso($index)
    {
        // Verifica si el índice es válido
        if (isset($this->pasos[$index])) {
            $paso = $this->pasos[$index];

            // Elimina la imagen del almacenamiento si existe
            if (!empty($paso['imagen_path'])) {
                // Asegúrate de que la ruta sea correcta para Storage::delete()
                // Si guardaste con str_replace('public/', '', $imagenPath), entonces necesitas prefijar con 'public/' aquí
                $fullPath = 'public/' . $paso['imagen_path'];
                if (Storage::exists($fullPath)) {
                    Storage::delete($fullPath);
                }
            }

            // Elimina el paso del array
            unset($this->pasos[$index]);

            // Reindexa el array para evitar problemas con los índices futuros
            $this->pasos = array_values($this->pasos);
        }
    }

    public function togglePasoDetails($index)
    {
        // Si ya está expandido, lo contrae. Si no, lo expande.
        $this->pasos[$index]['expanded'] = !$this->pasos[$index]['expanded'];

        // Opcional: Si solo quieres que un paso esté expandido a la vez
        // if ($this->expandedPasoIndex === $index) {
        //     $this->expandedPasoIndex = null;
        // } else {
        //     $this->expandedPasoIndex = $index;
        // }
    }

    public function openIngredientModal()
    {
        $this->showIngredientModal = true;
    }

    public function closeIngredientModal()
    {
        $this->showIngredientModal = false;
    }
    public function openPasoModal()
    {
        $this->showPasoModal = true;
    }

    public function closePasoModal()
    {
        $this->showPasoModal = false;
    }

    public function addIngredient($ingredientData)
    {
        // Use optional() helper or more explicit checks for safer access
        // It's crucial that $ingredientData['ingrediente_id'] and $ingredientData['unidad_id']
        // actually contain valid IDs from your lists.

        $selectedIngredient = collect($this->availableIngredients)->firstWhere('id', $ingredientData['ingrediente_id']);
        $selectedUnitType = collect($this->unitTypes)->firstWhere('id', $ingredientData['unidad_id']);

        $ingredientName = $selectedIngredient['nombre'] ?? 'Desconocido';
        $unitTypeName = $selectedUnitType['nombre'] ?? 'Desconocido';

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

        $this->closeIngredientModal();
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