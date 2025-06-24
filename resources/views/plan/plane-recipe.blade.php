<?php
use App\Models\Receta;
use App\Models\Plan;
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
                            @foreach ($days as $index => $day)
                                @php
                                    $dateCol = \Carbon\Carbon::parse($startWeek)->addDays($index)->toDateString();
                                    $plan = Plan::existPlan($dateCol);
                                @endphp
                                <th>
                                    {{ $day }}                                    
                                    @if ($plan != false)

                                        <a href="{{route('edit-plan', ['id' => $plan])}}" class="btn btn-circle btn-text btn-xs" title="Editar plan">
                                            <span class="icon-[tabler--refresh] size-4"></span>
                                        </a>
                                    @elseif (($dateCol == $todayDate))
                                        <a href="{{route('create-plan')}}"  class="btn btn-circle btn-text btn-xs" title="Crear plan">
                                            <span class="icon-[tabler--plus] size-4"></span>
                                        </a>
                                    @endif
                                </th>
                            @endforeach
                       </tr>
                   </thead>
                   <tbody>
                       @foreach ($typesFood as $typeIndex => $typeFood)
                           <tr>
                               <td class="bg-primary-content">{{ strtoupper($typeFood) }}</td>
                                @foreach (range(0, 6) as $dayIndex)
                                @php
                                    $dateCol = \Carbon\Carbon::parse($startWeek)->addDays($dayIndex)->toDateString();
                                @endphp
                                    <td class="{{($dateCol == $todayDate) ? 'bg-violet-200' : '' }} ">                                        
                                        @if (!empty($plansOrder[$dayIndex][$typeIndex]))
                                            @foreach ($plansOrder[$dayIndex][$typeIndex] as $plan)                                            
                                                @if (isset($plan->id))
                                                    <button class="btn btn-soft btn-primary btn-xs p-1" onclick="prueba('view-modal/{{$plan->id}}/{{$plan->receta_id}}', '{{$plan->id}}', '{{$plan->receta_id}}');" value="{{$plan->receta_id}}"> 
                                                        {{ Receta::findModel($plan->receta_id)->nombre }}
                                                    </button>                                                    
                                                @endif
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
                            <figure><img src="{{ asset('images/libroRecetas.png') }}" alt="{{$recipe->nombre}}"  class="w-50 h-36 object-cover" /></figure>
                            <div class="card-body items-center text-center">
                                <h5 class="card-title"> {{$recipe->nombre}} </h5>
                                    <!-- Cambiar a un link cuando este el viewRecipe -->
                                <a class="btn btn-primary" value="{{$recipe->id}}" href="{{ route('show-recipe', $recipe->id) }}" >Ver</a>
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

<!-- Botón oculto -->
<button id="trigger-modal" data-overlay="#form-modal" class="hidden"></button>
<!-- MODAL -->
 <div id="form-modal" class="overlay modal overlay-open:opacity-100 hidden overlay-open:duration-300 inset-0 z-50" role="dialog" tabindex="-1">
  <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
    <div id="modalContent" class="modal-content">
    </div>
  </div>
 </div>
 
<script>
    function prueba(url, id_plan, id_receta){        
        $.ajax({
            url: url, // Ruta en tu Laravel
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            data: {},
            success: function(response) {                 
                // $("#modalContent").html(response); // Inserta el formulario en el modal
                $("#form-modal").removeClass("hidden"); // Muestra el modal
                const modal = document.getElementById('form-modal');
               // Mostrar el modal (manualmente)
                $('#modalContent').html(response);
                

                document.getElementById("trigger-modal").click();

            },
            error: function(xhr, status, err) {                         
                Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "Ocurrió un error.",
                            showConfirmButton: false,
                            timer: 3000
                    });
            }
        });
        
    }
</script>