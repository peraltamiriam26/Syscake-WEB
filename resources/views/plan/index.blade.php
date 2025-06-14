@extends('layouts.app')
@section("content")
<div class="card">
    <div class="card-body">
        <!-- TITULO -->
        <div class="grid grid-flow-col w-120">
            <div class="grid grid-flow-col w-120">
                <div class="w-60 justify-items-leftñ">
                    <h5 class="card-title">Mi planificación</h5>
                </div>
            </div>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach  ($plans as $plan)
                        <tr>
                            <td>{{ $plan->fecha_formateada }}</td>
                            <td>
                                <a class="btn btn-circle btn-text btn-sm" aria-label="Action button" href="{{route('edit-plan', ['id' => $plan->id])}}">
                                    <span class="icon-[tabler--pencil] size-5 bg-info"></span>
                                </a>
                                <a id="btnDelete"  aria-label="Action button" onclick="alertDelete('delete-plan?id={{$plan->id}}', '¿Desea eliminar el plan del día {{$plan->fecha}}?');" class="btn btn-circle btn-text btn-sm" href="#">
                                    <span class="icon-[tabler--trash] size-5 bg-error"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Paginación -->
            <div class="mt-4">
                {{ $plans->links() }}
            </div>

        </div>
    </div>
</div>
@stop