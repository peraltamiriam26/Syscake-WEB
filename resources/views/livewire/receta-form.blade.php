<form wire:submit.prevent="saveRecipe" enctype="multipart/form-data">
    <div>
        <div class="card">
            <div class="grid grid-cols-12 gap-12">
                <div class="card-body col-span-12">
                    <!-- TITULO -->
                    <div class="col-span-12 pb-2">
                        <h5 class="card-title float-left">Crear receta</h5>
                    </div>
                    <div class="grid grid grid-flow-row">
                        <div class="grid grid-flow-col justify-items-left">
                            <div class="me-2">
                                <label for="nombreReceta">Nombre</label>
                                <input type="text" wire:model.defer="nombre" id="nombreReceta" placeholder="Nombre" class="input @error('nombre') is-invalid @enderror" autofocus/>
                                @error('nombre')
                                <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
                                @enderror
                            </div>                        
                            <div class="grid grid-flow-row">
                                <label for="tipoReceta" class="block text-gray-700 text-sm font-bold mb-2">Tipo de receta</label>
                                <select wire:model.defer="tipoReceta" id="tipoReceta" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">---- Selecciona un tipo ----</option>
                                    @foreach($availableRecipeTypes as $availableRecipeType)
                                        <option value="{{ $availableRecipeType['id'] }}">{{ $availableRecipeType['nombre'] }}</option>
                                    @endforeach
                                </select>
                            @error('tipoReceta') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid grid-flow-col justify-items-left pt-4">
                            <div>
                                <input class="form-check-input" type="checkbox" wire:model.defer="anonimo" id="anonimo">
                                <label class="form-check-label" for="anonimo"> Anónimo </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- --- NUEVA SECCIÓN PARA LA IMAGEN PRINCIPAL DE LA RECETA --- --}}
        <div class="card grid grid-cols-12 gap-12 mt-2">
            <div class="grid grid-cols-12 gap-12">
                <div class="card-body col-span-12">
                    <div class="col-span-12 pb-2">
                        <h6 class=" card-title mb-4">Subir imagen</h6>
                    </div>
                    <div class="grid grid grid-flow-row">
                        <!-- <label for="imagenPrincipal" class="block text-gray-700 text-sm font-bold mb-2">Subir imagen:</label> -->
                        <input type="file" id="imagenPrincipal" wire:model="imagenPrincipal" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                        file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100">
                        @error('imagenPrincipal') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
        
                        {{-- INICIO DE LA SECCIÓN CORREGIDA --}}
                        @if ($imagenPrincipal)
                            {{-- Si $imagenPrincipal es un objeto TemporaryUploadedFile (cuando se acaba de subir) --}}
                            @if ($imagenPrincipal instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                <img src="{{ $imagenPrincipal->temporaryUrl() }}" class="mt-4 w-48 h-auto object-cover rounded shadow-md" alt="Vista previa de la nueva imagen">
                                {{-- Si $imagenPrincipal es una cadena de texto (cuando se está editando una receta existente y ya tiene imagen) --}}
                            @elseif (is_string($imagenPrincipal))
                                <img src="{{ Storage::url($imagenPrincipal) }}" class="mt-4 w-48 h-auto object-cover rounded shadow-md" alt="Imagen actual de la receta">
                            @endif
                        @endif
                        {{-- Opción para eliminar la imagen principal si está presente y en modo edición --}}
                        @if (is_string($imagenPrincipal) && $recetaId) {{-- Solo si es una imagen existente y estamos editando --}}
                            <button type="button" wire:click="$set('imagenPrincipal', null)" class="mt-2 text-red-500 hover:text-red-700 text-sm">Eliminar Imagen Principal</button>
                        @endif
                        {{-- FIN DE LA SECCIÓN CORREGIDA --}}
                    </div>
                </div>
            </div>
        </div>
                
        {{-- --- FIN DE NUEVA SECCIÓN --- --}}

        <div class="grid grid grid-cols-12 gap-2 mt-2"> {{-- Añadido mt-4 para espacio --}}
            <!-- PRIMER CARD A LA IZQUIERDA -->
            <div class="card col-span-6">
                <div class="card-body col-span-6">
                    <div class="col-span-6 mb-2">
                        <h6 class="card-title float-left"> Ingredientes </h6>
                        <button type="button" wire:click="openIngredientModal" class="btn btn-success float-right rounded-full"> 
                            <span class="icon-[tabler--plus] size-5"> </span>Agregar 
                        </button>
                    </div>
                    <div class="col-span-6">
                        <table class="table w-full table-auto overflow-auto">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300">Ingrediente</th>
                                    <th class="border border-gray-300">Cantidad</th>
                                    <th class="border border-gray-300">Unidad</th>
                                    <th class="border border-gray-300">Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ingredientes as $index => $ingrediente)
                                <tr>
                                    <td class="py-2 px-4 border-b break-normal whitespace-normal">{{ $ingrediente['ingrediente_nombre'] }}</td>
                                    <td class="py-2 px-4 border-b">{{ $ingrediente['cantidad'] }}</td>
                                    <td class="py-2 px-4 border-b break-normal whitespace-normal">{{ $ingrediente['unidad_nombre'] }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a type="button" wire:click="removeIngredient({{ $index }})" class="btn btn-circle btn-text btn-sm">
                                            <span class="icon-[tabler--trash] size-5 bg-error"></span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 px-4 text-center text-gray-500">No hay ingredientes agregados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @error('ingredientes')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
            </div>
            <!-- SEGUNDO CARD A LA DERECHA -->
            <div class="card col-span-6 max-w-full overflow-auto">
                <div class="card-body col-span-6">
                    <div class="col-span-6 mb-2">
                        <h1 class="card-title float-left"> Pasos </h1>
                        <button type="button" wire:click="openPasoModal" class="btn btn-success float-right rounded-full">
                            <span class="icon-[tabler--plus] size-5"> </span>Agregar
                        </button>
                    </div>
                    <div class="col-span-6 mb-2">
                        <table class="table w-full table-fixed  overflow-auto">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300">Paso</th>
                                    <th class="border border-gray-300">Imagen</th>
                                    <th class="border border-gray-300">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pasos as $index => $paso)
                                    <tr class="cursor-pointer hover:bg-gray-100" wire:click="togglePasoDetails({{ $index }})">
                                        <td class="py-2 px-4 border-b">
                                            Paso {{ $index + 1 }}: {{ Str::limit($paso['descripcion'], 10) }}
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            @if ($paso['imagen_path'])
                                                <img src="{{ $paso['imagen_path'] }}" alt="Imagen del paso" class="w-16 h-16 object-cover rounded">
                                            @else
                                                No imagen
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <a type="button" wire:click.stop="removePaso({{ $index }})" class="btn btn-circle btn-text btn-sm"> 
                                                <span class="icon-[tabler--trash] size-5 bg-error"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    @if ($paso['expanded'])
                                        <tr>
                                            <td colspan="3" class="py-2 px-4 border-b bg-gray-50 overflow-auto max-w-full">
                                                <div class="flex items-start">
                                                    <div class="mr-4 break-normal whitespace-normal">
                                                        <strong>Detalle del Paso {{ $index + 1 }}:</strong>
                                                        <p>{{ $paso['descripcion'] }}</p>
                                                    </div>
                                                    @if ($paso['imagen_path'])
                                                        {{-- ¡¡¡AQUÍ ESTÁ LA CORRECCIÓN!!! --}}
                                                        {{-- Debes distinguir si es una imagen temporal de Livewire o una ya guardada --}}
                                                        @if (isset($paso['imagen']) && $paso['imagen'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                                            <img src="{{ $paso['imagen']->temporaryUrl() }}" alt="Imagen del paso" class="w-48 h-auto object-cover rounded">
                                                        @elseif (is_string($paso['imagen_path']))
                                                            <img src="{{ Storage::url($paso['imagen_path']) }}" alt="Imagen del paso" class="w-48 h-auto object-cover rounded">
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-4 px-4 text-center text-gray-500">No hay pasos agregados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @error('pasos')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="card mt-2">
            <div class="grid grid-cols-12 gap-12">
                <div class="card-body col-span-12">
                    <div class="grid grid grid-flow-row">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('recipe.index') }}" class="btn btn-outline">
                                Cancelar
                            </a>
                            {{-- El botón submit debe estar dentro del <form> y ser de type="submit" --}}
                            <button type="submit" class="btn btn-primary inline-flex items-center gap-2">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Renderizar el componente del modal --}}
        @if ($showIngredientModal)
        <livewire:agregar-ingrediente-modal :availableIngredients="$availableIngredients" :unitTypes="$unitTypes" />
        @endif
        @if ($showPasoModal)
        <livewire:agregar-paso-modal/>
        @endif
    </div>
</form>