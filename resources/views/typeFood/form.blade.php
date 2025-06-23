@extends('layouts.app')
@section("content")
<div class="card max-w-md w-full shadow-md bg-base-100 p-6">
    <div class="col-span-12 pb-2">
        <h5 class="card-title float-left">Crear comida del día</h5>
    </div>
    <form method="POST" action="{{ route('store-type-food') }}" class="space-y-4">
        @csrf
        <div>
            @if (isset($typeFood->id))
                <input type="text" name="id" value="{{ old('id', $typeFood->id) }}" class="input"  id="id" hidden/>
            @endif
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion"  value="{{ old('descripcion', $typeFood->descripcion) }}" id="descripcion" class="input input-bordered w-full" placeholder="Ej: Desayuno" required>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('index-type-food') }}" class="btn btn-outline">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary inline-flex items-center gap-2">
                Guardar
            </button>
        </div>
    </form>
</div>
@stop