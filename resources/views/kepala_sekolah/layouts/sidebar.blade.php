<style>
    .pc-item.active .pc-link {
        color: #000000 !important;
        font-weight: bold;
        background-color: #dcfcda;
        border-radius: 8px;
    }
</style>

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            @role('kepala sekolah')
                <a href="{{ route('kepala_sekolah.dashboard') }}" class="b-brand text-primary">
                @elseif(Auth::user()->hasRole('guru'))
                    <a href="{{ route('guru.dashboard') }}" class="b-brand text-primary">
                    @elseif(Auth::user()->hasRole('orang tua'))
                        <a href="{{ route('orang_tua.dashboard') }}" class="b-brand text-primary">
                            @endif
                            <img src="{{ asset('assets/images/logo-dark.png') }}" class="img-fluid logo-lg" alt="logo"
                                onerror="this.src='{{ asset('assets/images/logo-dark.png') }}';">
                        </a>
            </div>

            <div class="navbar-content">
                <ul class="pc-navbar">
                    {{-- Dashboard --}}
                    @role('kepala sekolah')
                        <li class="pc-item {{ request()->routeIs('kepala_sekolah.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('kepala_sekolah.dashboard') }}" class="pc-link">
                            @elseif(Auth::user()->hasRole('guru'))
                        <li class="pc-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('guru.dashboard') }}" class="pc-link">
                            @elseif(Auth::user()->hasRole('orang tua'))
                        <li class="pc-item {{ request()->routeIs('orang_tua.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('orang_tua.dashboard') }}" class="pc-link">
                                @endif
                                <span class="pc-micon"><i class="bi bi-speedometer2"></i></span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>

                        <li class="pc-item pc-caption">
                            <label>Siswa/Siswi</label>
                            <i class="bi bi-people"></i>
                        </li>

                        <li class="pc-item {{ request()->routeIs('data-siswa.index') ? 'active' : '' }}">
                            <a href="{{ route('data-siswa.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-person-lines-fill"></i></span>
                                <span class="pc-mtext">Data Siswa TK</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('kegiatan.calendar') ? 'active' : '' }}">
                            <a href="{{ route('kegiatan.calendar') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-calendar-check"></i></span>
                                <span class="pc-mtext">Kalender Kegiatan Anak</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('fotokegiatan.index') ? 'active' : '' }}">
                            <a href="{{ route('fotokegiatan.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-balloon-heart"></i></span>
                                <span class="pc-mtext">Photo Kegiatan Anak</span>
                            </a>
                        </li>

                        {{-- Tidak ditampilkan jika role guru --}}
                        @unlessrole('guru')
                            <li class="pc-item {{ request()->routeIs('konfirmasi-pembayaran.index') ? 'active' : '' }}">
                                <a href="{{ route('konfirmasi-pembayaran.index') }}" class="pc-link">
                                    <span class="pc-micon"><i class="bi bi-credit-card"></i></span>
                                    <span class="pc-mtext">Pembayaran Pendaftaran</span>
                                </a>
                            </li>
                        @endunlessrole

                        <li class="pc-item pc-caption">
                            <label>Penilaian Asesmen</label>
                            <i class="bi bi-card-checklist"></i>
                        </li>

                        <li class="pc-item {{ request()->routeIs('tematk.index') ? 'active' : '' }}">
                            <a href="{{ route('tematk.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-journal-richtext"></i></span>
                                <span class="pc-mtext">Tema Pembelajaran</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('subtema.index') ? 'active' : '' }}">
                            <a href="{{ route('subtema.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-journals"></i></span>
                                <span class="pc-mtext">Sub Tema Pembelajaran</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('lingkup.index') ? 'active' : '' }}">
                            <a href="{{ route('lingkup.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-collection"></i></span>
                                <span class="pc-mtext">Lingkup Perkembangan</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('modulAjar.index') ? 'active' : '' }}">
                            <a href="{{ route('modulAjar.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-book"></i></span>
                                <span class="pc-mtext">Modul Pembelajaran</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('asesmen.anekdot.index') ? 'active' : '' }}">
                            <a href="{{ route('asesmen.anekdot.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-brush"></i></span>
                                <span class="pc-mtext">Asesmen Anekdot Anak</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('asesmen.index') ? 'active' : '' }}">
                            <a href="{{ route('asesmen.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-pencil-square"></i></span>
                                <span class="pc-mtext">Asesmen Ceklis Anak</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('hasil-asesmen.index') ? 'active' : '' }}">
                            <a href="{{ route('hasil-asesmen.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-bar-chart-line"></i></span>
                                <span class="pc-mtext">Hasil Asesmen Ceklis</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('rapor.index') ? 'active' : '' }}">
                            <a href="{{ route('rapor.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-file-earmark-text"></i></span>
                                <span class="pc-mtext">Rapor Anak</span>
                            </a>
                        </li>

                        <li class="pc-item pc-caption">
                            <label>Prediksi Perkembangan</label>
                            <i class="bi bi-graph-up-arrow"></i>
                        </li>

                        <li class="pc-item {{ request()->routeIs('tumbuh_kembang.index') ? 'active' : '' }}">
                            <a href="{{ route('tumbuh_kembang.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-bandaid"></i></span>
                                <span class="pc-mtext">Data Tumbuh Kembang</span>
                            </a>
                        </li>

                        <li class="pc-item {{ request()->routeIs('ddtk.index') ? 'active' : '' }}">
                            <a href="{{ route('ddtk.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="bi bi-activity"></i></span>
                                <span class="pc-mtext">DDTK Anak</span>
                            </a>
                        </li>

                        {{-- Manajemen Akun - kecuali guru --}}
                        @unlessrole('guru')
                            <li class="pc-item pc-caption">
                                <label>Manajemen Pengguna</label>
                                <i class="bi bi-person-gear"></i>
                            </li>

                            <li class="pc-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                                <a href="{{ route('user.index') }}" class="pc-link">
                                    <span class="pc-micon"><i class="bi bi-person-circle"></i></span>
                                    <span class="pc-mtext">Manajemen Akun</span>
                                </a>
                            </li>

                            <li class="pc-item {{ request()->routeIs('guru.index') ? 'active' : '' }}">
                                <a href="{{ route('guru.index') }}" class="pc-link">
                                    <span class="pc-micon"><i class="bi bi-person-badge"></i></span>
                                    <span class="pc-mtext">Manajemen Guru</span>
                                </a>
                            </li>
                        @endunlessrole
                    </ul>
                </div>
            </div>
        </nav>
