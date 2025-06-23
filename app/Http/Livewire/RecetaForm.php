<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Receta;
use App\Models\Archivo;
use App\Models\Ingrediente;
use App\Models\Tipounidad;
use App\Models\Tiporeceta;
use App\Models\Ingrediente_has_receta;
use App\Models\Instruccion;
use App\Models\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Collection;

class RecetaForm extends Component
{
    use WithFileUploads;

    public $nombre;
    public $tipoReceta;
    public $anonimo = false;
    public $imagenPrincipal;

    public $ingredientes = [];
    public $pasos = [];

    public $showIngredientModal = false;
    public $showPasoModal = false;

    public $availableRecipeTypes = [];
    public $availableIngredients = [];
    public $unitTypes = [];

protected function rules()
    {
        return [
            'nombre' => 'required|string|min:3|max:255',
            'tipoReceta' => 'required|exists:tiporecetas,id',
            // Usamos 'mimetypes' para una validación más precisa basada en el tipo MIME del archivo.
            // Esto es más robusto que solo 'mimes' que se basa más en la extensión.
            'imagenPrincipal' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp|max:5120', // <-- CORRECCIÓN
            'ingredientes' => 'required|array|min:1',
            'ingredientes.*.ingrediente_id' => 'required|exists:ingredientes,id',
            'ingredientes.*.cantidad' => 'required|numeric|min:0.01',
            'ingredientes.*.unidad_id' => 'required|exists:tipounidads,id',
            'pasos' => 'required|array|min:1',
            'pasos.*.descripcion' => 'required|string|max:1000',
            // Usamos 'mimetypes' aquí también para consistencia y robustez.
            'pasos.*.imagen' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp|max:2048', // <-- CORRECCIÓN
        ];
    }

    protected $messages = [
        'nombre.required' => 'El nombre de la receta es obligatorio.',
        'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
        'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
        'tipoReceta.required' => 'El tipo de receta es obligatorio.',
        'tipoReceta.exists' => 'El tipo de receta seleccionado no es válido.',
        'imagenPrincipal.mimetypes' => 'La imagen principal debe ser un archivo de tipo: JPEG, PNG, JPG, GIF, SVG, o WEBP.', // Mensaje ajustado
        'imagenPrincipal.max' => 'La imagen principal no debe exceder 5MB.',
        'ingredientes.required' => 'Debes agregar al menos un ingrediente.',
        'ingredientes.min' => 'Debes agregar al menos un ingrediente.',
        'ingredientes.*.ingrediente_id.required' => 'El ingrediente es obligatorio.',
        'ingredientes.*.ingrediente_id.exists' => 'El ingrediente seleccionado no es válido.',
        'ingredientes.*.cantidad.required' => 'La cantidad del ingrediente es obligatoria.',
        'ingredientes.*.cantidad.numeric' => 'La cantidad debe ser un número.',
        'ingredientes.*.cantidad.min' => 'La cantidad debe ser mayor a cero.',
        'ingredientes.*.unidad_id.required' => 'La unidad del ingrediente es obligatoria.',
        'ingredientes.*.unidad_id.exists' => 'La unidad seleccionada no es válida.',
        'pasos.required' => 'Debes agregar al menos un paso.',
        'pasos.min' => 'Debes agregar al menos un paso.',
        'pasos.*.descripcion.required' => 'La descripción del paso es obligatoria.',
        'pasos.*.descripcion.min' => 'La descripción del paso debe tener al menos 10 caracteres.',
        'pasos.*.descripcion.max' => 'La descripción del paso no puede exceder los 1000 caracteres.',
        'pasos.*.imagen.mimetypes' => 'El archivo del paso debe ser de tipo: JPEG, PNG, JPG, GIF, SVG, o WEBP.', // Mensaje ajustado
        'pasos.*.imagen.max' => 'La imagen del paso no debe exceder 2MB.',
    ];

    // Listeners para los eventos emitidos por los modales
    protected $listeners = [
        'pasoAdded' => 'addPaso',
        'closePasoModal' => 'closePasoModal',
        'ingredientAdded' => 'addIngredient',
        'closeIngredientModal' => 'closeIngredientModal',
    ];

    public function mount()
    {
        Gate::authorize('create-receta');
        
        // Cargar datos iniciales para los desplegables
        $this->availableRecipeTypes = Tiporeceta::all()->toArray();
        if (!empty($this->availableRecipeTypes)) {
            // Establece el valor por defecto al nombre del primer tipo, si existe
            $this->tipoReceta = $this->availableRecipeTypes[0]['nombre'];
        }

        $this->availableIngredients = Ingrediente::all()->toArray();
        $this->unitTypes = Tipounidad::all()->toArray();
    }

    public function render()
    {
        return view('livewire.receta-form');
    }

