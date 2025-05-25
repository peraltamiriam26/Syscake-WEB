@extends('layouts.app')
@section("content")
<div class="card  w-150">
  <div class="card-body flex items-center">
    <!-- Flecha y titulo -->
    <div class="grid grid-flow-col w-120">
      <div class="w-60 justify-items-left">
        <h5 class="card-title">Modificar datos</h5>
      </div>
    </div>
    <!-- Comienza formulario -->
    <form method="POST" action="{{ route('update-user') }}">
      @csrf
      <div class="w-120">
        <div class="grid grid-flow-row">
          <div class="grid grid-flow-col justify-items-left">
            <div class="me-2">
              <label class="label-text">Nombre</label>
              <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre', $user->nombre) }}" class="input @error('nombre') is-invalid @enderror"  id="nombreUsuario" autofocus/>
              @error('nombre')
                <div class="alert alert-soft alert-error mt-2" role="alert">{{ $message }}</div>
              @enderror
            </div>
            <div>
              <label class="label-text">Apellido</label>
              <input type="text" name="apellido" placeholder="Apelido" value="{{ old('apellido', $user->apellido) }}" class="input @error('apellido') is-invalid @enderror"  id="apellidoUsuario"/>
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
                <input type="radio" name="tipoUsuario" value="lector" {{ !empty($reader) ? 'checked' : '' }} />
                <label for="lector" class="ms-2 me-3">Lector</label>
                
                <input type="radio" name="tipoUsuario" value="escritor"  {{ !empty($writer) ? 'checked' : '' }}/>
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
              <input id="email" name="email" type="text" placeholder="correo@mail.com"  value="{{ old('email', $user->email)}}" class="w-60 input @error('email') is-invalid @enderror" id="emailUsuario" />
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
      <div class="grid grid-flow-col pt-2">
        <div class="grid grid-flow-col justify-items-center">
          <a type="button" class="btn btn-primary btn-outline justify-items-left items-left-safe rounded-full w-50" href="{{'home'}}">Cancelar</a>  
        </div>
        <div class="grid grid-flow-col justify-items-center">
          <button type="submit" class="btn btn-primary justify-items-right items-right-safe rounded-full w-50">Guardar</button>
        </div>
      </div>
    </form>
    <div class="grid grid-flow-col pt-2 justify-items-center">
      <a id="linkCloseAccount"  onclick="alertDelete();" class="link link-primary" href="#">Dar de baja</a>
    </div>
  </div>
</div>
@stop