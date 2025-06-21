@extends('layouts.app')
@section("content")
<div class=" ">
    <h1 class="text-3xl font-bold col-span-12">Bienvenido {{ auth()->user()->nombre }}</h1><br><br>
    <div class="card">
                @livewire('plane-table')           
    </div>
</div>
    
<!-- MODAL -->
 <div id="form-modal" class="overlay modal overlay-open:opacity-100 hidden overlay-open:duration-300" role="dialog" tabindex="-1">
  <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
    <div id="modalContent" class="modal-content">
    </div>
  </div>
 </div>

@stop