    // --- Métodos para Pasos ---
    public function openPasoModal()
    {
        $this->showPasoModal = true;
    }

    public function closePasoModal()
    {
        $this->showPasoModal = false;
    }

    public function addPaso($pasoData)
    {
        $this->pasos[] = [
            'descripcion' => $pasoData['descripcion'],
            'imagen' => $pasoData['imagen'] ?? null,
            'imagen_path' => $pasoData['imagen_path'] ?? null,
            'expanded' => false,
        ];
    }

    public function removePaso($index)
    {
        if (isset($this->pasos[$index])) {
            $paso = $this->pasos[$index];
            unset($this->pasos[$index]);
            $this->pasos = array_values($this->pasos);
        }
    }

    public function togglePasoDetails($index)
    {
        if (isset($this->pasos[$index])) {
            $this->pasos[$index]['expanded'] = !$this->pasos[$index]['expanded'];
        }
    }

    // --- Métodos para Ingredientes ---
    public function openIngredientModal()
    {
        $this->showIngredientModal = true;
    }

    public function closeIngredientModal()
    {
        $this->showIngredientModal = false;
    }

    public function addIngredient($ingredientData)
    {
        $selectedIngredient = collect($this->availableIngredients)->firstWhere('id', $ingredientData['ingrediente_id']);
        $selectedUnitType = collect($this->unitTypes)->firstWhere('id', $ingredientData['unidad_id']);

        $ingredientName = $selectedIngredient['nombre'] ?? 'Desconocido';
        $unitTypeName = $selectedUnitType['nombre'] ?? 'Desconocido';

        $this->ingredientes[] = [
            'ingrediente_id' => $ingredientData['ingrediente_id'],
            'ingrediente_nombre' => $ingredientName,
            'unidad_id' => $ingredientData['unidad_id'],
            'unidad_nombre' => $unitTypeName,
            'cantidad' => $ingredientData['cantidad'],
        ];

        $this->closeIngredientModal();
    }
      public function updatedImagenPrincipal()
    {
        Log::info('--- INICIO DEBUG updatedImagenPrincipal ---');
        Log::info('Valor de $this->imagenPrincipal ANTES de la condición: ' . ($this->imagenPrincipal ? get_class($this->imagenPrincipal) : 'NULO'));

        if ($this->imagenPrincipal instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            Log::info('DEBUG: $imagenPrincipal ES una instancia de TemporaryUploadedFile.');
            Log::info('Ruta temporal de la imagen principal: ' . $this->imagenPrincipal->temporaryUrl());
            Log::info('Tipo MIME detectado para imagenPrincipal: ' . $this->imagenPrincipal->getMimeType()); // Esto debería aparecer ahora
            try {
                $this->validateOnly('imagenPrincipal');
                Log::info('Validación de imagenPrincipal exitosa en updatedImagenPrincipal.');
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error('Errores de validación en updatedImagenPrincipal: ' . json_encode($e->errors()));
            }
        } else {
            Log::info('DEBUG: $imagenPrincipal NO es una instancia de TemporaryUploadedFile. Tipo real: ' . gettype($this->imagenPrincipal));
            if (is_object($this->imagenPrincipal)) {
                Log::info('DEBUG: Clase real: ' . get_class($this->imagenPrincipal));
            }
            // Agrega un dd() temporal aquí para inspeccionar el objeto si sigue sin ser un TemporaryUploadedFile
            // dd($this->imagenPrincipal);
        }
        Log::info('--- FIN DEBUG updatedImagenPrincipal ---');
    }

