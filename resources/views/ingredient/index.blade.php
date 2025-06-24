@extends('layouts.app')
@section("content")
<div class="card">
    <div class="p-4 grid grid-cols-12 gap-12">
        <div class="card-body col-span-12">
            <!-- TITULO -->
            <div class="col-span-12">
                <h5 class="card-title float-left">Ingredientes</h5>
                <a class="float-right btn btn-success" href="{{ route('create-ingredient') }}" title="Crear comida del día"> <span class="icon-[tabler--plus] size-5"></span> Nuevo  </a>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach  ($ingredients as $ingredient)
                            <tr>
                                <td>{{ $ingredient->nombre }}</td>
                                <td>
                                    <a class="btn btn-circle btn-text btn-sm" aria-label="Action button" href="{{route('edit-ingredient', ['id' => $ingredient->id])}}">
                                        <span class="icon-[tabler--pencil] size-5 bg-info"></span>
                                    </a>
                                    <a id="btnDelete"  aria-label="Action button" onclick="alertDelete('delete-ingredient?id={{$ingredient->id}}', '¿Desea eliminar el ingrediente {{$ingredient->nombre}}?');" class="btn btn-circle btn-text btn-sm" href="#">
                                        <span class="icon-[tabler--trash] size-5 bg-error"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Paginación -->
                <div class="mt-4">
                    {{ $ingredients->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@stop