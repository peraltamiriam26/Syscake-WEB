@extends('layouts.app')
@section("content")
<div class="card">
    <div class="p-4 grid grid-cols-12 gap-12">
        <div class="card-body col-span-12">
            <!-- TITULO -->
            <div class="col-span-12">
                    <h5 class="card-title float-left">Tipo de recetas</h5>
                    <a class="float-right btn btn-success" href="{{ route('create-type-recipe') }}" title="Crear comida del día"> <span class="icon-[tabler--plus] size-5"></span> Nuevo  </a>
            </div>
            @livewire('type-recipe-table')
        </div>
    </div>
</div>
@stop