<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Importar el trait

class AgregarPasoModal extends Component
{
    use WithFileUploads; // Usar el trait

    public $pasoDescripcion;
    public $imagenPaso; // Propiedad para la imagen
    public $showPasoModal = false; // Asegúrate de que esta propiedad se gestione correctamente en tu componente padre

    protected $rules = [
        'pasoDescripcion' => 'required|string|min:3',
        'imagenPaso' => 'nullable|image|max:1024', // Validar que sea una imagen y no exceda 1MB
    ];

    public function mount()
    {
        // Puedes inicializar propiedades si es necesario
    }

    public function addPasoToRecipe()
    {
        $this->validate();

        $imagenPath = null;
        if ($this->imagenPaso) {
            // Guarda la imagen en el directorio 'public/pasos_receta'
            // Puedes personalizar el nombre del archivo si lo necesitas
            $imagenPath = $this->imagenPaso->store('public/pasos_receta');
            // Almacenar solo la ruta relativa si prefieres no tener "public/" en la DB
            $imagenPath = str_replace('public/', '', $imagenPath);
        }

        // Emitir un evento al componente padre (RecetaForm) para agregar el paso
        $this->emit('pasoAdded', [
            'descripcion' => $this->pasoDescripcion,
            'imagen_path' => $imagenPath,
        ]);

        $this->reset(['pasoDescripcion', 'imagenPaso']); // Limpiar los campos del modal
        $this->closePasoModal(); // Cerrar el modal
    }

    public function closePasoModal()
    {
        $this->reset(['pasoDescripcion', 'imagenPaso']);
        $this->emit('closePasoModal'); // Emitir evento para que el padre cierre el modal
    }

    public function render()
    {
        return view('livewire.agregar-paso-modal');
    }
}