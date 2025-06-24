<div class="col-span-12">
    <div class="mb-4">
        <input type="text"
               wire:model.debounce.300ms="search"
               placeholder="Buscar tipo de receta..."
               class="input input-bordered w-full max-w-sm" />
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($typesRecipes as $index => $typeRecipe)
                <tr>
                    <td>{{ $typeRecipe->nombre }}</td>
                    <td>
                        <a class="btn btn-circle btn-text btn-sm" aria-label="Action button" href="{{route('edit-type-recipe', ['id' => $typeRecipe->id])}}">
                            <span class="icon-[tabler--pencil] size-5 bg-info"></span>
                        </a>
                        <a id="btnDelete"  aria-label="Action button" onclick="alertDelete('delete-type-recipe/{{$typeRecipe->id}}', '¿Desea eliminar el ingrediente {{$typeRecipe->descripcion}}?');" class="btn btn-circle btn-text btn-sm" href="#">
                            <span class="icon-[tabler--trash] size-5 bg-error"></span>
                        </a>
                    </td>
                </tr>
                @empty
            <tr>
                <td colspan="2" class="text-center text-gray-500 py-4">
                    No se encontraron resultados para “{{ $search }}”
                </td>
            </tr>
        @endforelse
    
        </tbody>
    </table>
    <!-- Paginación -->
    <div class="mt-4">
        {{ $typesRecipes->links() }}
    </div>

</div>