    public function updatedPasos($value, $key)
    {
        if (str_contains($key, '.imagen')) {
            $index = explode('.', $key)[0];
            Log::info('--- INICIO DEBUG updatedPasos[' . $index . '][imagen] ---');
            Log::info('Valor de $this->pasos[' . $index . '][\'imagen\'] ANTES de la condición: ' . (isset($this->pasos[$index]['imagen']) ? get_class($this->pasos[$index]['imagen']) : 'NULO'));

            if (isset($this->pasos[$index]['imagen']) && $this->pasos[$index]['imagen'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                Log::info('DEBUG: pasos[' . $index . '][imagen] ES una instancia de TemporaryUploadedFile.');
                Log::info('Tipo MIME detectado para pasos.' . $index . '.imagen: ' . $this->pasos[$index]['imagen']->getMimeType());
                try {
                    $this->validateOnly('pasos.' . $index . '.imagen');
                    Log::info('Validación de pasos.' . $index . '.imagen exitosa en updatedPasos.');
                } catch (\Illuminate\Validation\ValidationException $e) {
                    Log::error('Errores de validación en updatedPasos para pasos.' . $index . '.imagen: ' . json_encode($e->errors()));
                }
            } else {
                Log::info('DEBUG: pasos[' . $index . '][imagen] NO es una instancia de TemporaryUploadedFile. Tipo real: ' . gettype($this->pasos[$index]['imagen'] ?? null));
                if (isset($this->pasos[$index]['imagen']) && is_object($this->pasos[$index]['imagen'])) {
                    Log::info('DEBUG: Clase real: ' . get_class($this->pasos[$index]['imagen']));
                }
                // dd($this->pasos[$index]['imagen']); // Descomenta para inspeccionar
            }
            Log::info('--- FIN DEBUG updatedPasos[' . $index . '][imagen] ---');
        }
    }

    public function removeIngredient($index)
    {
        unset($this->ingredientes[$index]);
        $this->ingredientes = array_values($this->ingredientes);
    }

    // --- Método para guardar la receta completa ---
    public function saveRecipe()
    {
        Gate::authorize('create-receta');

        Log::info('Iniciando saveRecipe');
        try {
            $this->validate();
            Log::info('Validación exitosa');

            DB::beginTransaction();
            Log::info('Transacción iniciada');

            // 1. Manejar la imagen principal de la receta
            $archivoPrincipalId = null;
            if ($this->imagenPrincipal && $this->imagenPrincipal instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $pathImagenPrincipal = $this->imagenPrincipal->store('recetas/portadas', 'public');

                $archivoPrincipal = Archivo::create([
                    'nombre' => $this->imagenPrincipal->getClientOriginalName(),
                    'ruta' => $pathImagenPrincipal,
                    'mime_type' => $this->imagenPrincipal->getMimeType(),
                    'size' => $this->imagenPrincipal->getSize(),
                ]);
                $archivoPrincipalId = $archivoPrincipal->id;
                Log::info('Imagen principal guardada y Archivo creado con ID: ' . $archivoPrincipalId);
            } else {
                Log::info('No se subió nueva imagen principal o no es un TemporaryUploadedFile válido.');
            }

            $tipoRecetaObj = Tiporeceta::where('id', $this->tipoReceta)->first();
            if (!$tipoRecetaObj) {
                throw new \Exception("Tipo de Receta no encontrado: " . $this->tipoReceta);
            }

            // 2. Guardar la Receta principal
            $receta = Receta::create([
                'nombre' => $this->nombre,
                'tipoReceta_id' => $tipoRecetaObj->id,
                'es_anonimo' => $this->anonimo,
                'escritor_usuario_id' => auth()->id(),
                'archivo_id' => $archivoPrincipalId, // Asigna el ID del archivo principal aquí
            ]);
            Log::info('Receta creada con ID: ' . $receta->id);

            // 3. Guardar los Ingredientes asociados
            foreach ($this->ingredientes as $ingredienteData) {
                Ingrediente_has_receta::create([
                    'ingrediente_id' => $ingredienteData['ingrediente_id'],
                    'receta_id' => $receta->id,
                    'cantidad' => $ingredienteData['cantidad'],
                    'tipounidad_id' => $ingredienteData['unidad_id'],
                ]);
            }
            Log::info('Ingredientes asociados guardados');

            // 4. Guardar los Pasos (Instrucciones)
            foreach ($this->pasos as $index => $pasoData) {
                $archivoPasoId = null;

                if (isset($pasoData['imagen']) && $pasoData['imagen'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    Log::info('Procesando imagen de paso ' . ($index + 1));
                    $pathPasoImagen = $pasoData['imagen']->store('recetas/pasos', 'public');

                    $archivoPaso = Archivo::create([
                        'nombre' => $pasoData['imagen']->getClientOriginalName(),
                        'ruta' => $pathPasoImagen,
                        'mime_type' => $pasoData['imagen']->getMimeType(),
                        'size' => $pasoData['imagen']->getSize(),
                    ]);
                    $archivoPasoId = $archivoPaso->id;
                    Log::info('Imagen de paso ' . ($index + 1) . ' guardada con Archivo ID: ' . $archivoPasoId);
                } else {
                    Log::info('No hay imagen para el paso ' . ($index + 1) . ' o no es un TemporaryUploadedFile válido.');
                }

                $receta->instrucciones()->create([
                    'descripcion' => $pasoData['descripcion'],
                    'orden' => $index + 1,
                    'archivo_id' => $archivoPasoId,
                ]);
            }
            Log::info('Pasos guardados');

            DB::commit();
            Log::info('Transacción completada exitosamente');

            session()->flash('message', '¡Receta guardada exitosamente!');
            return redirect()->route('recetas.index');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación al guardar receta: ' . $e->getMessage());
            Log::error('Errores de validación detallados: ' . json_encode($e->errors()));
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Error de validación: ' . $e->getMessage()]);
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar receta: ' . $e->getMessage());
            session()->flash('error', 'Hubo un error al guardar la receta: ' . $e->getMessage());
        }
    }
}