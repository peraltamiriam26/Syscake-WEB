@extends('layouts.app')
@section("content")
<form method="POST" action="{{ route('login') }}">
   @csrf
  <div class="card w-100 shadow-xl/20">
    <div class="card-body flex items-center">
      <h5 class="card-title mb-2.5">Iniciar Sesión</h5>
      <div class="w-90">
        <label class="label-text" for="defaultInput">Correo electrónico</label>
        <input id="email" name="email" type="text" placeholder="correo@mail.com"  value="{{ old('email') }}"class="input @error('email') is-invalid @enderror" id="defaultInput" />
        @error('email')
          <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
        @enderror
        <div  id="toggle-password-to-destroy" data-toggle-password-group>
          <!-- Current password -->
          <div class="mb-4 max-w-sm">
            <label class="label-text" for="toggle-password-destroy">Contraseña</label>
            <input id="password" name="password" type="password" class="input @error('password') is-invalid @enderror" placeholder="Ingrese una contraseña" />
            @error('password')
              <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
      
      <button type="submit" class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe">Ingresar</button>
    </div>
    <div class="text-center p-4">
      <p class="text-base-content/50">¿Todavía no tenes cuenta? <a href="#"  class="link link-primary no-underline">Registrate aquí</a></p> 
    </div>
  </div>
</form>

@stop