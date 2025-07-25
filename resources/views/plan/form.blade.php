@extends('layouts.app')
@section("content")
<div class="card">
    <div class="p-4 grid grid-cols-12 gap-12">
        <div class="card-body col-span-12">
            <!-- TITULO -->
            <div class="col-span-12 pb-2">
                <h5 class="card-title float-left">Crear Plan</h5>
            </div>
            <!-- FORMULARIO -->
            <form method="POST" action="{{ route('store-plan') }}">
            @csrf
                <div class="grid grid-flow-row">
                    <div class="grid grid-flow-col justify-items-left">
                        <div class="me-2">
                            @if (isset($plan->id))
                                <input type="text" name="id" value="{{ old('id', $plan->id) }}" class="input"  id="id" hidden/>
                            @endif
                            <input type="text" name="fecha" class="input" placeholder="Seleccione la fecha de su plan" id="flatpickr-date" value="{{old('fecha', $plan->fecha)}}"/>
                        @error('nombre')
                            <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
                        @enderror
                        </div>
                    </div>
                </div>
                <div class="grid grid-flow-row pt-2">
                    <h4>Seleccione las recetas</h4>
                    <div class="grid grid-flow-col justify-items-left">
                        <div class="me-2">
                           <ul class="list-inside list-disc marker:text-purple-500">                            
                                <li class="mb-2">Desayuno <br>
                                    <select class="select-recipes-breakfast select" name="recipesBreakfast[]" multiple="multiple"></select>
                                </li>
                                <li class="mb-2">Almuerzo <br>
                                    <select class="select-recipes-lunch select" name="recipesLunch[]" multiple="multiple"></select>
                                </li>
                                <li class="mb-2">Merienda <br> 
                                    <select class="select-recipes-snack select" name="recipesSnak[]" multiple="multiple"></select>
                                </li>
                                <li class="mb-2">Cena <br> 
                                    <select class="select-recipes-dinner select" name="recipesDinner[]" multiple="multiple"></select>
                                </li>
                            </ul>
                        @error('nombre')
                            <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
                        @enderror
                        </div>
                    </div>
                </div>
                <div class="grid grid-flow-col pt-2">
                    <div class="grid grid-flow-col justify-items-center">
                    <a type="button" class="btn btn-primary btn-outline justify-items-left items-left-safe rounded-full w-50" href="{{ route('index-plan') }}">Cancelar</a>  
                    </div>
                    <div class="grid grid-flow-col justify-items-center">
                    <button type="submit" class="btn btn-primary justify-items-right items-right-safe rounded-full w-50">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>

@stop