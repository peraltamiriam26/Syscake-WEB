<?php
use App\Models\Receta;
use Illuminate\Support\Facades\Log;

?>
<div class="card">
    <div class="p-4 grid grid-cols-12 gap-12">
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
                                   <td class="{{strtolower($days[$dayIndex]) === strtolower($nameToday) ? 'bg-violet-200' : '' }}">
                                       @if (!empty($plansOrder[$dayIndex][$typeIndex])) 
                                           @foreach ($plansOrder[$dayIndex][$typeIndex] as $plan)
                                               <button class="btn btn-soft btn-primary btn-xs" onclick="openModal('view-modal/{{$plan->id}}/{{$plan->receta_id}}', 'GET');" value="{{$plan->receta_id}}"  aria-haspopup="dialog" aria-expanded="false" aria-controls="form-modal" data-overlay="#form-modal"> 
                                                   {{ Receta::findModel($plan->receta_id)->nombre }}
                                               </button> <br>
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
           <button wire:click="prevWeek" class="btn btn-primary float-left" name="prevWeekBtn">Semana anterior</button>
           <button wire:click="nextWeek" class="btn btn-primary float-right" name="nextWeekBtn">Semana siguiente</button>
       </div>
    </div>
</div>
<h1 class="text-3xl font-bold col-span-12 pt-2 pb-2">Recetas del día</h1>
<div class="card p-4 grid grid-cols-12 gap-12">
    <div class="col-span-12">
        <div class="carousel overflow-hidden relative" id="multi-slide" data-carousel='{ "loadingClasses": "opacity-0", "slidesQty": { "xs": 1, "lg": 3 } }' class="relative">
            <div class="carousel-body flex transition-transform duration-500 ease-in-out">
                @foreach ($recipes as $indexRecipe => $recipe)
                    <div class="carousel-slide shrink-0 w-50 p-3">
                        <div class="card sm:max-w-sm">
                            <figure><img src="https://cdn.flyonui.com/fy-assets/components/card/image-9.png" alt="Watch" /></figure>
                            <div class="card-body items-center text-center">
                                <h5 class="card-title"> {{$recipe->nombre}} </h5>
                                    <!-- Cambiar a un link cuando este el viewRecipe -->
                                <button class="btn btn-primary" value="{{$recipe->id}}" >Ver</button>
                            </div>
                        </div>
                    </div>            
                @endforeach
            </div>
            <!-- Botones de navegación -->
            <button class="carousel-prev absolute left-0 top-1/2 -translate-y-1/2 z-10">‹</button>
            <button class="carousel-next absolute right-0 top-1/2 -translate-y-1/2 z-10">›</button>

            <!-- Indicadores -->
            <div class="carousel-pagination flex justify-center mt-4">
                <button class="carousel-dot w-3 h-3 rounded-full mx-1 bg-gray-400"></button>
                <button class="carousel-dot w-3 h-3 rounded-full mx-1 bg-gray-400"></button>
            </div>
        </div>
    </div>
</div>
<br>