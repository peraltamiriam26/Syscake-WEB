<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-xl font-bold mb-4">Agregar Paso</h3>

        <form wire:submit.prevent="addPasoToRecipe"> {{-- Cambiado addIngredientToRecipe a addPasoToRecipe para mayor claridad --}}
            <div class="mb-4">
                <label for="paso" class="block text-gray-700 text-sm font-bold mb-2">Paso:</label>
                <textarea wire:model.defer="pasoDescripcion" name="paso" id="paso" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                @error('pasoDescripcion') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="imagen_paso" class="block text-gray-700 text-sm font-bold mb-2">Imagen del Paso (Opcional):</label>
                <input type="file" wire:model="imagenPaso" id="imagen_paso" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('imagenPaso') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                {{-- Muestra una vista previa de la imagen si se ha cargado --}}
                @if ($imagenPaso)
                    <img src="{{ $imagenPaso->temporaryUrl() }}" class="mt-2 w-32 h-32 object-cover rounded">
                @endif
            </div>
            <div class="flex justify-end mt-6">
                <button type="button" wire:click="closePasoModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2 focus:outline-none focus:shadow-outline">
                    Cancelar
                </button>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Aceptar
                </button>
            </div>
        </form>
    </div>
</div>