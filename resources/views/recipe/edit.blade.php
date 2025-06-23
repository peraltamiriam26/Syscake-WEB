@extends('layouts.app') {{-- O tu layout principal --}}

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modificar Receta</h1>

        {{-- Carga el componente Livewire RecetaForm, pasándole el ID de la receta --}}
        {{-- Asegúrate que el nombre del componente coincida con el nombre de tu archivo Livewire --}}
        <livewire:receta-form :recetaId="$receta->id" />
    </div>
@endsection