function openModal(url, method) {
     $.ajax({
        url: url, // Ruta en tu Laravel
        type: method,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: 'application/json',
        data: {},
        success: function(response) {            
            $("#modalContent").html(response); // Inserta el formulario en el modal
            $("#form-modal").removeClass("hidden"); // Muestra el modal

        },
        error: function(xhr, status, err) {
            console.log(err);
            
            Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Ocurrió un error.",
                        showConfirmButton: false,
                        timer: 3000
                });
        }
    });
};