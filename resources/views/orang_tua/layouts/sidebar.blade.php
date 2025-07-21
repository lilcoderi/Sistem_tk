<style>
    .pc-item.active .pc-link {
        color: #000000 !important;
        /* Hijau Bootstrap */
        font-weight: bold;
        background-color: #dcfcda;
        /* Latar hijau muda */
        border-radius: 8px;
    }
</style>

<script src="https://unpkg.com/lucide@latest"></script>

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ url('/orang-tua/dashboard') }}" class="b-brand text-primary">
                <img src="{{ asset('assets/images/logo-dark.png') }}" class="img-fluid logo-lg" alt="logo" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item {{ request()->is('orang-tua/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/orang-tua/dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i data-lucide="layout-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Siswa/Siswi</label>
                    <i class="ti ti-dashboard"></i>
                </li>

                <li class="pc-item {{ request()->routeIs('profil-siswa.orangtua') ? 'active' : '' }}">
                    <a href="{{ route('profil-siswa.orangtua') }}" class="pc-link">
                        <span class="pc-micon"><i data-lucide="user"></i></span>
                        <span class="pc-mtext">Profil Siswa</span>
                    </a>
                </li>


                <li class="pc-item {{ request()->routeIs('profil-anak.anekdot.orangtua') ? 'active' : '' }}">
                    <a href="{{ route('profil-anak.anekdot.orangtua') }}" class="pc-link">
                        <span class="pc-micon"><i data-lucide="palette"></i></span>
                        <span class="pc-mtext">Hasil Karya Anak</span>
                    </a>
                </li>

                <li class="pc-item {{ request()->routeIs('kalender.orangtua') ? 'active' : '' }}">
                    <a href="{{ route('kalender.orangtua') }}" class="pc-link">
                        <span class="pc-micon"><i data-lucide="calendar-days"></i></span>
                        <span class="pc-mtext">Jadwal Kegiatan Anak</span>
                    </a>
                </li>

                <li class="pc-item {{ request()->routeIs('orangtua.rapor.index') ? 'active' : '' }}">
                    <a href="{{ route('orangtua.rapor.index') }}" class="pc-link">
                        <span class="pc-micon"><i data-lucide="file-text"></i></span>
                        <span class="pc-mtext">Rapor Siswa</span>
                    </a>
                </li>

                <li class="pc-item {{ request()->routeIs('orangtua.pembayaran.index') ? 'active' : '' }}">
                    <a href="{{ route('orangtua.pembayaran.index') }}" class="pc-link">
                        <span class="pc-micon"><i data-lucide="wallet"></i></span>
                        <span class="pc-mtext">Status Pembayaran</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    lucide.createIcons();
</script>