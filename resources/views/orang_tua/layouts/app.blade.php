<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard')</title>

    {{-- Favicon & Fonts --}}
    <link rel="icon" href="{{ secure_asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom Fonts & Styles --}}
    <link rel="stylesheet" href="{{ secure_asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/style-preset.css') }}">

    @stack('styles')
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">

    {{-- Header --}}
    @include('kepala_sekolah.layouts.header')

    {{-- Sidebar --}}
    @include('orang_tua.layouts.sidebar')

    {{-- Main Content --}}
    <div class="pc-container">
        <div class="pc-content">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col-sm my-1">
                    <p class="m-0">
                        Hartono &#9829; © Copyright TK Marhamah Hasanah 2 All Rights Reserved | 2025
                    </p>
                </div>
            </div>
        </div>
    </footer>

    {{-- Page Specific JS --}}
    <script src="{{ secure_asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/pages/dashboard-default.js') }}"></script>

    {{-- Required JS --}}
    <script src="{{ secure_asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ secure_asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ secure_asset('assets/js/plugins/feather.min.js') }}"></script>

    {{-- JS Layout Setup --}}
    <script>
        if (typeof layout_change !== 'undefined') layout_change("light");
        if (typeof change_box_container !== 'undefined') change_box_container("false");
        if (typeof layout_rtl_change !== 'undefined') layout_rtl_change("false");
        if (typeof preset_change !== 'undefined') preset_change("preset-1");
        if (typeof font_change !== 'undefined') font_change("Public-Sans");
    </script>

    @yield('scripts')
</body>

</html>
