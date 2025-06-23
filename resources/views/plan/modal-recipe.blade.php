<div id="modalContent" class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title">{{$recipe->nombre}} </h3> 
            <div  class="flex space-x-2 pe-2">
                <a class="btn btn-circle btn-text btn-sm " aria-label="Action button" href="#" title="Editar receta">
                    <span class="icon-[tabler--pencil] size-5 bg-info"></span>
                </a>
                <a id="btnDelete"  aria-label="Action button" class="btn btn-circle btn-text btn-sm" href="#" title="Eliminar del plan">
                    <span class="icon-[tabler--trash] size-5 bg-error"></span>
                </a>
            </div>
            <button type="button"  wire:click="$dispatch('close-modal')" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close" data-overlay="#form-modal" >
                <span class="icon-[tabler--x] size-4"></span>
            </button>
    </div>
    <div class="modal-body">    
    </div>
</div>

