@extends('layouts.app')
@section('content')
<div class="card max-w-xl overflow-auto">
    <div class="p-4 grid grid-cols-12 gap-12">
        <div class="card-body col-span-12">
            <!-- TITULO -->
            <div class="col-span-12 pb-2">
                <a href="{{ route('recipe.index') }}" class="btn btn-circle btn-text btn-sm float-left">
                    <span class="icon-[tabler--arrow-narrow-left] size-8"></span>
                </a>
                <a href="{{ route('recipe.descargar', $recipe->id) }}" class="btn btn-circle btn-text btn-sm float-right">
                    <span class="icon-[tabler--file-download] size-8"></span>
                </a>
                @can('delete-receta', $recipe)
                <a id="btnDelete" class="btn btn-circle btn-text btn-sm float-right" aria-label="Action button" onclick="alertDelete('delete-recipe?id={{$recipe->id}}', '¿Desea eliminar el ingrediente {{$recipe->nombre}}?');"  href="#">
                    <span class="icon-[tabler--trash] size-8 bg-error"></span>
                </a>
                @endcan
                @can('update-receta', $recipe)
                <a class="btn btn-circle btn-text btn-sm float-right" aria-label="Action button" href="{{ route('recetas.edit', $recipe->id) }}">
                    <span class="icon-[tabler--pencil] size-8 bg-info"></span>
                </a>
                @endcan
            </div>
            <h5 class="card-title float-left">Receta: {{ $recipe->nombre }}</h5>
            @if (isset($typeRecipe->nombre))
                <span class="badge badge-info badge-sm">{{ $typeRecipe->nombre }}</span>                
            @endif
            <div class="col-span-12 pb-2">
                <h6 class="float-left font-bold">Ingredientes</h6><br>
                @if ($ingredients->isNotEmpty())
                    <div>
                        <ul class="list-inside list-disc marker:text-purple-500 columns-3">
                            @foreach ($ingredients as $ingredient_has_recipe)
                                @php
                                    $ingredient = $ingredient_has_recipe->ingrediente()->first();
                                    $unity = $ingredient_has_recipe->tipoUnidad()->first();
                                @endphp
                                <li class="mb-2"> {{$ingredient_has_recipe->cantidad}} {{strtolower($unity->nombre)}} de {{$ingredient->nombre}} </li>
                            
                            @endforeach            
                        </ul>
                    </div>                    
                @else 
                    <div class="max-h-40  px-5 pb-4">
                        <p class="text-base-content/80 font-normal"><i>No hay ingredientes registrados.</i></p>
                    </div>
                @endif
                <h6 class="float-left mt-2 font-bold"> Pasos </h6>
                @if ($steps->isNotEmpty())
                    <div class="accordion divide-neutral/20 divide-y">
                        @foreach ($steps as $step)
                        <div class="accordion-item " id="delivery-arrow-{{$step->id}}">
                            <!-- AGREGAR LOS PASOS TRAÍDOS DE LA BASE DE DATOS -->
                            <button class="accordion-toggle inline-flex items-center gap-x-4 text-start" aria-controls="delivery-arrow-collapse-{{$step->id}}" aria-expanded="false">
                                <span class="icon-[tabler--chevron-right] accordion-item-active:rotate-90 size-5 shrink-0 transition-transform duration-300 rtl:rotate-180" ></span>
                                Paso {{$step->orden}}
                            </button>
                            <div id="delivery-arrow-collapse-{{$step->id}}" class="accordion-content hidden max-h-40 overflow-auto transition-[height] duration-300" aria-labelledby="delivery-arrow-{{$step->id}}" role="region">
                                <div class="max-h-40  px-5 pb-4">
                                    <p class="text-base-content/80 font-normal">
                                        {{ $step->descripcion }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                <br>
                    <div class="max-h-40  px-5 pb-4">
                        <p class="text-base-content/80 font-normal"><i>No hay pasos registrados</i></p>
                    </div>                    
                @endif
            </div>
        </div>
    </div>
</div>
@endsection