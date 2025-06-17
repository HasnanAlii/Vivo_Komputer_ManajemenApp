<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Vivo Komputer</title>
        <link rel="icon" href="{{ asset('assets/images/vivologo.png') }}" type="image/png">
        {{-- <svg style="display: none;"> --}}

        <symbol id="icon-archive-box" viewBox="0 0 24 24"><path d="..." /></symbol>
        <symbol id="icon-shopping-cart" viewBox="0 0 24 24"><path d="..." /></symbol>
        <symbol id="icon-document-text" viewBox="0 0 24 24"><path d="..." /></symbol>
        <symbol id="icon-currency-dollar" viewBox="0 0 24 24"><path d="..." /></symbol>
        <symbol id="icon-wrench-screwdriver" viewBox="0 0 24 24"><path d="..." /></symbol>
        <symbol id="icon-credit-card" viewBox="0 0 24 24"><path d="..." /></symbol>          
        </svg>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                <!-- CSS select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- JS select2 dan jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="//unpkg.com/alpinejs" defer></script>


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        
        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
                
            </div>
        </header>
        @endisset
        
        <!-- Page Content -->
        <main> @yield('content')
            
            {{ $slot }}
        </main>
    </div><!-- jQuery -->
    <script src="//unpkg.com/alpinejs" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#select-sparepart').select2({
            placeholder: "   Pilih Sparepart",
            allowClear: true
        });
    });
</script>
<script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        });
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type') }}";
            switch (type) {
                case 'info':
                    Toast.fire({
                        icon: 'info',
                        title: "{{ Session::get('message') }}"
                    });
                    break;
                case 'success':
                    Toast.fire({
                        icon: 'success',
                        title: "{{ Session::get('message') }}"
                    });
                    break;
                case 'warning':
                    Toast.fire({
                        icon: 'warning',
                        title: "{{ Session::get('message') }}"
                    });
                    break;
                case 'error':
                    Toast.fire({
                        icon: 'error',
                        title: "{{ Session::get('message') }}"
                    });
                    break;
                case 'dialog_error':
                    Swal.fire({
                        icon: 'error',
                        title: "Ooops",
                        text: "{{ Session::get('message') }}",
                        timer: 3000
                    });
                    break;
            }
        @endif
        @if ($errors->any())
            @php $list = null; @endphp
            @foreach ($errors->all() as $error)
                @php $list .= '<li>'.$error.'</li>'; @endphp
            @endforeach
            Swal.fire({
                type: 'error',
                title: "Ooops",
                html: "<ul>{!! $list !!}</ul>",
            });
        @endif
    </script>
<script src="//unpkg.com/alpinejs" defer></script>


    </body>
</html>
