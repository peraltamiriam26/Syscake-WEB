@extends('layouts.app')
@section("content")
<!-- <div class="card  w-250">
  <div class="card-body flex items-center"> -->
    <div>
      <form method="POST" action="">
        @csrf
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
              <button class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe rounded-full">Agregar</button>
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
                  <tr>
                    <td class="border border-gray-300">Harina</td>
                    <td class="border border-gray-300">Gramos</td>
                    <td class="border border-gray-300">200</td>
                    <td class="border border-gray-300">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
	                      <path fill="currentColor" d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
                      </svg>
                    </td>
                  </tr>
                </tbody>
              </table>
              </div>
          </div>
          <div class="card card-body flex items-center">
            <div class="grid grid-flow-col">
              <h1>PASOS</h1>
              <button class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe rounded-full">Agregar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  <!-- </div>
</div> -->
@stop