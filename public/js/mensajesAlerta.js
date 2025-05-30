function alertDelete(url, title){
    console.log(url);
    
    Swal.fire({
                title: title,
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
                        url: url, // Ruta en tu Laravel
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: 'application/json',
                        data: {},
                        success: function(response) {
                            if (response.flag) {
                                Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: response.mensaje,
                                        showConfirmButton: false,
                                        timer: 3000
                                });
                                setTimeout(() => {
                                    window.location.href = response.ruta;
                                }, 3000);                                
                            }else{
                                Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: response.mensaje,
                                        showConfirmButton: false,
                                        timer: 3000
                                });
                            }
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

                }
    });
}
