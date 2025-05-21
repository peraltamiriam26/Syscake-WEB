@extends('layouts.app')
@section("content")
<div class="card  w-150">
  <form method="POST" action="{{ route('validate-register') }}">
    @csrf
    <div class="card-body flex items-center">
      <div class="flex items-center" style="width: 100%; justify-content: center;">
        <div style="position: absolute; left: 0;">
          <a href="{{ url('/') }}" class="link link-primary no-underline">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 21 21">
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M7.499 6.497L3.5 10.499l4 4.001m9-4h-13" stroke-width="1" />
            </svg>
          </a>
        </div>
        <h5 class="card-title">Registro</h5>
      </div>
      <div class="w-145">

        <div class="grid grid-flow-row">
          <div class="grid grid-flow-col justify-items-center">
            <label class="label-text">Nombre</label>
            <label class="label-text">Apellido</label>
          </div>
          <div class="grid grid-flow-col">
            <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" class="input @error('nombre') is-invalid @enderror"  id="nombreUsuario" autofocus/>
            <input type="text" name="apellido" placeholder="Apelido" value="{{ old('apellido') }}" class="input @error('apellido') is-invalid @enderror"  id="apellidoUsuario"/>
          </div>
        </div>

        <div class="grid grid-flow-col justify-items-center">
          @error('nombre')
            <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
          @enderror
          @error('apellido')
            <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
          @enderror
        </div>
        
        <div class="grid grid-flow-col">
          <div class="col items-center justify-items-center">
            <label>Tipo de usuario</label>
            <div class="flex items-center">
              <input type="radio" name="tipoUsuario" value="lector" checked />
              <label for="lector" style="margin-left: 5px; margin-right: 5px;">Lector</label>
              <input type="radio" name="tipoUsuario" value="escritor"/>
              <label for="escritor" style="margin-left: 5px; margin-right; 5px;">Escritor</label>
            </div>
          </div>
  
          <div class="col items-center justify-items-center">
  
            <label class="label-text">Correo electrónico</label>
            <input id="email" name="email" type="text" placeholder="correo@mail.com"  value="{{ old('email') }}" class="input @error('email') is-invalid @enderror" id="emailUsuario" />
            @error('email')
              <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
            @enderror
  
          </div>
        
        </div>

        <div class="grid grid-flow-row">
          <div class="grid grid-flow-col justify-items-center ">
            <label class="label-text">Contraseña</label>
            <label class="label-text">Repetir la contraseña</label>
          </div>
          <div class="grid grid-flow-col">
            <input id="password" name="password" type="password" class="input @error('password') is-invalid @enderror" placeholder="Ingrese una contraseña" value="{{ old('password') }}"  />
            <input id="password_confirmation" name="password_confirmation" type="password" class="input @error('password') is-invalid @enderror" placeholder="Ingrese una contraseña" value="{{ old('password_confirmation') }}" />
          </div>
        </div>

        @error('password')
          <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
        @enderror
      </div>
      <input class="btn btn-primary grid grid-flow-col justify-items-center items-center-safe" type="submit" value="Registrarse">
    </div>
  </form>
</div>


@stop