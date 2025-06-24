<?php
  use Illuminate\Support\Facades\Auth;
?>
<div class="col-span-12">
    <div class="mb-4">
        <input type="text"
               wire:model.debounce.300ms="search"
               placeholder="Buscar tipo de comida..."
               class="input input-bordered w-full max-w-sm" />
    </div>
    <table class="table overflow-auto table-fixed">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Autor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recipes as $index => $recipe)
                <tr>
                    <td class="break-normal whitespace-normal"> {{ $recipe->nombre }} </td>
                    <td> {{ $recipe->tipoReceta->nombre ?? 'N/A' }} {{-- Accede a la descripción del tipo de receta --}}</td>
                    @if ($recipe->es_anonimo)
                        <td> 
                            Anónimo
                        </td>
                    @else
                        <td class="break-normal whitespace-normal">
                            {{ $recipe->user->nombre }} {{$recipe->user->apellido}}
                        </td>
                    @endif
                    <td>
                        <a class="btn btn-circle btn-text btn-sm" aria-label="Action button" href="{{ route('show-recipe', $recipe->id) }}">
                            <span class="icon-[tabler--eye] size-5 bg-primary"></span>
                        </a>
                        @can('update-receta', $recipe)
                            <a class="btn btn-circle btn-text btn-sm" aria-label="Action button" href="{{ route('recetas.edit', $recipe->id) }}">
                                <span class="icon-[tabler--pencil] size-5 bg-info"></span>
                            </a> 
                        @endcan
                        @can('delete-receta', $recipe)
                            <a id="btnDelete"  aria-label="Action button" onclick="alertDelete('delete-recipe?id={{$recipe->id}}', '¿Desea eliminar la receta {{$recipe->nombre}}?');" class="btn btn-circle btn-text btn-sm" href="#">
                                <span class="icon-[tabler--trash] size-5 bg-error"></span>
                            </a>                            
                        @endcan
                        <a class="btn btn-circle btn-text btn-sm" href="{{ route('recipe.descargar', $recipe->id) }}" >
                            <span class="icon-[tabler--file-download] size-5"></span>
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
        {{ $recipes->links() }}
    </div>

</div>