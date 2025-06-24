@extends('layouts.app')
@section("content")
<br>
<div class="card">
    <div class="p-4 grid grid-cols-12 gap-12">
        <div class="card-body col-span-12">
            <!-- TITULO -->
            <div class="col-span-12">
                <h5 class="card-title float-left">Recetas</h5>
                @can('es-escritor')
                    <a class="float-right btn btn-success" href="{{ route('recetas.create') }}" title="Crear receta"> <span class="icon-[tabler--plus] size-5"></span> Nueva </a>
                @endcan
            </div>
            @livewire('recipes-table')
        </div>
    </div>
</div>
@stop