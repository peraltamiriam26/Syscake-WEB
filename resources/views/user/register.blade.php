@extends('layouts.app')
@section("content")
<div class="card  w-100">
  <form method="POST" action="{{ route('validate-register') }}">
    @csrf
  <div class="card-body flex items-center">
    <h5 class="card-title mb-2.5">Registro</h5>
      <div class="w-90">
        <label class="label-text" for="defaultInput">Nombre</label>
        <input type="text" name="nombre" placeholder="Nombre" class="input" id="nombreUsuario" autofocus required/>
        <label class="label-text" for="defaultInput">Apellido</label>
        <input type="text" name="apellido" placeholder="Apelido" class="input" id="apellidoUsuario" required/>
        <label class="label-text" for="defaultInput">Correo electrónico</label>
        <input type="email" name="correo" placeholder="correo@mail.com" class="input" id="correoUsuario" required/>
        <div  id="toggle-password-to-destroy" data-toggle-password-group>
          <!-- Current password -->
          <div class="mb-4 max-w-sm">
            <label class="label-text" for="toggle-password-destroy">Contraseña</label>
            <input type="password" class="input" name="password" placeholder="Ingrese una contraseña" required/>
            <label class="label-text" for="toggle-password-destroy">Repetir la contraseña</label>
            <input type="password" class="input" name="rpassword" placeholder="Ingrese la misma contraseña" required/>
          </div>
        </div>
      </div>
      <input class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe" type="submit" value="Registrarse">
      <a href="{{ url('/') }}"  class="link link-primary no-underline">Volver</a>
    </div>
  </form>
</div>


@stop