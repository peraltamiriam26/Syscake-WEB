<form wire:submit.prevent="saveRecipe" enctype="multipart/form-data">
    <div>
        <h1>CREAR RECETA</h1>
        <div class="card card-body flex items-center">
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
                <div>
                    <input class="form-check-input" type="checkbox" wire:model.defer="anonimo" id="anonimo">
                    <label class="form-check-label" for="anonimo">
                        Anónimo
                    </label>
                </div>
            </div>
        </div>

        {{-- --- NUEVA SECCIÓN PARA LA IMAGEN PRINCIPAL DE LA RECETA --- --}}
        <div class="card card-body flex items-center mt-4">
            <h2 class="text-xl font-bold mb-4">Imagen Principal de la Receta</h2>
            <div class="w-full">
                <label for="imagenPrincipal" class="block text-gray-700 text-sm font-bold mb-2">Subir Imagen Principal:</label>
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
                {{-- FIN DE LA SECCIÓN CORREGIDA --}}
            </div>
        </div>
        {{-- --- FIN DE NUEVA SECCIÓN --- --}}

        <div class="grid grid-flow-col justify-items-left mt-4"> {{-- Añadido mt-4 para espacio --}}
            <div class="card card-body flex items-center">
                <div class="grid grid-flow-col">
                    <h1>INGREDIENTES</h1>
                    <button wire:click="openIngredientModal" class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe rounded-full">
                        Agregar
                    </button>
                </div>
                <div>
                    <table class="border-collapse border border-gray-400 ...">
                        <thead>
                            <tr>
                                <th class="border border-gray-300">Ingrediente</th>
                                <th class="border border-gray-300">Unidad</th>
                                <th class="border border-gray-300">Cantidad</th>
                                <th class="border border-gray-300">Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ingredientes as $index => $ingrediente)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $ingrediente['ingrediente_nombre'] }}</td>
                                <td class="py-2 px-4 border-b">{{ $ingrediente['cantidad'] }}</td>
                                <td class="py-2 px-4 border-b">{{ $ingrediente['unidad_nombre'] }}</td>
                                <td class="py-2 px-4 border-b">
                                    <button wire:click="removeIngredient({{ $index }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Eliminar</button>
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
                @error('ingredientes')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
            </div>
            <div class="card card-body flex items-center">
                <div class="grid grid-flow-col">
                    <h1>PASOS</h1>
                    <button wire:click="openPasoModal" class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe rounded-full">
                        Agregar
                    </button>
                </div>
                <div>
                    <table class="border-collapse border border-gray-400 ...">
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
                                        Paso {{ $index + 1 }}: {{ Str::limit($paso['descripcion'], 50) }}
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        @if ($paso['imagen_path'])
                                            <img src="{{ $paso['imagen_path'] }}" alt="Imagen del paso" class="w-16 h-16 object-cover rounded">
                                        @else
                                            No imagen
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <button wire:click.stop="removePaso({{ $index }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Eliminar</button>
                                    </td>
                                </tr>
                                @if ($paso['expanded'])
                                    <tr>
                                        <td colspan="3" class="py-2 px-4 border-b bg-gray-50">
                                            <div class="flex items-start">
                                                <div class="mr-4">
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
                @error('pasos')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex justify-center mt-8 mb-4">
            {{-- El botón submit debe estar dentro del <form> y ser de type="submit" --}}
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline text-lg">
                Guardar Receta Completa
            </button>
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