<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-xl font-bold mb-4">Agregar Ingrediente</h3>

        <form wire:submit.prevent="addIngredientToRecipe">
            <div class="mb-4">
                <label for="ingrediente" class="block text-gray-700 text-sm font-bold mb-2">Ingrediente:</label>
                <select wire:model="ingrediente_id" id="ingrediente" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Seleccione un ingrediente</option>
                    @foreach($availableIngredients as $ingredient)
                        <option value="{{ $ingredient['id'] }}">{{ $ingredient['name'] }}</option>
                    @endforeach
                </select>
                @error('ingrediente_id') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="cantidad" class="block text-gray-700 text-sm font-bold mb-2">Cantidad:</label>
                <input type="number" step="0.01" wire:model.defer="cantidad" id="cantidad" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ej. 250">
                @error('cantidad') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="unidad" class="block text-gray-700 text-sm font-bold mb-2">Unidad:</label>
                <select wire:model="unidad_id" id="unidad" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Seleccione una unidad</option>
                    @foreach($unitTypes as $unit)
                        <option value="{{ $unit['id'] }}">{{ $unit['name'] }}</option>
                    @endforeach
                </select>
                @error('unidad_id') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" wire:click="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2 focus:outline-none focus:shadow-outline">
                    Cancelar
                </button>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Aceptar
                </button>
            </div>
        </form>
    </div>
</div>