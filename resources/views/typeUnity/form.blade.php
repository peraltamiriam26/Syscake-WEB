@extends('layouts.app')
@section("content")
<div class="card max-w-md w-full shadow-md bg-base-100 p-6">
    <div class="col-span-12 pb-2">
        <h5 class="card-title float-left">Crear tipo de unidad</h5>
    </div>
    <form method="POST" action="{{ route('store-type-unity') }}" class="space-y-4">
        @csrf
        <div>
            @if (isset($typeUnity->id))
                <input type="text" name="id" value="{{ old('id', $typeUnity->id) }}" class="input"  id="id" hidden/>
            @endif
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre"  value="{{ old('nombre', $typeUnity->nombre) }}" id="nombre" class="input input-bordered w-full" placeholder="Ej: Kilos" required>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('index-type-unity') }}" class="btn btn-outline">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary inline-flex items-center gap-2">
                Guardar
            </button>
        </div>
    </form>
</div>
@stop