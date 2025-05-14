@extends('layouts.app')
@section("content")
<div class="card  w-100">
  <div class="card-body flex items-center">
    <h5 class="card-title mb-2.5">Registro</h5>
    <div class="w-90">
      <label class="label-text" for="defaultInput">Correo electrónico</label>
      <input type="text" placeholder="correo@mail.com" class="input" id="defaultInput" />
      <div  id="toggle-password-to-destroy" data-toggle-password-group>
        <!-- Current password -->
        <div class="mb-4 max-w-sm">
          <label class="label-text" for="toggle-password-destroy">Contraseña</label>
          <input type="password" class="input" placeholder="Ingrese una contraseña" />
        </div>
      </div>
    </div>
    
    <button class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe">Ingresar</button>
  </div>
  <div class="text-center p-4">
    <p class="text-base-content/50">¿Todavía no tenes cuenta? <a href="#"  class="link link-primary no-underline">Registrate aquí</a></p> 
  </div>
</div>


@stop