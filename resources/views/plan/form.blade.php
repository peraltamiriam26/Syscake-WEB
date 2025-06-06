@extends('layouts.app')
@section("content")
<div class="card">
    <div class="card-body flex items-center">
        <!-- TITULO -->
        <div class="grid grid-flow-col w-120">
            <div class="grid grid-flow-col w-120">
                <div class="w-60 justify-items-leftñ">
                    <h5 class="card-title">Crear Plan</h5>
                </div>
            </div>
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
                        <input type="text" class="input max-w-sm" placeholder="Seleccione la fecha de su plan" id="flatpickr-date" />
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
                        <select class="select-recipes" name="recipes[]" multiple="multiple">
                        </select>
                       <ul class="list-inside list-disc marker:text-purple-500">
                            
                            <li class="mb-2">Desayuno </li>
                                    
                          
                            
                            <li class="mb-2">Almuerzo</li>
                            <li class="mb-2">Merienda</li>
                            <li class="mb-2">Cena</li>
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

@stop