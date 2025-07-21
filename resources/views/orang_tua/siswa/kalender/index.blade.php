@stack('scripts')

@extends('orang_tua.layouts.app')

@section('title')
    Jadwal Kegiatan Siswa
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Siswa/Siswi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('kalender.orangtua') }}">Jadwal Kegiatan Siswa</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    
    <div class="container my-5">
        {{-- Judul Halaman --}}
        <div class="text-center mb-5">
            <h3 class="fw-bold text-success">
                <i class="bi bi-calendar3 me-2"></i> Manajemen Kegiatan
            </h3>
            <p class="text-muted">Kelola daftar kegiatan siswa secara efektif dan efisien</p>
        </div>

        <div class="row g-4">
            <!-- Kalender di kiri -->
            <div class="col-md-7">
                <div class="card shadow-sm border-success h-100">
                    <div class="card-header bg-success text-white fw-semibold text-center">
                        <i class="bi bi-calendar-week me-2"></i> Kalender Kegiatan
                    </div>
                    <div class="card-body p-3">
                        <div id="calendar" style="width: 100%; min-height: 500px;"></div>
                    </div>
                </div>
            </div>

            <!-- Catatan di kanan -->
            <div class="col-md-5">
                <div class="card shadow-sm border-success h-100 d-flex flex-column">
                    <div class="card-header bg-success text-white fw-semibold text-center">
                        <i class="bi bi-journal-text me-2"></i> Catatan Kegiatan Terbaru
                    </div>
                    <div class="card-body">
                        @php
                            use Carbon\Carbon;
                            $kegiatanTerbaru = \App\Models\KegiatanTK::whereDate('tanggal', '>=', Carbon::today())
                                ->orderBy('tanggal', 'desc')
                                ->take(5)
                                ->get();
                        @endphp

                        @if ($kegiatanTerbaru->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach ($kegiatanTerbaru as $kegiatan)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="fw-bold text-success">{{ $kegiatan->judul }}</div>
                                                <div class="text-muted small">
                                                    {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}
                                                </div>
                                                <div class="text-secondary small">{{ $kegiatan->deskripsi }}</div>
                                            </div>
                                            <div class="ms-2 text-end">
                                                <a href="{{ route('kegiatan.edit', $kegiatan->id) }}"
                                                    class="btn btn-sm btn-outline-warning mb-1" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-warning text-center m-0">
                                Tidak ada kegiatan mendatang.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styling Kalender -->
    <style>
        .fc {
            font-size: 14px;
        }

        .fc-toolbar-title {
            font-weight: bold;
            color: #198754;
        }

        .fc-daygrid-day-number {
            color: #198754;
        }

        .fc-day-today {
            background-color: #dcfcda !important;
        }
    </style>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '/api/kegiatan',
                // dateClick: function(info) {
                //     window.location.href = '/kegiatan/create?tanggal=' + info.dateStr;
                // }
            });

            calendar.render();
        });
    </script>
@endpush
@stack('scripts')
