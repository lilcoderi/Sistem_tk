<!-- CSS -->
<link href="{{ secure_asset('build/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ secure_asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ secure_asset('build/css/app.min.css') }}" rel="stylesheet" type="text/css" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Tambahan opsional layout JS seperti pengaturan tema --}}
<script src="{{ secure_asset('build/js/pages/layout.js') }}"></script>

@yield('css')
