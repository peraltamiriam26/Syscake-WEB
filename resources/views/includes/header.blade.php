<?php
  use Illuminate\Support\Facades\Auth;
?>
@if (Auth::check())
    <nav class="navbar flex w-full gap-2 shadow-base-300/20 shadow-sm">
        <div class="w-full md:flex md:items-center md:gap-2">
            <div class="flex items-center justify-between">
                <div class="navbar-start items-center justify-between w-full">
                    <div>
                        <a class="dropdown-item" href="{{url('/home')}}">
                            Home   
                        </a>
                    </div>
                    <div id="multilevel-navbar-collapse-start" class="md:navbar-start collapse hidden grow basis-full gap-2 overflow-hidden transition-[height] duration-300 max-md:w-full">
                        <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] md:[--placement:bottom-end] [--placement:bottom] max-md:mt-2">
                            <button id="nested-dropdown" type="button" class="dropdown-toggle btn btn-text text-base-content/80 dropdown-open:bg-base-content/10 dropdown-open:text-base-content max-md:px-2" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown" >
                                Recetas
                                <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
                            </button>  
                            <div class="dropdown-menu dropdown-open:opacity-100 hidden" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-collapse">
                                <div>
                                  @can('create-receta') 
                                    <a class="dropdown-item" href="{{route('recetas.create')}}">Crear receta</a>
                                  @endcan
                                </div>
                                <div>
                                  <a class="dropdown-item" href="{{route('recipe.index')}}">Ver listado</a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] md:[--placement:bottom-end] [--placement:bottom] max-md:mt-2">
                            <button id="nested-dropdown" type="button" class="dropdown-toggle btn btn-text text-base-content/80 dropdown-open:bg-base-content/10 dropdown-open:text-base-content max-md:px-2" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown" >
                                Planner
                                <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
                            </button>  
                            <div class="dropdown-menu dropdown-open:opacity-100 hidden" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-collapse">
                                <div>
                                    <a class="dropdown-item" href="{{route('create-plan')}}">Crear</a>
                                </div>
                                <div>
                                    <a class="dropdown-item" href="{{route('index-plan')}}">Ver listado</a>
                                </div>
                            </div>
                        </div>
                        @can('es-escritor')
                            <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] md:[--placement:bottom-end] [--placement:bottom] max-md:mt-2">
                                <button id="nested-dropdown" type="button" class="dropdown-toggle btn btn-text text-base-content/80 dropdown-open:bg-base-content/10 dropdown-open:text-base-content max-md:px-2" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown" >
                                    Administración
                                    <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
                                </button>
                                <div class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-collapse">
                                    <div>
                                        <button id="nested-collapse" class="collapse-toggle dropdown-item collapse-open:text-base-content collapse-open:bg-base-content/10 justify-between" data-collapse="#nested-collapse-content">
                                            <span class="flex items-center gap-x-3.5"> Ingredientes </span>
                                            <span class="icon-[tabler--chevron-down] collapse-open:rotate-180 size-4"></span>
                                        </button>
                                        <div class="collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="nested-collapse" id="nested-collapse-content">
                                            <ul class="py-3 ps-3">
                                                <li>
                                                    <a class="dropdown-item" href="{{route('create-ingredient')}}"> Crear </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"  href="{{route('index-ingredients')}}"> Ver listado </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <button id="nested-collapse-typeFood" class="collapse-toggle dropdown-item collapse-open:text-base-content collapse-open:bg-base-content/10 justify-between" data-collapse="#nested-collapse-content-typeFood">
                                            <span class="flex items-center gap-x-3.5"> Tipos de comida </span>
                                            <span class="icon-[tabler--chevron-down] collapse-open:rotate-180 size-4"></span>
                                        </button>
                                        <div class="collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="nested-collapse-typeFood" id="nested-collapse-content-typeFood">
                                            <ul class="py-3 ps-3">
                                                <li>
                                                    <a class="dropdown-item" href="{{route('create-type-food')}}"> Crear </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"  href="{{route('index-type-food')}}"> Ver listado </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <button id="nested-collapse-typeUnity" class="collapse-toggle dropdown-item collapse-open:text-base-content collapse-open:bg-base-content/10 justify-between" data-collapse="#nested-collapse-content-typeUnity">
                                            <span class="flex items-center gap-x-3.5"> Tipos de unidad </span>
                                            <span class="icon-[tabler--chevron-down] collapse-open:rotate-180 size-4"></span>
                                        </button>
                                        <div class="collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="nested-collapse-typeUnity" id="nested-collapse-content-typeUnity">
                                            <ul class="py-3 ps-3">
                                                <li>
                                                    <a class="dropdown-item" href="{{route('create-type-unity')}}"> Crear </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"  href="{{route('index-type-unity')}}"> Ver listado </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <button id="nested-collapse-typeRecipe" class="collapse-toggle dropdown-item collapse-open:text-base-content collapse-open:bg-base-content/10 justify-between" data-collapse="#nested-collapse-content-typeRecipe">
                                            <span class="flex items-center gap-x-3.5"> Tipos de receta </span>
                                            <span class="icon-[tabler--chevron-down] collapse-open:rotate-180 size-4"></span>
                                        </button>
                                        <div class="collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="nested-collapse-typeRecipe" id="nested-collapse-content-typeRecipe">
                                            <ul class="py-3 ps-3">
                                                <li>
                                                    <a class="dropdown-item" href="{{route('create-type-recipe')}}"> Crear </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"  href="{{route('index-type-recipe')}}"> Ver listado </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div id="multilevel-navbar-collapse" class="md:navbar-end collapse hidden grow basis-full gap-2 overflow-hidden transition-[height] duration-300 max-md:w-full">
                <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] md:[--placement:bottom-end] [--placement:bottom] max-md:mt-2">
                    <button id="nested-dropdown" type="button" class="dropdown-toggle btn btn-text text-base-content/80 dropdown-open:bg-base-content/10 dropdown-open:text-base-content max-md:px-2" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                        <span class="icon-[tabler--user] size-6 bg-primary text-primary-content"></span>
                    </button>
                    <div class="dropdown-menu dropdown-open:opacity-100 hidden" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-collapse">
                        <div>
                            <a class="dropdown-item" href="{{route('update-user')}}">Cambiar datos</a>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-start btn btn-text btn-error">
                                    <span class="icon-[tabler--logout]"></span>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endif