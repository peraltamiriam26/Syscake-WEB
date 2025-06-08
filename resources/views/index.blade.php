@extends('layouts.app')
@section("content")
<?php
use App\Models\Receta;
?>
<div class="grid grid-cols-12 gap-12">
    <h1 class="text-3xl font-bold col-span-12">Bienvenido {{ auth()->user()->nombre }}</h1>
    <div class="col-span-12">
        <div class="card">
           <div class="border-base-content/25 w-full overflow-x-auto">
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

                                                <span class="badge badge-soft badge-primary" value="{{$plan->receta_id}}">{{ Receta::findModel($plan->receta_id)->nombre }}</span> <br>
                                                
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
    </div>
</div>
    
@stop