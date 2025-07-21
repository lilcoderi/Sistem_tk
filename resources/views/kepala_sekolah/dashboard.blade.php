@extends('kepala_sekolah.layouts.app')

@php
    $isKepala = auth()->user()->hasRole('kepala sekolah');
@endphp

@section('title', $isKepala ? 'Dashboard Kepala Sekolah' : 'Dashboard Guru')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ $isKepala ? route('kepala_sekolah.dashboard') : '#' }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Selamat Datang -->
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                Selamat datang di dashboard {{ $isKepala ? 'kepala sekolah' : 'guru' }}!
            </div>
        </div>
    </div>

    <!-- Distribusi Angkatan dan Info Samping -->
    <div class="card shadow-sm mb-4 mt-4">
        <div class="card-header">
            <h5 class="mb-0">Informasi Umum TK Marhamah Hasanah 2</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- PIE CHART -->
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <canvas id="angkatanPieChart" style="max-width: 100%; height: 200px; width: 200px;"></canvas>
                </div>

                <!-- TEMA + SUBTEMA -->
                <div class="col-md-4 border-start">
                    <h6 class="text-muted">Tema & Subtema</h6>
                    <div id="listTemaSubtema" class="mb-0"
                        style="max-height: 250px; overflow-y: auto; padding-right: 8px;"></div>
                </div>


                <!-- LINGKUP PERKEMBANGAN -->
                <div class="col-md-4 border-start">
                    <h6 class="text-muted">Lingkup Perkembangan</h6>
                    <ul class="mb-0" id="listLingkupPerkembangan">
                        <!-- Akan diisi via JS -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Perkembangan dan Info Penilaian -->
    <div class="row mt-4 d-flex align-items-stretch">
        <!-- KIRI: Grafik Perkembangan -->
        <div class="col-md-6 d-flex">
            <div class="card shadow-sm h-100 w-100">
                <div class="card-header">
                    <h5 class="mb-0">Grafik Perkembangan Indikator Siswa</h5>
                </div>
                <div class="card-body d-flex flex-column" style="gap: 16px;">
                    <!-- Select Siswa -->
                    <div class="form-group">
                        <label for="perkembanganSelect">Pilih Siswa:</label>
                        <select id="perkembanganSelect" class="form-control">
                            @foreach ($semuaSiswa as $siswa)
                                <option value="{{ $siswa->id }}" {{ $siswa->id == $id_siswa ? 'selected' : '' }}>
                                    {{ $siswa->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Chart + Manual Y-Axis -->
                    <div style="display: flex;">
                        <!-- Manual Y-axis -->
                        <div style="min-width: 60px; text-align: right; padding-right: 8px; margin-top: 17px;">
                            <div style="height: 60px;">BSB</div>
                            <div style="height: 60px;">BSH</div>
                            <div style="height: 60px;">MB</div>
                            <div style="height: 60px;">BB</div>
                        </div>

                        <!-- Scrollable Chart -->
                        <div style="overflow-x: auto; width: 100%;">
                            <div id="chartScrollWrapper">
                                <canvas id="lineChartPerkembangan" height="240"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KANAN: Grafik Bar Penilaian -->
        <div class="col-md-6 d-flex">
            <div class="card shadow-sm h-100 w-100">
                <div class="card-header">
                    <h5 class="mb-0">Grafik Penilaian Anak Berdasarkan Indikator</h5>
                </div>
                <div class="card-body d-flex flex-column" style="gap: 16px;">
                    <!-- Select Siswa -->
                    <div class="form-group">
                        <label for="siswaSelect">Pilih Siswa:</label>
                        <select id="siswaSelect" class="form-control">
                            @foreach ($semuaSiswa as $siswa)
                                <option value="{{ $siswa->id }}" {{ $siswa->id == $id_siswa ? 'selected' : '' }}>
                                    {{ $siswa->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bar Chart -->
                    <canvas id="barChart" style="max-height: 220px;"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- Prediksi Awal, Asesmen dan DDTK -->
    <div class="row mt-4">
        <!-- KIRI -->
        <div class="col-md-6">
            <!-- Hasil Prediksi Awal -->
            <div class="card shadow-sm mb-4" style="max-height: 400px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hasil Prediksi Awal</h5>
                    <select id="prediksiSelect" class="form-control" style="width: 300px">
                        @foreach ($semuaSiswa as $siswa)
                            <option value="{{ $siswa->id }}" {{ $siswa->id == $id_siswa ? 'selected' : '' }}>
                                {{ $siswa->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body overflow-auto" style="max-height: 300px;">
                    <div id="hasilPrediksiList">
                        <!-- Akan diisi via JS -->
                    </div>
                </div>
            </div>

            <!-- Tabel DDTK Terbaru -->
            <div class="card shadow-sm" style="max-height: 400px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data DDTK Terbaru</h5>
                    <form method="GET" action="{{ route('kepala_sekolah.dashboard') }}"
                        class="d-flex align-items-center">
                        <label for="ddtkSiswaSelect" class="me-2 mb-0">Pilih Siswa:</label>
                        <select name="id_siswa" id="ddtkSiswaSelect" class="form-control" onchange="this.form.submit()">
                            @foreach ($semuaSiswa as $siswa)
                                <option value="{{ $siswa->id }}" {{ $siswa->id == $id_siswa ? 'selected' : '' }}>
                                    {{ $siswa->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="card-body overflow-auto" style="max-height: 300px;">
                    @forelse ($ddtkList as $item)
                        <div class="mb-3 p-3 border rounded bg-light">
                            <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}<br>
                            <strong>Hasil:</strong> {{ $item->hasil_ddtk }}<br>
                            <strong>Rekomendasi:</strong><br>
                            <div class="ms-3 mb-2">{{ $item->rekomendasi }}</div>
                            <strong>Keterangan:</strong><br>
                            <div class="ms-3">{{ $item->keterangan }}</div>
                        </div>
                    @empty
                        <p class="text-center">Belum ada data DDTK untuk siswa ini.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- KANAN -->
        <div class="col-md-6">
            <!-- Grafik Polinomial -->
            <div class="card shadow-sm" style="max-height: 820px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Grafik Polinomial</h5>
                    <select id="chartPolinomialSelect" class="form-control" style="width: 300px">
                        @foreach ($semuaSiswa as $siswa)
                            <option value="{{ $siswa->id }}" {{ $siswa->id == $id_siswa ? 'selected' : '' }}>
                                {{ $siswa->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body overflow-auto" style="max-height: 720px;">
                    <canvas id="chartPolinomial" height="120"></canvas>
                    <div id="detailPolinomial" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartInstance = null,
            angkatanChart = null,
            perkembanganChart = null;

        function loadChart(siswaId) {
            fetch(`/dashboard-sekolah/asesmen-chart/${siswaId}`)
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('barChart').getContext('2d');
                    if (chartInstance) chartInstance.destroy();

                    chartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(data),
                            datasets: [{
                                label: 'Jumlah Penilaian',
                                data: Object.values(data),
                                backgroundColor: ['#f44336', '#ff9800', '#4caf50', '#2196f3'],
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Grafik Penilaian per Indikator'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                });
        }

        function loadAngkatanChart() {
            fetch(`/dashboard-sekolah/angkatan-distribusi`)
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('angkatanPieChart').getContext('2d');
                    if (angkatanChart) angkatanChart.destroy();

                    angkatanChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: Object.keys(data),
                            datasets: [{
                                data: Object.values(data),
                                backgroundColor: ['#4caf50', '#ff9800', '#2196f3', '#e91e63', '#9c27b0']
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Jumlah Siswa per Angkatan'
                                }
                            }
                        }
                    });
                });
        }


        function loadPerkembanganChart(siswaId) {
            fetch(`/dashboard-sekolah/perkembangan-chart/${siswaId}`)
                .then(res => res.json())
                .then(data => {
                    const canvas = document.getElementById('lineChartPerkembangan');
                    const ctx = canvas.getContext('2d');

                    if (perkembanganChart) perkembanganChart.destroy();

                    // 💡 Lebarkan canvas sesuai jumlah label
                    const labelWidth = 80;
                    const totalWidth = data.labels.length * labelWidth;
                    canvas.style.width = `${totalWidth}px`;
                    canvas.style.height = `240px`; // 4 baris * 60px

                    // Wrapper scroll horizontal (div di luar canvas)
                    const wrapper = document.getElementById('chartScrollWrapper');
                    if (wrapper) wrapper.style.minWidth = `${totalWidth}px`;

                    perkembanganChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Nilai Indikator',
                                data: data.data,
                                borderColor: '#673ab7',
                                backgroundColor: 'rgba(103,58,183,0.2)',
                                fill: true,
                                tension: 0.3,
                                pointRadius: 5,
                                pointBackgroundColor: '#673ab7'
                            }]
                        },
                        options: {
                            responsive: false,
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    top: 0,
                                    bottom: 0,
                                    left: 0,
                                    right: 0
                                }
                            },
                            plugins: {
                                title: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => ['BB', 'MB', 'BSH', 'BSB'][ctx.parsed.y - 1] || ctx.parsed
                                            .y
                                    }
                                },
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    min: 0.5,
                                    max: 4.5,
                                    ticks: {
                                        stepSize: 1,
                                        display: false // 🔒 Sembunyikan ticks, tapi biarkan axis aktif
                                    },
                                    grid: {
                                        display: false,
                                        drawTicks: false,
                                        drawBorder: false
                                    }
                                },
                                x: {
                                    ticks: {
                                        autoSkip: false
                                    },
                                    grid: {
                                        drawTicks: false
                                    }
                                }
                            }
                        }
                    });
                    // ✅ Scroll ke kanan otomatis setelah grafik dirender
                    setTimeout(() => {
                        const outerScrollWrapper = wrapper?.parentElement;
                        if (outerScrollWrapper) {
                            outerScrollWrapper.scrollLeft = outerScrollWrapper.scrollWidth;
                        }
                    }, 300);
                });

        }




        function loadHasilPrediksiAwal(siswaId) {
            fetch(`/dashboard-sekolah/hasil-prediksi-awal/${siswaId}`)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('hasilPrediksiList');
                    container.innerHTML = '';

                    if (data.length === 0) {
                        container.innerHTML = '<p class="text-center">Tidak ada data</p>';
                        return;
                    }

                    data.forEach(row => {
                        const date = new Date(row.created_at);
                        const formattedDate = date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        });

                        container.innerHTML += `
                    <div class="mb-4 p-3 border rounded bg-light">
                        <strong>Tanggal:</strong> ${formattedDate}<br>
                        <strong>Prediksi:</strong> ${row.prediksi_awal}<br>
                        <strong>Rekomendasi:</strong><br>
                        <div class="ms-4 mb-2">${row.rekomendasi_awal}</div>
                        <strong>Catatan:</strong><br>
                        <div class="ms-4">${row.catatan_sistem_pakar}</div>
                    </div>
                `;
                    });
                });
        }


        let polinomialChart = null;

        function loadPolinomialChart(siswaId) {
            fetch(`/dashboard-sekolah/chart-polinomial/${siswaId}`)
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('chartPolinomial').getContext('2d');
                    if (polinomialChart) polinomialChart.destroy();

                    polinomialChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                    label: 'BB',
                                    data: data.datasets.BB,
                                    borderColor: '#f44336',
                                    tension: 0.4
                                },
                                {
                                    label: 'MB',
                                    data: data.datasets.MB,
                                    borderColor: '#ff9800',
                                    tension: 0.4
                                },
                                {
                                    label: 'BSH',
                                    data: data.datasets.BSH,
                                    borderColor: '#4caf50',
                                    tension: 0.4
                                },
                                {
                                    label: 'BSB',
                                    data: data.datasets.BSB,
                                    borderColor: '#2196f3',
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Grafik Polinomial Nilai Hasil Asesmen'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Tampilkan rekomendasi & catatan
                    const detailDiv = document.getElementById('detailPolinomial');
                    detailDiv.innerHTML = '';

                    data.details.forEach((item, index) => {
                        detailDiv.innerHTML += `
                    <div class="mt-3 p-3 border rounded bg-light">
                        <strong>Tanggal:</strong> ${item.tanggal}<br>
                        <strong>Rekomendasi:</strong> ${item.rekomendasi}<br>
                        <strong>Catatan:</strong> ${item.catatan}
                    </div>
                `;
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetch('/dashboard-sekolah/statistik')
                .then(res => res.json())
                .then(data => {
                    // Tema + Subtema
                    const container = document.getElementById('listTemaSubtema');
                    container.innerHTML = '';

                    data.temas.forEach(t => {
                        const temaEl = document.createElement('strong');
                        temaEl.textContent = `Tema: ${t.tema}`;
                        container.appendChild(temaEl);

                        const ul = document.createElement('ul');
                        t.subtemas.forEach(sub => {
                            const li = document.createElement('li');
                            li.textContent = sub;
                            ul.appendChild(li);
                        });
                        container.appendChild(ul);
                    });

                    // List Lingkup Perkembangan
                    const listLingkup = document.getElementById('listLingkupPerkembangan');
                    listLingkup.innerHTML = '';
                    data.lingkup_perkembangan.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item;
                        listLingkup.appendChild(li);
                    });
                });
        });



        document.addEventListener('DOMContentLoaded', function() {
            const siswaSelect = document.getElementById('siswaSelect');
            const perkembanganSelect = document.getElementById('perkembanganSelect');
            const prediksiSelect = document.getElementById('prediksiSelect');
            const chartPolinomialSelect = document.getElementById('chartPolinomialSelect');

            loadChart(siswaSelect.value);
            loadAngkatanChart();
            loadPerkembanganChart(perkembanganSelect.value);
            loadHasilPrediksiAwal(prediksiSelect.value);
            loadPolinomialChart(chartPolinomialSelect.value);

            siswaSelect.addEventListener('change', () => loadChart(siswaSelect.value));
            perkembanganSelect.addEventListener('change', () => loadPerkembanganChart(perkembanganSelect.value));
            prediksiSelect.addEventListener('change', () => loadHasilPrediksiAwal(prediksiSelect.value));
            chartPolinomialSelect.addEventListener('change', () => loadPolinomialChart(chartPolinomialSelect
                .value));
        });
    </script>
    <style>
        .card-body::-webkit-scrollbar {
            width: 6px;
        }

        .card-body::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }
    </style>
@endsection
