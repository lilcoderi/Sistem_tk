<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
            <title>TK. MARHAMAH HASANAH 2</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="Premium Bootstrap v5.3.3 Landing Page Template" />
            <meta name="keywords" content="Bootstrap v5.3.3, premium, marketing, multipurpose" />
            <meta content="Codebucks" name="author" />
    
            <!-- favicon -->
            <link rel="shortcut icon" href="{{ URL::asset('../images/favicon.ico')}}" />

            @yield('css')
            @include('partials.head-css')
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="51">

    @include('partials.preloader')

    @yield('content')

    @include('partials.vendor-script')

    @yield('scripts')

</body>

</html>