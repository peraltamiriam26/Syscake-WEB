<?php
  use Illuminate\Support\Facades\Auth;
?>
 @if (Auth::check())
<nav class="navbar w-full shadow-base-300/20 shadow-sm pb-6">
  <div class="w-full md:w-1/6 md:items-center md:gap-2">
    <div id="navbar-collapse" class="md:navbar-end collapse hidden grow basis-full overflow-hidden transition-[height] duration-300 max-md:w-full" >
      <li class="me-2 dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]"> 
        <a href="{{url('/home')}}">
          Home   
        </a>
      </li>
      <li class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]"> 
        <button id="dropdown-link" type="button" class="dropdown-toggle dropdown-open:bg-base-content/10 dropdown-open:text-base-content" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown" >
          Recetas
          <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
        </button>  
        <ul class="dropdown-menu dropdown-open:opacity-100 hidden" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-link" >
          <li><a class="dropdown-item" href="{{route('createRecipe')}}">Crear receta</a></li>
        </ul>  
      </li>
    </div>
  </div>
  <div class="w-full md:flex md:items-center md:gap-2">
    <div id="navbar-collapse" class="md:navbar-end collapse hidden grow basis-full overflow-hidden transition-[height] duration-300 max-md:w-full" >
      <li class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]"> 
        <button id="dropdown-link" type="button" class="dropdown-toggle dropdown-open:bg-base-content/10 dropdown-open:text-base-content" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown" >
          Cuenta
          <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
        </button>  
        <ul class="dropdown-menu dropdown-open:opacity-100 hidden" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-link" >
          <li><a class="dropdown-item" href="{{route('updateUser')}}">Cambiar datos</a></li>
          <!-- <li><a class="dropdown-item" href="#">Link 4</a></li>
          <li><a class="dropdown-item" href="#">Link 5</a></li> -->
          <hr class="border-base-content/25 -mx-2" />
          <li class="menu md:menu-horizontal gap-2 p-0 text-base max-md:mt-2">
            <form method="POST" action="{{ route('logout') }}">
            
                @csrf
                <button type="submit">
                  Cerrar sesión
                </button>
            </form>
          </li>
        </ul>  
      </li>

    </div>
  </div>
</nav>
@endif