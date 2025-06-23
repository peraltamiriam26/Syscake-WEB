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
    public $recetaId;
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
            // 'pasos.*.imagen' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp|max:2048', // <-- CORRECCIÓN
            'pasos.*.imagen' => 'nullable|max:2048', // <-- CORRECCIÓN
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

    // public function mount()
    // {
    //     Gate::authorize('create-receta');
        
    //     // Cargar datos iniciales para los desplegables
    //     $this->availableRecipeTypes = Tiporeceta::all()->toArray();
    //     if (!empty($this->availableRecipeTypes)) {
    //         // Establece el valor por defecto al nombre del primer tipo, si existe
    //         $this->tipoReceta = $this->availableRecipeTypes[0]['nombre'];
    //     }

    //     $this->availableIngredients = Ingrediente::all()->toArray();
    //     $this->unitTypes = Tipounidad::all()->toArray();
    // }

    public function mount($recetaId = null)
    {
        $this->recetaId = $recetaId;

        if ($this->recetaId) {
            Gate::authorize('update-receta', Receta::findOrFail($this->recetaId));
        } else {
            Gate::authorize('create-receta');
        }

        $this->availableRecipeTypes = Tiporeceta::all()->toArray();
        $this->availableIngredients = Ingrediente::all()->toArray();
        // Cargar todas las unidades en un array asociativo para fácil búsqueda por ID
        $this->unitTypes = Tipounidad::all()->keyBy('id')->toArray(); // <-- Modificado para fácil búsqueda

        if ($this->recetaId) {
            $receta = Receta::with([
                'tipoReceta',
                'ingredientes', // <-- Ya no cargamos 'unidad' aquí directamente
                'instrucciones.archivo',
                'archivo'
            ])->findOrFail($this->recetaId);

            $this->nombre = $receta->nombre;
            $this->tipoReceta = $receta->tipoReceta_id;
            $this->anonimo = $receta->es_anonimo;

            if ($receta->archivo) {
                $this->imagenPrincipal = $receta->archivo->ruta;
            } else {
                $this->imagenPrincipal = null;
            }

            $this->ingredientes = $receta->ingredientes->map(function ($ing) {
                // Obtenemos el nombre de la unidad desde el array unitTypes
                $unidadNombre = $this->unitTypes[$ing->pivot->tipounidad_id]['nombre'] ?? 'N/A';
                return [
                    'ingrediente_id' => $ing->id,
                    'ingrediente_nombre' => $ing->nombre,
                    'cantidad' => $ing->pivot->cantidad,
                    'unidad_id' => $ing->pivot->tipounidad_id,
                    'unidad_nombre' => $unidadNombre // <-- Acceso directo
                ];
            })->toArray();

            $this->pasos = $receta->instrucciones->map(function ($instruccion) {
                return [
                    'id' => $instruccion->id,
                    'descripcion' => $instruccion->descripcion,
                    'imagen' => null,
                    'imagen_path' => $instruccion->archivo ? Storage::url($instruccion->archivo->ruta) : null,
                    'archivo_id' => $instruccion->archivo_id,
                    'expanded' => false,
                ];
            })->toArray();
        } else {
            if (!empty($this->availableRecipeTypes)) {
                $this->tipoReceta = $this->availableRecipeTypes[0]['id'];
            }
        }
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
            'id' => null, // <-- ¡¡¡CORRECCIÓN CLAVE AQUÍ!!! Inicializa 'id' a null
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
    // public function saveRecipe()
    // {
    //     Gate::authorize('create-receta');

    //     Log::info('Iniciando saveRecipe');
    //     try {
    //         $this->validate();
    //         Log::info('Validación exitosa');

    //         DB::beginTransaction();
    //         Log::info('Transacción iniciada');

    //         // 1. Manejar la imagen principal de la receta
    //         $archivoPrincipalId = null;
    //         if ($this->imagenPrincipal && $this->imagenPrincipal instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
    //             $pathImagenPrincipal = $this->imagenPrincipal->store('recetas/portadas', 'public');

    //             $archivoPrincipal = Archivo::create([
    //                 'nombre' => $this->imagenPrincipal->getClientOriginalName(),
    //                 'ruta' => $pathImagenPrincipal,
    //                 'mime_type' => $this->imagenPrincipal->getMimeType(),
    //                 'size' => $this->imagenPrincipal->getSize(),
    //             ]);
    //             $archivoPrincipalId = $archivoPrincipal->id;
    //             Log::info('Imagen principal guardada y Archivo creado con ID: ' . $archivoPrincipalId);
    //         } else {
    //             Log::info('No se subió nueva imagen principal o no es un TemporaryUploadedFile válido.');
    //         }

    //         $tipoRecetaObj = Tiporeceta::where('id', $this->tipoReceta)->first();
    //         if (!$tipoRecetaObj) {
    //             throw new \Exception("Tipo de Receta no encontrado: " . $this->tipoReceta);
    //         }

    //         // 2. Guardar la Receta principal
    //         $receta = Receta::create([
    //             'nombre' => $this->nombre,
    //             'tipoReceta_id' => $tipoRecetaObj->id,
    //             'es_anonimo' => $this->anonimo,
    //             'escritor_usuario_id' => auth()->id(),
    //             'archivo_id' => $archivoPrincipalId, // Asigna el ID del archivo principal aquí
    //         ]);
    //         Log::info('Receta creada con ID: ' . $receta->id);

    //         // 3. Guardar los Ingredientes asociados
    //         foreach ($this->ingredientes as $ingredienteData) {
    //             Ingrediente_has_receta::create([
    //                 'ingrediente_id' => $ingredienteData['ingrediente_id'],
    //                 'receta_id' => $receta->id,
    //                 'cantidad' => $ingredienteData['cantidad'],
    //                 'tipounidad_id' => $ingredienteData['unidad_id'],
    //             ]);
    //         }
    //         Log::info('Ingredientes asociados guardados');

    //         // 4. Guardar los Pasos (Instrucciones)
    //         foreach ($this->pasos as $index => $pasoData) {
    //             $archivoPasoId = null;

    //             if (isset($pasoData['imagen']) && $pasoData['imagen'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
    //                 Log::info('Procesando imagen de paso ' . ($index + 1));
    //                 $pathPasoImagen = $pasoData['imagen']->store('recetas/pasos', 'public');

    //                 $archivoPaso = Archivo::create([
    //                     'nombre' => $pasoData['imagen']->getClientOriginalName(),
    //                     'ruta' => $pathPasoImagen,
    //                     'mime_type' => $pasoData['imagen']->getMimeType(),
    //                     'size' => $pasoData['imagen']->getSize(),
    //                 ]);
    //                 $archivoPasoId = $archivoPaso->id;
    //                 Log::info('Imagen de paso ' . ($index + 1) . ' guardada con Archivo ID: ' . $archivoPasoId);
    //             } else {
    //                 Log::info('No hay imagen para el paso ' . ($index + 1) . ' o no es un TemporaryUploadedFile válido.');
    //             }

    //             $receta->instrucciones()->create([
    //                 'descripcion' => $pasoData['descripcion'],
    //                 'orden' => $index + 1,
    //                 'archivo_id' => $archivoPasoId,
    //             ]);
    //         }
    //         Log::info('Pasos guardados');

    //         DB::commit();
    //         Log::info('Transacción completada exitosamente');

    //         session()->flash('message', '¡Receta guardada exitosamente!');
    //         return redirect()->route('recipe.index');

    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         DB::rollBack();
    //         Log::error('Error de validación al guardar receta: ' . $e->getMessage());
    //         Log::error('Errores de validación detallados: ' . json_encode($e->errors()));
    //         $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Error de validación: ' . $e->getMessage()]);
    //         throw $e;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error al guardar receta: ' . $e->getMessage());
    //         session()->flash('error', 'Hubo un error al guardar la receta: ' . $e->getMessage());
    //     }
    // }

    public function saveRecipe()
    {
        // Autorización:
        if ($this->recetaId) {
            Gate::authorize('update-receta', Receta::findOrFail($this->recetaId));
        } else {
            Gate::authorize('create-receta');
        }

        Log::info('Iniciando saveRecipe');
        try {
            $this->validate();
            Log::info('Validación exitosa');

            DB::beginTransaction();

            // 1. Lógica para manejar la imagen principal de la receta
            $archivoPrincipalId = null;
            if ($this->imagenPrincipal instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Se subió una NUEVA imagen principal:
                // Si estamos editando y había una imagen antigua, eliminarla.
                if ($this->recetaId) {
                    $oldReceta = Receta::find($this->recetaId);
                    if ($oldReceta && $oldReceta->archivo_id) {
                        $oldArchivo = Archivo::find($oldReceta->archivo_id);
                        if ($oldArchivo) {
                            Storage::disk('public')->delete($oldArchivo->ruta);
                            $oldArchivo->delete();
                        }
                    }
                }
                // Guardar la nueva imagen y crear/actualizar su registro en 'archivos'
                $pathImagenPrincipal = $this->imagenPrincipal->store('recetas/portadas', 'public');
                $archivoPrincipal = Archivo::create([
                    'nombre' => $this->imagenPrincipal->getClientOriginalName(),
                    'ruta' => $pathImagenPrincipal,
                    'mime_type' => $this->imagenPrincipal->getMimeType(),
                    'size' => $this->imagenPrincipal->getSize(),
                ]);
                $archivoPrincipalId = $archivoPrincipal->id;
                Log::info('Imagen principal: NUEVA cargada y Archivo creado con ID: ' . $archivoPrincipalId);
            } elseif (is_string($this->imagenPrincipal) && $this->recetaId) {
                // Es una imagen EXISTENTE y no se cambió (la propiedad contiene la ruta de Storage).
                // Necesitamos el archivo_id de la imagen existente para asociarla a la receta.
                $existingArchivo = Archivo::where('ruta', $this->imagenPrincipal)->first();
                if ($existingArchivo) {
                    $archivoPrincipalId = $existingArchivo->id;
                    Log::info('Imagen principal: EXISTENTE, no se cambió. Archivo ID: ' . $archivoPrincipalId);
                } else {
                    // Si la ruta no corresponde a ningún archivo existente (ej. se borró manualmente del storage)
                    // entonces la imagen principal de la receta se desvinculará.
                    $archivoPrincipalId = null;
                    Log::warning('Imagen principal: Ruta existente pero no encontrada en la tabla Archivos.');
                }
            } elseif ($this->imagenPrincipal === null && $this->recetaId) {
                // La imagen principal fue ELIMINADA del formulario en modo edición.
                $oldReceta = Receta::find($this->recetaId);
                if ($oldReceta && $oldReceta->archivo_id) {
                    $oldArchivo = Archivo::find($oldReceta->archivo_id);
                    if ($oldArchivo) {
                        Storage::disk('public')->delete($oldArchivo->ruta);
                        $oldArchivo->delete();
                        Log::info('Imagen principal: ELIMINADA. Antiguo Archivo ID: ' . $oldArchivo->id);
                    }
                }
                $archivoPrincipalId = null; // Establecer a nulo en la receta
            }
            // Si $this->imagenPrincipal es nulo y no hay recetaId, no se hace nada (creando sin imagen)


            // 2. Crear o Actualizar la Receta principal
            $receta = $this->recetaId ? Receta::findOrFail($this->recetaId) : new Receta();
            $receta->nombre = $this->nombre;
            $receta->tipoReceta_id = $this->tipoReceta;
            $receta->es_anonimo = $this->anonimo;
            $receta->escritor_usuario_id = auth()->id();
            $receta->archivo_id = $archivoPrincipalId; // Asigna el ID del archivo de la imagen principal
            $receta->save();
            Log::info('Receta ' . ($this->recetaId ? 'actualizada' : 'creada') . ' con ID: ' . $receta->id);


            // 3. Sincronizar Ingredientes (relación muchos a muchos con tabla pivote)
            $ingredientesData = [];
            foreach ($this->ingredientes as $ingrediente) {
                $ingredientesData[$ingrediente['ingrediente_id']] = [
                    'cantidad' => $ingrediente['cantidad'],
                    'tipounidad_id' => $ingrediente['unidad_id'],
                ];
            }
            // sync() se encarga de añadir, actualizar y eliminar entradas en la tabla pivote
            $receta->ingredientes()->sync($ingredientesData);
            Log::info('Ingredientes sincronizados');


            // 4. Sincronizar Pasos (Instrucciones) - Lógica de añadir/actualizar/eliminar
            $currentStepIds = collect($this->pasos)->pluck('id')->filter()->toArray(); // IDs de pasos existentes en el formulario

            // Eliminar pasos que ya no están en el formulario (si estamos editando)
            if ($this->recetaId) {
                $receta->instrucciones()->whereNotIn('id', $currentStepIds)->get()->each(function ($instruccionToDelete) {
                    if ($instruccionToDelete->archivo) {
                        Storage::disk('public')->delete($instruccionToDelete->archivo->ruta);
                        $instruccionToDelete->archivo->delete();
                    }
                    $instruccionToDelete->delete(); // Eliminar el registro de la instrucción
                    Log::info('Paso eliminado: ID ' . $instruccionToDelete->id);
                });
            }

            // Añadir o actualizar los pasos restantes
            foreach ($this->pasos as $index => $pasoData) {
                $instruccion = null;
                if (isset($pasoData['id']) && $pasoData['id']) {
                    // Si el paso tiene un ID, intenta encontrarlo para actualizarlo
                    $instruccion = Instruccion::find($pasoData['id']);
                }

                if (!$instruccion) {
                    // Si no se encontró (es un nuevo paso) o no tenía ID, crea una nueva instancia
                    $instruccion = new Instruccion();
                    $instruccion->receta_id = $receta->id; // Asigna al ID de la receta actual
                }

                $instruccion->descripcion = $pasoData['descripcion'];
                $instruccion->orden = $index + 1; // Mantiene el orden según la posición en el array

                $archivoPasoId = null;
                if (isset($pasoData['imagen']) && $pasoData['imagen'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    // Se subió una NUEVA imagen para este paso:
                    // Si había una imagen antigua, eliminarla antes de guardar la nueva.
                    if ($instruccion->archivo_id) {
                        $oldArchivoPaso = Archivo::find($instruccion->archivo_id);
                        if ($oldArchivoPaso) {
                            Storage::disk('public')->delete($oldArchivoPaso->ruta);
                            $oldArchivoPaso->delete();
                            Log::info('Imagen de paso: Antiguo archivo ID ' . $oldArchivoPaso->id . ' eliminado.');
                        }
                    }
                    $pathPasoImagen = $pasoData['imagen']->store('recetas/pasos', 'public');
                    $archivoPaso = Archivo::create([
                        'nombre' => $pasoData['imagen']->getClientOriginalName(),
                        'ruta' => $pathPasoImagen,
                        'mime_type' => $pasoData['imagen']->getMimeType(),
                        'size' => $pasoData['imagen']->getSize(),
                    ]);
                    $archivoPasoId = $archivoPaso->id;
                    Log::info('Imagen de paso: NUEVA cargada y Archivo creado con ID: ' . $archivoPasoId);
                } elseif (isset($pasoData['archivo_id']) && $pasoData['archivo_id']) {
                    // La imagen existente no se cambió, mantenemos su archivo_id
                    $archivoPasoId = $pasoData['archivo_id'];
                    Log::info('Imagen de paso: EXISTENTE, no se cambió. Archivo ID: ' . $archivoPasoId);
                } elseif (!isset($pasoData['imagen']) && !isset($pasoData['archivo_id']) && $instruccion->archivo_id) {
                    // La imagen fue ELIMINADA del paso en el formulario (o nunca se cargó una nueva y no había existente).
                    // Esto maneja el caso donde el usuario quitó una imagen que ya existía.
                    $oldArchivoPaso = Archivo::find($instruccion->archivo_id);
                    if ($oldArchivoPaso) {
                        Storage::disk('public')->delete($oldArchivoPaso->ruta);
                        $oldArchivoPaso->delete();
                        Log::info('Imagen de paso: ELIMINADA del formulario. Antiguo Archivo ID: ' . $oldArchivoPaso->id);
                    }
                    $archivoPasoId = null; // Establecer a nulo
                }
                // Si no se tocó la imagen y no tenía archivo_id, se mantiene nulo.

                $instruccion->archivo_id = $archivoPasoId;
                $instruccion->save();
                Log::info('Paso ' . ($pasoData['id'] ? 'actualizado' : 'creado') . ': ID ' . $instruccion->id);
            }

            DB::commit();
            session()->flash('message', 'Receta guardada exitosamente!');
            return redirect()->route('recipe.index');

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