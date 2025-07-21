<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- **CSRF Token untuk AJAX** --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard')</title>

    {{-- Favicon & Fonts --}}
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Tambahkan ini di bagian head jika belum ada -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    {{-- Icons & Styles --}}
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

    @stack('styles')
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">

    {{-- Sidebar --}}
    @include('kepala_sekolah.layouts.header')

    {{-- Sidebar --}}
    @include('kepala_sekolah.layouts.sidebar')

    {{-- Main Content --}}
    <div class="pc-container">
        <div class="pc-content">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <!-- [ Main Content ] end -->
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col-sm my-1">
                    <p class="m-0">
                        Hartono &#9829; © Copyright TK Marhamah Hasanah 2 All Rights
                        Reserved | 2025
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- [Page Specific JS] end -->
    {{-- <script src="{{ asset('assets/js/dashboard-default.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pcoded.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script> --}}


    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    


    <script>
        layout_change("light");
    </script>

    <script>
        change_box_container("false");
    </script>

    <script>
        layout_rtl_change("false");
    </script>

    <script>
        preset_change("preset-1");
    </script>

    <script>
        font_change("Public-Sans");
    </script>
    @yield('scripts')
</body>
<!-- [Body] end -->

</html>
