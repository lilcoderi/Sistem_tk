<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | TK MARHAMAH HASANAH 2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Halaman login TK Marhamah Hasanah 2" name="description" />
    <meta content="Hartono" name="author" />
    <link rel="shortcut icon" href="{{ secure_asset('assets/images/favicon.ico') }}">

    {{-- Include CSS --}}
    @include('layouts.head-css')
</head>

<body>
    @yield('content')

    {{-- Include JS --}}
    @include('layouts.vendor-scripts')
</body>

</html>
