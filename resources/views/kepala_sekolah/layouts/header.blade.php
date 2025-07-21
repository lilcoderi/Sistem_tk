<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link" id="sidebar-toggle">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item d-inline-flex d-md-none">
                    <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#"
                        role="button">
                        <i class="ti ti-search"></i>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3">
                            <div class="form-group mb-0 d-flex align-items-center">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control border-0 shadow-none"
                                    placeholder="Search here...">
                            </div>
                        </form>
                    </div>
                </li>
                <li class="pc-h-item d-none d-md-inline-flex">
                    <form class="header-search">
                        <i data-feather="search" class="icon-search"></i>
                        <input type="search" class="form-control" placeholder="Search here...">
                    </form>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block] end -->


        <div class="ms-auto">
            <ul class="list-unstyled">

                @php
                    use Illuminate\Support\Facades\Auth;
                    use Illuminate\Support\Facades\DB;

                    $user = Auth::user();
                    $role = $user->getRoleNames()->first(); // Spatie role

                    $unreadCount = 0;
                    $notifikasis = [];

                    if ($role === 'orang tua') {
                        $unreadCount = DB::table('notifikasi_orang_tua')
                            ->where('user_id', $user->id)
                            ->where('dibaca', false)
                            ->count();

                        $notifikasis = DB::table('notifikasi_orang_tua')
                            ->where('user_id', $user->id)
                            ->orderByDesc('created_at')
                            ->limit(5)
                            ->get();
                    } elseif ($role === 'kepala sekolah') {
                        $unreadCount = DB::table('notifikasi_kepsek')->where('dibaca', false)->count();

                        $notifikasis = DB::table('notifikasi_kepsek')->orderByDesc('created_at')->limit(5)->get();
                    }
                @endphp

                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0 position-relative" data-bs-toggle="dropdown"
                        href="#" role="button">
                        <i class="ti ti-message fs-4 text-dark"></i>
                        @if ($unreadCount > 0)
                            <span id="notif-badge"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger text-white"
                                style="font-size: 0.75rem; min-width: 1.5rem; height: 1.5rem; display: flex; align-items: center; justify-content: center;">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown"
                        style="min-width: 320px;">
                        <div
                            class="dropdown-header d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                            <h5 class="m-0">Notifikasi</h5>
                            @if (count($notifikasis) > 0)
                                <button type="button" class="btn btn-sm btn-link text-success" id="btn-mark-all">Tandai
                                    Semua Dibaca</button>
                            @endif
                        </div>

                        <div class="dropdown-body px-2" id="notif-list">
                            @forelse($notifikasis as $notif)
                                <a href="#" data-id="{{ $notif->id }}"
                                    class="dropdown-item py-2 border-bottom notif-item {{ !$notif->dibaca ? 'fw-bold' : '' }}"
                                    style="white-space: normal;">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted mb-1">
                                            {{ ucfirst($notif->tipe) }} •
                                            {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                        </small>
                                        <span class="text-dark text-wrap"
                                            style="max-width: 100%; word-wrap: break-word;">{{ $notif->pesan }}</span>
                                    </div>
                                </a>
                            @empty
                                <span class="dropdown-item text-muted">Tidak ada notifikasi.</span>
                            @endforelse
                        </div>
                    </div>
                </li>




                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle d-inline-flex align-items-center rounded-3 bg-light px-3 py-1 shadow-sm text-decoration-none"
                        data-bs-toggle="dropdown" href="#" role="button" data-bs-auto-close="outside">

                        {{-- Avatar Icon --}}
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2"
                            style="width: 36px; height: 36px;">
                            <i class="bi bi-person fs-5 text-secondary"></i>
                        </div>

                        {{-- Nama Role atau User --}}
                        <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
                    </a>


                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex mb-1">
                                <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle bg-light text-secondary"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-circle fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                                    <span>Profil Pengguna</span>
                                </div>
                            </div>
                        </div>

                        <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active green-tab" id="drp-t1" data-bs-toggle="tab"
                                    data-bs-target="#drp-tab-1" type="button" role="tab">
                                    <i class="ti ti-user"></i> Profile
                                </button>
                            </li>
                        </ul>


                        <div class="tab-content" id="mysrpTabContent">
                            <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                aria-labelledby="drp-t1">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <i class="ti ti-edit-circle"></i>
                                    <span>Edit Profile</span>
                                </a>
                                <a href="{{ route('profile.view') }}" class="dropdown-item">
                                    <i class="ti ti-user"></i>
                                    <span>View Profile</span>
                                </a>
                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="ti ti-power"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- [ Header Topbar ] end -->


<script>
    document.getElementById('sidebar-toggle').addEventListener('click', function(e) {
        e.preventDefault();
        document.body.classList.toggle('sidebar-collapsed');
    });

    document.addEventListener('DOMContentLoaded', function() {
        const btnSidebarHide = document.getElementById('sidebar-hide');

        btnSidebarHide.addEventListener('click', function(e) {
            e.preventDefault(); // supaya link # tidak jalan

            document.body.classList.toggle('sidebar-collapsed');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const btnSidebarHide = document.getElementById('sidebar-hide');
        if (btnSidebarHide) {
            btnSidebarHide.addEventListener('click', function(e) {
                e.preventDefault(); // supaya link # tidak jalan
                document.body.classList.toggle('sidebar-collapsed');
            });
        }

        // Fungsi Search Sidebar
        const searchInput = document.querySelector('.header-search input[type="search"]');
        const sidebarItems = document.querySelectorAll('.pc-sidebar .pc-item');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();

                sidebarItems.forEach(function(item) {
                    const text = item.textContent.toLowerCase();

                    if (text.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.header-search input[type="search"]');
        const sidebarItems = document.querySelectorAll('.pc-sidebar .pc-item');

        if (searchInput) {
            // Filter saat mengetik
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();

                sidebarItems.forEach(function(item) {
                    const text = item.textContent.toLowerCase();

                    if (text.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Redirect saat Enter
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Hindari submit form default
                    const query = this.value.toLowerCase().trim();

                    for (const item of sidebarItems) {
                        const link = item.querySelector('a.pc-link');
                        if (link && link.textContent.toLowerCase().includes(query)) {
                            window.location.href = link.href;
                            break;
                        }
                    }
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const notifItems = document.querySelectorAll('.notif-item');
        const markAllBtn = document.getElementById('btn-mark-all');
        const notifBadge = document.getElementById('notif-badge');

        notifItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const notifId = item.dataset.id;

                fetch(`/notifikasi-orangtua/${notifId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                }).then(res => res.json()).then(data => {
                    item.classList.remove('fw-bold');

                    // Kurangi badge
                    const count = parseInt(notifBadge?.textContent || 0);
                    if (count > 1) {
                        notifBadge.textContent = count - 1;
                    } else {
                        notifBadge?.remove();
                    }
                });
            });
        });

        if (markAllBtn) {
            markAllBtn.addEventListener('click', function() {
                fetch(`{{ route('notifikasi.orangtua.read.all') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                }).then(res => res.json()).then(data => {
                    // Hapus badge
                    notifBadge?.remove();

                    // Hapus bold semua item
                    document.querySelectorAll('.notif-item.fw-bold').forEach(el => {
                        el.classList.remove('fw-bold');
                    });
                });
            });
        }
    });

    document.getElementById('btn-mark-all')?.addEventListener('click', function() {
        fetch('{{ $role === 'kepala sekolah' ? route('notifikasi.kepsek.read.all') : route('notifikasi.orangtua.read.all') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        }).then(res => res.json()).then(data => {
            document.getElementById('notif-badge')?.remove();
            document.querySelectorAll('.notif-item').forEach(item => {
                item.classList.remove('fw-bold');
            });
        });
    });
    
</script>

<style>
    .nav-link.active.green-tab {
        background-color: #28a745 !important; /* Hijau Bootstrap */
        color: white !important;
        border-color: #28a745 !important;
    }
</style>

