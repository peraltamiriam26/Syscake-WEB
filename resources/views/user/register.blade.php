@extends('layouts.app')
@section("content")
<div class="card  w-150">
  <div class="card-body flex items-center">
    <!-- Flecha y titulo -->
    <div class="grid grid-flow-col w-120">
      <div class="w-40 me-2">
        <a href="{{ url('/') }}" class="link link-primary no-underline">
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 21 21">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M7.499 6.497L3.5 10.499l4 4.001m9-4h-13" stroke-width="1" />
          </svg>
        </a>
      </div>
      <div class="w-60 justify-items-left">
        <h5 class="card-title">Registro</h5>
      </div>
    </div>
    <!-- Comienza formulario -->
    <form method="POST" action="{{ route('validate-register') }}">
      @csrf
      <div class="w-120">
        <div class="grid grid-flow-row">
          <div class="grid grid-flow-col justify-items-left">
            <div class="me-2">
              <label class="label-text">Nombre</label>
              <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" class="input @error('nombre') is-invalid @enderror"  id="nombreUsuario" autofocus/>
              @error('nombre')
                <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
              @enderror
            </div>
            <div>
              <label class="label-text">Apellido</label>
              <input type="text" name="apellido" placeholder="Apelido" value="{{ old('apellido') }}" class="input @error('apellido') is-invalid @enderror"  id="apellidoUsuario"/>
              @error('apellido')
                <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="grid grid-flow-col pt-2">
          <div class="grid grid-flow-col justify-items-left">
            <div>
              <label>Tipo de usuario</label>
              <div class="flex items-center">
                <input type="radio" name="tipoUsuario" value="lector" checked />
                <label for="lector" class="ms-2 me-3">Lector</label>
                <input type="radio" name="tipoUsuario" value="escritor"/>
                <label for="escritor" class="ms-2 me-3">Escritor</label>
              </div>
            </div>
          </div>  
        </div>
<!-- Correo -->
        <div class="grid grid-flow-col pt-2">
          <div class="grid grid-flow-col justify-items-left">
            <div>
              <label class="label-text">Correo electrónico</label>
              <input id="email" name="email" type="text" placeholder="correo@mail.com"  value="{{ old('email') }}" class="w-60 input @error('email') is-invalid @enderror" id="emailUsuario" />
              @error('email')
                <div class="alert alert-soft alert-error mt-2 w-80" role="alert">{{ $message }}</div>
              @enderror
            </div>
          </div>  
        </div>


        <div class="grid grid-flow-col pt-2">
          <div class="grid grid-flow-col justify-items-left ">
            <div class="me-2">
              <label class="label-text">Contraseña</label>
              <input id="password" name="password" type="password" class="input @error('password') is-invalid @enderror" placeholder="Ingrese una contraseña" value="{{ old('password') }}"  />
            </div>
          </div>
          <div>
            <label class="label-text">Repetir la contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="input @error('password') is-invalid @enderror" placeholder="Ingrese una contraseña" value="{{ old('password_confirmation') }}" />
          </div>
        </div>

        @error('password')
          <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
        @enderror
      </div>
      <div class="grid justify-items-center pt-2">
        <input class="btn btn-primary grid grid-flow-col w-40 justify-items-center items-center-safe rounded-full" type="submit" value="Registrarse">
      </div>
    </form>
  </div>
</div>


@stop