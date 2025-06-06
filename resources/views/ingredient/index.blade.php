@extends('layouts.app')
@section("content")
<div class="card">
    <div class="card-body">
        <!-- TITULO -->
        <div class="grid grid-flow-col w-120">
            <div class="grid grid-flow-col w-120">
                <div class="w-60 justify-items-leftñ">
                    <h5 class="card-title">Ingredientes</h5>
                </div>
            </div>
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
@stop