<?php
  use Illuminate\Support\Facades\Auth;
?>
 @if (Auth::check())
<nav class="navbar rounded-box shadow-base-300/20 shadow-sm pb-6">
  <div class="w-full md:flex md:items-center md:gap-2">
    <div class="flex items-center justify-between">
      <div class="navbar-start items-center justify-between max-md:w-full">
        <a href="{{ route('home') }}" aria-label="Home">
          
        </a>
        <div class="md:hidden">
          <button type="button" class="collapse-toggle btn btn-outline btn-secondary btn-sm btn-square" data-collapse="#logo-navbar-collapse" aria-controls="logo-navbar-collapse" aria-label="Toggle navigation" >
            <span class="icon-[tabler--menu-2] collapse-open:hidden size-4"></span>
            <span class="icon-[tabler--x] collapse-open:block hidden size-4"></span>
          </button>
        </div>
      </div>
    </div>
    <div id="logo-navbar-collapse" class="md:navbar-end collapse hidden grow basis-full overflow-hidden transition-[height] duration-300 max-md:w-full" >
      <ul class="menu md:menu-horizontal gap-2 p-0 text-base max-md:mt-2">
        <!-- <li><a href="#"></a></li> -->
        <!-- <li><a href="#">About</a></li> -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
              Cerrar sesión
            </button>
        </form>

        
      </ul>
    </div>
  </div>
</nav>
@endif