@extends('layouts.app')
@section("content")
<!-- <div class="card  w-250">
  <div class="card-body flex items-center"> -->
    <div>
      <!-- <form method="POST" action=""> -->
      <!-- <form>
        @csrf -->
        <h1>CREAR RECETA</h1>
        <!-- <form method="POST" action="{{ route('validate-register') }}"> -->
          <!-- Nombre y tipo de receta -->
        <div class="card card-body flex items-center">
          <div class="grid grid-flow-col justify-items-left">
            <div class="me-2">
              <label for="">Nombre</label>
              <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" class="input @error('nombre') is-invalid @enderror"  id="nombreReceta" autofocus/>
              @error('nombre')
                <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
              @enderror
            </div>
            <div class="grid grid-flow-row">
              <label for="">Tipo de receta</label>
              <select name="receta" id="tipoReceta">
                <option value="dulce">Dulce</option>
                <option value="salado">Salado</option>
                <option value="picante">Picante</option>
                <option value="agridulce">Agridulce</option>
              </select>
            </div>
            <div>
              <input class="form-check-input" type="checkbox" value="" id="anonimo">
              <label class="form-check-label" for="flexCheckDefault">
                Anonimo
              </label>
            </div>
          </div>
        </div>
        <div class="grid grid-flow-col justify-items-left">
          <div class="card card-body flex items-center">
            <div class="grid grid-flow-col">
              <h1>INGREDIENTES</h1>
              <button type="button" class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe rounded-full" aria-haspopup="dialog" aria-expanded="false" aria-controls="middle-center-modal" data-overlay="#ingredient-modal">Agregar</button>
              <div id="ingredient-modal" class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 modal-middle hidden" role="dialog" tabindex="-1">
                <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title">Agregar Ingrediente</h3>
                      <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close" data-overlay="#ingredient-modal">
                        <span class="icon-[tabler--x] size-4"></span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="grid grid-flow-row">
                        <div class="grid grid-flow-col justify-items-left">
                          <div class="me-2">
                            <!-- <div class="select-floating max-w-sm"> -->
                              <label class="label-text">Ingrediente</label>
                              <select class="select select-xs" id="ingredientSelecter" aria-label="floating label">
                                @foreach  ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->nombre }}</option>
                                @endforeach
                              </select>
                              <!-- <label class="select-floating-label" for="selectFloatingExtraSmall">Pick your favorite Movie</label> -->
                            <!-- </div> -->
                          </div>
                          <div>
                              <label class="label-text">Tipo Unidad</label>
                              <select class="select select-xs" id="tipoUnidadSelecter" aria-label="floating label">
                                @foreach  ($tipoUnidads as $tipoUnidad)
                                <option value="{{ $tipoUnidad->id }}">{{ $tipoUnidad->nombre }}</option>
                                @endforeach
                              </select>
                          </div>
                          <div>
                            <label class="label-text">Cantidad</label>
                            <input type="number" class="grow" min="1" name="cantidad" placeholder="1, 2, 3, ..." id="cantidad"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-soft btn-secondary" data-overlay="#ingredient-modal">Cancelar</button>
                      <button id="agregarIngrediente" class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe rounded-full" data-overlay="#ingredient-modal">Agregar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
            <div>
              <table class="border-collapse border border-gray-400 ...">
                <thead>
                  <tr>
                    <th class="border border-gray-300">Ingrediente</th>
                    <th class="border border-gray-300">Unidad</th>
                    <th class="border border-gray-300">Cantidad</th>
                    <th class="border border-gray-300"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              </div>
          </div>
          <div class="card card-body flex items-center">
            <div class="grid grid-flow-col">
              <h1>PASOS</h1>
              <button type="button" class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe rounded-full" aria-haspopup="dialog" aria-expanded="false" aria-controls="middle-center-modal" data-overlay="#paso-modal">Agregar</button>
              <div id="paso-modal" class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 modal-middle hidden" role="dialog" tabindex="-1">
                <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title">Agregar Paso</h3>
                      <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close" data-overlay="#paso-modal">
                        <span class="icon-[tabler--x] size-4"></span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="grid grid-flow-row">
                        <div class="grid grid-flow-col justify-items-left">
                          <div class="me-2">
                            <label class="label-text">Ingrediente</label>
                            <input type="text" name="ing" placeholder="Nombre Ingrediente" id="ingName" autofocus/>
                          </div>
                          <div>
                            <label class="label-text">Unidad</label>
                            <input type="text" name="unidad" placeholder="Tipo Unidad" id="tipoUnidad"/>
                          </div>
                          <div>
                            <label class="label-text">Cantidad</label>
                            <input type="text" name="cant" placeholder="Cantidad" id="cantidad"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-soft btn-secondary" data-overlay="#paso-modal">Cancelar</button>
                      <button id="agregarPasos" class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe rounded-full" data-overlay="#paso-modal">Agregar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- </form> -->
    </div>
  <!-- </div>
</div> -->
<script src="{{ asset('js/recipe.js') }}"></script>
@stop