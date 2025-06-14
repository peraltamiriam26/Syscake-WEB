@extends('layouts.app')
@section("content")
<?php
use App\Models\Receta;
?>

<div class=" ">
    <h1 class="text-3xl font-bold col-span-12">Bienvenido {{ auth()->user()->nombre }}</h1><br><br>
    <div class="card p-4 grid grid-cols-12 gap-12">
        <div class="col-span-12">
            <p>Semana del <b>{{$startWeek->format('d-m-Y')}}</b> al <b>{{$endWeek->format('d-m-Y')}}</b></p>
            <div class="border-base-content/25 w-full  rounded-lg overflow-x-auto border">
                <table class="table">
                    <thead>
                        <tr class="bg-primary-content">
                            <th></th>
                            @foreach ($days as $day)
                                <th>{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($typesFood as $typeIndex => $typeFood)
                            <tr>
                                <td class="bg-primary-content">{{ strtoupper($typeFood) }}</td>
                                @foreach (range(0, 6) as $dayIndex) 
                                    <td>
                                        @if (!empty($plansOrder[$dayIndex][$typeIndex])) 
                                            @foreach ($plansOrder[$dayIndex][$typeIndex] as $plan)
                                                <button class="btn btn-soft btn-primary btn-xs" onclick="openModal('edit-plan/{{$plan->id}}/{{$plan->receta_id}}', 'GET');" value="{{$plan->receta_id}}"  aria-haspopup="dialog" aria-expanded="false" aria-controls="form-modal" data-overlay="#form-modal"> {{ Receta::findModel($plan->receta_id)->nombre }}</button> <br>
                                            @endforeach
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>            
            </div> 
        </div>
        <div class="col-span-12">
            <button class="btn btn-primary float-left">Semana anterior</button>
            <button class="btn btn-primary float-right">Semana siguiente</button>
        </div>
    </div>
</div>
    
<!-- MODAL -->
 <div id="form-modal" class="overlay modal overlay-open:opacity-100 hidden overlay-open:duration-300" role="dialog" tabindex="-1">
  <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
    <div id="modalContent" class="modal-content">
    </div>
  </div>
 </div>

@stop