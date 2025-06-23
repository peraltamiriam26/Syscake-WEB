@extends('layouts.app')
@section("content")
<div>
    <h1 class="text-3xl font-bold col-span-12 pt-2 pb-2">Bienvenido {{ auth()->user()->nombre }}</h1>    
      @livewire('plane-table')           
</div>
    

@stop