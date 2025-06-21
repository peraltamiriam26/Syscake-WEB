<div>
    <h1>CREAR RECETA</h1>
    <div class="card card-body flex items-center">
        <div class="grid grid-flow-col justify-items-left">
            <div class="me-2">
                <label for="">Nombre</label>
                <input type="text" wire:model.defer="nombre" id="nombreReceta" placeholder="Nombre" class="input @error('nombre') is-invalid @enderror" autofocus/>
                @error('nombre')
                <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="grid grid-flow-row">
                <label for="tipoReceta" class="block text-gray-700 text-sm font-bold mb-2">Tipo de receta</label>
                <select wire:model.defer="tipoReceta" id="tipoReceta" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="dulce">Dulce</option>
                    <option value="salado">Salado</option>
                    <option value="picante">Picante</option>
                    <option value="agridulce">Agridulce</option>
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
    <div class="grid grid-flow-col justify-items-left">
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
                                    Paso {{ $index + 1 }}: {{ Str::limit($paso['descripcion'], 50) }} {{-- Mostrar solo una parte del texto --}}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    @if ($paso['imagen_path'])
                                        <img src="{{ Storage::url($paso['imagen_path']) }}" alt="Imagen del paso" class="w-16 h-16 object-cover rounded">
                                    @else
                                        No imagen
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <button wire:click.stop="removePaso({{ $index }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Eliminar</button>
                                </td>
                            </tr>
                            {{-- Fila para mostrar el detalle completo si el paso está expandido --}}
                            @if ($paso['expanded'])
                                <tr>
                                    <td colspan="3" class="py-2 px-4 border-b bg-gray-50">
                                        <div class="flex items-start">
                                            <div class="mr-4">
                                                <strong>Detalle del Paso {{ $index + 1 }}:</strong>
                                                <p>{{ $paso['descripcion'] }}</p>
                                            </div>
                                            @if ($paso['imagen_path'])
                                                <img src="{{ Storage::url($paso['imagen_path']) }}" alt="Imagen del paso" class="w-48 h-auto object-cover rounded">
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
    </div>
    <div class="flex justify-center mt-8 mb-4">
        <button type="button" wire:click="saveRecipe" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline text-lg">
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
</div>