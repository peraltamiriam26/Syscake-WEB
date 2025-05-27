<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/sweetalert2.min.css">
<!-- <link href="../resources/css/app.css" rel="stylesheet"> -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script src="/js/sweetalert2.all.min.js"></script>

@include('sweetalert::alert')
<script type="text/javascript" src="js/mensajesAlerta.js"></script>
@if(session('toast'))
    <script>
        Swal.fire({
            toast: true,
            position: 'center',
            icon: "{{ session('icon', 'info') }}", // sino se envia icon te muestra el icono de info
            title: "{{ session('toast') }}",
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif


<!-- <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script> -->
<title>Syscake</title>
        