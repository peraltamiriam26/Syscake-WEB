<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
<!-- <link href="../resources/css/app.css" rel="stylesheet"> -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
 <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@livewireStyles
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript" src="/js/flatpickr.min.js"></script>
<script type="text/javascript" src="/js/flatpickr-es.min.js"></script>
<script type="text/javascript" src="/js/calendar.js"></script>
<script type="text/javascript" src="/js/modal.js"></script>
<script type="text/javascript" src="{{ asset('/js/select2.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/select2es.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/plan.js')}}"></script>

@include('sweetalert::alert')
<script type="text/javascript" src="{{ asset('js/mensajesAlerta.js')}}"></script>
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
        