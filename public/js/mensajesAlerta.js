function alertDelete(){
    Swal.fire({
                title: "¿Deseas dar baja tu cuenta?",
                // text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí",
                cancelButtonText: "Cancelar"
    }).then((result) => {
                if (result.isConfirmed) {
                   $.ajax({
                        url: '/delete-account', // Ruta en tu Laravel
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: 'application/json',
                        data: {},
                        success: function(response) {
                            if (response) {
                                Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Su cuenta ha sido dada de baja.",
                                        showConfirmButton: false,
                                        timer: 3000
                                });
                                setTimeout(() => {
                                    window.location.href = "/";
                                }, 3000);                                
                            }else{
                                Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: "Ocurrió un error, no se ha podido dar de baja su cuenta.",
                                        showConfirmButton: false,
                                        timer: 3000
                                });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: "Ocurrió un error.",
                                        showConfirmButton: false,
                                        timer: 3000
                                });
                        }
                    });

                }
    });
}
