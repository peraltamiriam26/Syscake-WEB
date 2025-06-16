<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Crear Nueva Receta</h2>

    <div class="mb-6">
        <label for="nombre_receta" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Receta:</label>
        <input type="text" id="nombre_receta" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ej. Torta de Chocolate">
    </div>

    <h3 class="text-xl font-semibold mb-3">Ingredientes</h3>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Ingrediente</th>
                <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Cantidad</th>
                <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Unidad</th>
                <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Acciones</th>
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

    <button wire:click="openIngredientModal" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        Agregar Ingrediente
    </button>

    {{-- Renderizar el componente del modal --}}
    @if ($showIngredientModal)
        <livewire:agregar-ingrediente-modal :availableIngredients="$availableIngredients" :unitTypes="$unitTypes" />
    @endif
</div>
