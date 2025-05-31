<?php
  use Illuminate\Support\Facades\Auth;
?>
 @if (Auth::check())
<nav class="navbar w-full shadow-base-300/20 shadow-sm pb-6">
  <div class="w-full md:flex md:items-center md:gap-2">
    <div id="navbar-collapse" class="md:navbar-end collapse hidden grow basis-full overflow-hidden transition-[height] duration-300 max-md:w-full" >
      <li class="pe-2 dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]"> 
        <button id="dropdown-link" type="button" class="dropdown-toggle dropdown-open:bg-base-content/10 dropdown-open:text-base-content" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown" >
          Planner
          <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
        </button>  
        <ul class="dropdown-menu dropdown-open:opacity-100 hidden" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-link" >
          <li><a class="dropdown-item" href="{{route('create-plan')}}">Crear</a></li>
          <li><a class="dropdown-item" href="{{route('index-plan')}}">Ver listado</a></li>
        </ul>  
      </li>
      <li class="pe-2 dropdown relative inline-flex [--auto-close:inside] [--offset:9] [--placement:bottom-end]">
        <button id="dropdown-end" type="button" class="dropdown-toggle dropdown-open:bg-base-content/10 dropdown-open:text-base-content max-md:px-2" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
          Administración
          <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
        </button>
        <ul class="dropdown-menu dropdown-open:opacity-100 hidden w-48" role="menu" aria-orientation="vertical" aria-labelledby="nested-dropdown">
          <li class="dropdown relative [--auto-close:inside] [--offset:10] [--placement:right-start]">
            <button id="nested-dropdown-2" class="dropdown-toggle dropdown-item dropdown-open:bg-base-content/10 dropdown-open:text-base-content justify-between" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
              Ingredientes
              <span class="icon-[tabler--chevron-right] size-4 rtl:rotate-180"></span>
            </button>
            <ul class="dropdown-menu dropdown-open:opacity-100 hidden w-48" role="menu" aria-orientation="vertical" aria-labelledby="nested-dropdown-2">
              <li>
                <a class="dropdown-item" href="{{route('create-ingredient')}}">
                  Crear
                </a>
              </li>
              <li>
                <a class="dropdown-item"  href="{{route('index-ingredients')}}">
                  Ver listado
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]"> 
        <button id="dropdown-link" type="button" class="dropdown-toggle dropdown-open:bg-base-content/10 dropdown-open:text-base-content" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown" >
          Cuenta
          <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
        </button>  
        <ul class="dropdown-menu dropdown-open:opacity-100 hidden" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-link" >
          <li><a class="dropdown-item" href="{{route('update-user')}}">Cambiar datos</a></li>
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