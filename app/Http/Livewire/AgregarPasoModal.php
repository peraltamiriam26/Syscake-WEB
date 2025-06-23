<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class AgregarPasoModal extends Component
{
    use WithFileUploads;

    public $pasoDescripcion;
    public $imagenPaso; // Propiedad para la imagen (será TemporaryUploadedFile)

    protected $rules = [
        'pasoDescripcion' => 'required|string|min:3',
        'imagenPaso' => 'nullable|image|max:2048',
    ];

    public function addPasoToRecipe()
    {
        $this->validate();
        $tempImagePath = null;
        if ($this->imagenPaso) {
            // Livewire ya guarda temporalmente el archivo.
            // Para la vista previa en el componente padre, usamos temporaryUrl().
            $tempImagePath = $this->imagenPaso->temporaryUrl(); // <--- Esta es la URL completa
        }

        // Emitir un evento al componente padre (RecetaForm) para agregar el paso
        // Pasamos el objeto $this->imagenPaso directamente.
        $this->emit('pasoAdded', [
            'descripcion' => $this->pasoDescripcion,
            'imagen' => $this->imagenPaso, // PASAMOS EL OBJETO TemporaryUploadedFile
            'imagen_path' => $tempImagePath, // Ruta temporal para mostrar la vista previa
        ]);

        $this->reset(['pasoDescripcion', 'imagenPaso']); // Limpiar los campos del modal
        $this->emit('closePasoModal'); // Emitir evento para que el padre cierre el modal
    }

    public function closePasoModal()
    {
        $this->reset(['pasoDescripcion', 'imagenPaso']);
        $this->emit('closePasoModal');
    }

    public function render()
    {
        return view('livewire.agregar-paso-modal');
    }
}