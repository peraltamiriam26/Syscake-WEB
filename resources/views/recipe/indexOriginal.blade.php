<?php
use Illuminate\Support\Facades\Log;
?>
@extends('layouts.app') {{-- O tu layout principal --}}

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Listado de Recetas</h1>
        {{-- Botón para crear receta, visible solo si el usuario tiene permiso --}}
        @can('create-receta')
            <a href="{{ route('recetas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Nueva Receta
            </a>
        @endcan
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @if ($recetas->isEmpty())
            <div class="p-6 text-center text-gray-600">
                <p>No hay recetas disponibles todavía.</p>
                @can('create-receta')
                    <p class="mt-2">¡Anímate a <a href="{{ route('recetas.create') }}" class="text-blue-500 hover:underline">crear la primera</a>!</p>
                @endcan
            </div>
        @else
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nombre de la Receta
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Pasos e Imágenes
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recetas as $receta)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $receta->nombre }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ $receta->tipoReceta->nombre ?? 'N/A' }} {{-- Accede a la descripción del tipo de receta --}}
                            </p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            @if ($receta->instrucciones->isEmpty())
                                <p class="text-gray-600">Sin pasos definidos.</p>
                            @else
                                <ul class="list-disc list-inside text-gray-900">
                                    @foreach ($receta->instrucciones as $instruccion)
                                        <li class="mb-2">
                                            <p>{{ $loop->iteration }}. {{ $instruccion->descripcion }}</p>
                                            @if ($instruccion->archivo)
                                                <div class="mt-1">
                                                    <img src="{{ Storage::url($instruccion->archivo->path) }}" alt="Imagen del Paso {{ $loop->iteration }}" class="w-24 h-24 object-cover rounded shadow-sm">
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex space-x-2">
                                {{-- Botón de Modificar (Editar) --}}
                                {{-- Asumiendo una ruta 'recetas.edit' con el ID de la receta --}}
                                <a href="{{ route('recetas.edit', $receta->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-xs">
                                    Modificar
                                </a>

                                {{-- Botón de Eliminar --}}
                                {{-- Usaremos un formulario para DELETE request, es más seguro --}}
                                <form action="{{ route('recetas.destroy', $receta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta receta? Esta acción es irreversible.');">
                                    @csrf
                                    @method('DELETE') {{-- Método HTTP para eliminación --}}
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="p-5">
                {{ $recetas->links() }} {{-- Esto generará los enlaces de paginación --}}
            </div>
        @endif
    </div>
</div>
@endsection