<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Dashboard') | TK MARHAMAH HASANAH 2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard TK Marhamah Hasanah 2">
    <meta name="author" content="Hartono">
    
    <!-- App Favicon -->
    <link rel="shortcut icon" href="{{ secure_asset('build/images/favicon.ico') }}">

    <!-- Include Head CSS -->
    @include('layouts.head-css')

    {{-- Page-specific styles --}}
    @yield('css')
</head>

<body>

    {{-- Page Content --}}
    @yield('content')

    {{-- Optional Right Sidebar --}}
    {{-- @include('layouts.right-sidebar') --}}

    {{-- Vendor Scripts --}}
    @include('layouts.vendor-scripts')

    {{-- Page-specific scripts --}}
    @yield('scripts')
    
</body>

</html>
