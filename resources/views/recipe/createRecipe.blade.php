@extends('layouts.app')
@section("content")
<div class="card  w-250">
  <div class="card-body flex items-center">
    <h1>CREAR RECETA</h1>
    <!-- <form method="POST" action="{{ route('validate-register') }}"> -->
    <form method="POST" action="">
      @csrf
      <!-- Nombre y tipo de receta -->
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
            <!-- <option value="volvo">Volvo</option> -->
            <option value="desayuno">Desayuno</option>
            <option value="almuerzo">Almuerzo</option>
            <option value="merienda">Merienda</option>
            <option value="cena">Cena</option>
          </select>
        </div>
      </div>
    </form>
  </div>
</div>
@stop