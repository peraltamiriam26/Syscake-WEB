@extends('layouts.app')
@section("content")
<div class="card">
    <div class="card-body flex items-center">
        <!-- TITULO -->
        <div class="grid grid-flow-col w-120">
            <div class="grid grid-flow-col w-120">
                <div class="w-60 justify-items-leftñ">
                    <h5 class="card-title">Crear Ingrediente</h5>
                </div>
            </div>
        </div>
        <!-- FORMULARIO -->
        <form method="POST" action="{{ route('store-ingredient') }}">
        @csrf
            <div class="grid grid-flow-row">
                <div class="grid grid-flow-col justify-items-left">
                    <div class="me-2">
                    <label class="label-text">Nombre</label>
                    <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" class="input @error('nombre') is-invalid @enderror"  id="nombreUsuario" autofocus/>
                    @error('nombre')
                        <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col pt-2">
                <div class="grid grid-flow-col justify-items-center">
                <a type="button" class="btn btn-primary btn-outline justify-items-left items-left-safe rounded-full w-50" href="{{'home'}}">Cancelar</a>  
                </div>
                <div class="grid grid-flow-col justify-items-center">
                <button type="submit" class="btn btn-primary justify-items-right items-right-safe rounded-full w-50">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop