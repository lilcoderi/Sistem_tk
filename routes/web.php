<?php

use App\Models\KegiatanTK;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\IdentitasAnakController;
use App\Http\Controllers\OrangtuaController;
use App\Http\Controllers\KondisiAnakController;
use App\Http\Controllers\KeadaanJasmaniController;
use App\Http\Controllers\DokumenPersyaratanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\KonfirmasiPembayaranController;
use App\Http\Controllers\TematkController;
use App\Http\Controllers\LingkupPerkembanganController;
use App\Http\Controllers\TingkatPencapaianController;
use App\Http\Controllers\ModulAjarController;
use App\Http\Controllers\SubtemaController;
use App\Http\Controllers\PenilaianSiswaController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\DetailAsesmenController;
use App\Http\Controllers\KegiatanTKController;
use App\Http\Controllers\FotoKegiatanController;
use App\Http\Controllers\SistemPrediksiAwalController;
use App\Http\Controllers\HasilAsesmenController;
use App\Http\Controllers\SistemPakarController;
use App\Http\Controllers\AsesmenAnekdotController;
use App\Http\Controllers\TumbuhKembangController;
use App\Http\Controllers\DdtkController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\NotifikasiOrangTuaController;
use App\Http\Controllers\NotifikasiKepsekController;
use App\Http\Controllers\DashboardSekolahController;
use App\Http\Controllers\KurikulumController; // Impor KurikulumController



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Login routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Register routes (middleware guest)
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Routes that require authentication & email verification
Route::middleware(['auth', 'verified'])->group(function () {

    // Profile routes (optional)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/view', [ProfileController::class, 'view'])->name('profile.view');


    // Default dashboard route — redirect sesuai role supaya tidak error Route [dashboard] not defined
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->hasRole('kepala sekolah')) {
            return redirect()->route('kepala_sekolah.dashboard');
        }

        if ($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard');
        }

        if ($user->hasRole('orang tua')) {
            return redirect()->route('orang_tua.dashboard');
        }

        // Jika user tidak ada role yang cocok, redirect ke home atau logout
        return redirect('/');
    })->name('dashboard');

    // Dashboard untuk kepala sekolah
    Route::prefix('kepala-sekolah')->middleware('role:kepala sekolah')->group(function () {
        Route::get('/dashboard', function () {
            return view('kepala_sekolah.dashboard');
        })->name('kepala_sekolah.dashboard');
    });

    // Dashboard untuk guru
    Route::prefix('guru')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', function () {
            return view('kepala_sekolah.dashboard');
        })->name('guru.dashboard');
    });

    // Dashboard untuk orang tua
    Route::prefix('orang-tua')->middleware('role:orang tua')->group(function () {
        Route::get('/dashboard', function () {
            return view('orang_tua.dashboard');
        })->name('orang_tua.dashboard');
    });

    // Pendaftaran Identitas Anak
    Route::middleware(['auth'])->group(function () {
        Route::get('/identitas-anak/{id_pendaftaran}', [IdentitasAnakController::class, 'formIdentitasAnak'])->name('form.identitas_anak');
        Route::post('/identitas-anak/{id_pendaftaran}', [IdentitasAnakController::class, 'simpanIdentitasAnak'])->name('simpan.identitas_anak');

        Route::get('/identitas-orangtua/{id_pendaftaran}', [OrangtuaController::class, 'create'])->name('orangtua.create');
        Route::post('/identitas-orangtua/{id_pendaftaran}', [OrangtuaController::class, 'store'])->name('orangtua.store');

        Route::get('/keadaan-anak/{id_pendaftaran}', [KondisiAnakController::class, 'create'])->name('keadaan_anak.create');
        Route::post('/keadaan-anak/{id_pendaftaran}', [KondisiAnakController::class, 'store'])->name('keadaan_anak.store');
    
        Route::get('/keadaan-jasmani/{id_pendaftaran}', [KeadaanJasmaniController::class, 'create'])->name('keadaan_jasmani.create');
        Route::post('/keadaan-jasmani/{id_pendaftaran}', [KeadaanJasmaniController::class, 'store'])->name('keadaan_jasmani.store');

        Route::get('/dokumen/{id_pendaftaran}', [DokumenPersyaratanController::class, 'create'])->name('dokumen.create');
        Route::post('/dokumen/{id_pendaftaran}', [DokumenPersyaratanController::class, 'store'])->name('dokumen.store');

        Route::get('/pembayaran/{id_pendaftaran}', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/pembayaran/{id_pendaftaran}', [PembayaranController::class, 'store'])->name('pembayaran.store');

        Route::get('/orang-tua/pembayaran', [PembayaranController::class, 'riwayatOrangtua'])->name('orangtua.pembayaran.index');


    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/user', [UserRoleController::class, 'index'])->name('user.index');
        Route::get('/user/{user}/edit', [UserRoleController::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}', [UserRoleController::class, 'update'])->name('user.update');
        Route::delete('/user/{user}', [UserRoleController::class, 'destroy'])->name('user.destroy');
        Route::post('/user', [UserRoleController::class, 'store'])->name('user.store');
        Route::get('/user/create', [UserRoleController::class, 'create'])->name('user.create');
        Route::get('/get-user/{id}', [UserRoleController::class, 'getUser'])->name('user.get');

    });

    Route::prefix('guru')->middleware(['auth', 'role:kepala sekolah'])->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('guru.index');
        Route::get('/create', [GuruController::class, 'create'])->name('guru.create');
        Route::post('/store', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/{guru}/edit', [GuruController::class, 'edit'])->name('guru.edit');
        Route::put('/{guru}', [GuruController::class, 'update'])->name('guru.update');
        Route::delete('/{guru}', [GuruController::class, 'destroy'])->name('guru.destroy');
        Route::get('/{guru}', [GuruController::class, 'detail'])->name('guru.detail');
    });

    Route::get('/data-siswa', [DataSiswaController::class, 'index'])->name('data-siswa.index');
    Route::get('/data-siswa/create', [DataSiswaController::class, 'create'])->name('data-siswa.create');
    Route::post('/data-siswa', [DataSiswaController::class, 'store'])->name('data-siswa.store');
    Route::get('/data-siswa/{id}/edit', [DataSiswaController::class, 'edit'])->name('data-siswa.edit');
    Route::put('/data-siswa/{id}', [DataSiswaController::class, 'update'])->name('data-siswa.update');
    Route::delete('/data-siswa/{id}', [DataSiswaController::class, 'destroy'])->name('data-siswa.destroy');
    Route::get('/data-siswa/{id}', [DataSiswaController::class, 'show'])->name('data-siswa.show');

    
    Route::get('/profil-siswa', [DataSiswaController::class, 'profilSiswaOrangtua'])->name('profil-siswa.orangtua');
    // Edit & Update untuk orangtua
    Route::get('/profil-orangtua/{id}/edit', [DataSiswaController::class, 'editProfilOrangtua'])->name('profil-orangtua.edit');
    Route::put('/profil-orangtua/{id}', [DataSiswaController::class, 'updateProfilOrangtua'])->name('profil-orangtua.update');
    // Edit & Update untuk anak
    Route::get('/profil-anak/{id}/edit', [DataSiswaController::class, 'editProfilAnak'])->name('profil-anak.edit');
    Route::put('/profil-anak/{id}', [DataSiswaController::class, 'updateProfilAnak'])->name('profil-anak.update');
    




    Route::get('/konfirmasi-pembayaran', [KonfirmasiPembayaranController::class, 'index'])->name('konfirmasi-pembayaran.index');
    Route::get('/konfirmasi-pembayaran/{id}', [KonfirmasiPembayaranController::class, 'show'])->name('konfirmasi-pembayaran.show');
    Route::get('/konfirmasi-pembayaran/{id}/edit', [KonfirmasiPembayaranController::class, 'edit'])->name('konfirmasi-pembayaran.edit');
    Route::post('/konfirmasi-pembayaran/{id}', [KonfirmasiPembayaranController::class, 'update'])->name('konfirmasi-pembayaran.update');

    Route::get('/tematk', [TematkController::class, 'index'])->name('tematk.index');
    Route::get('/tematk/create', [TematkController::class, 'create'])->name('tematk.create');
    Route::post('/tematk/store', [TematkController::class, 'store'])->name('tematk.store');
    Route::get('/tematk/{id}', [TematkController::class, 'show'])->name('tematk.show');
    Route::get('/tematk/{id}/edit', [TematkController::class, 'edit'])->name('tematk.edit');
    Route::put('/tematk/{id}/update', [TematkController::class, 'update'])->name('tematk.update');
    Route::delete('/tematk/{id}/delete', [TematkController::class, 'destroy'])->name('tematk.destroy');

    Route::get('/subtema', [SubtemaController::class, 'index'])->name('subtema.index');          // List semua subtema
    Route::get('/subtema/create', [SubtemaController::class, 'create'])->name('subtema.create'); // Form tambah subtema
    Route::post('/subtema', [SubtemaController::class, 'store'])->name('subtema.store');         // Simpan subtema baru
    Route::get('/subtema/{subtema}', [SubtemaController::class, 'show'])->name('subtema.show'); // Detail subtema
    Route::get('/subtema/{subtema}/edit', [SubtemaController::class, 'edit'])->name('subtema.edit');   // Form edit subtema
    Route::put('/subtema/{subtema}', [SubtemaController::class, 'update'])->name('subtema.update');
    Route::delete('/subtema/{subtema}', [SubtemaController::class, 'destroy'])->name('subtema.destroy'); // Hapus subtema

    Route::get('/lingkup-perkembangan', [LingkupPerkembanganController::class, 'index'])->name('lingkup.index');
    Route::get('/lingkup-perkembangan/create', [LingkupPerkembanganController::class, 'create'])->name('lingkup.create');
    Route::post('/lingkup-perkembangan', [LingkupPerkembanganController::class, 'store'])->name('lingkup.store');
    Route::get('/lingkup-perkembangan/{id}/edit', [LingkupPerkembanganController::class, 'edit'])->name('lingkup.edit');
    Route::put('/lingkup-perkembangan/{id}', [LingkupPerkembanganController::class, 'update'])->name('lingkup.update');
    Route::delete('/lingkup-perkembangan/{id}', [LingkupPerkembanganController::class, 'destroy'])->name('lingkup.destroy');
    Route::get('lingkup/{id}', [LingkupPerkembanganController::class, 'show'])->name('lingkup.show');

    Route::get('/modul-ajar/create-step1', [ModulAjarController::class, 'createStep1'])->name('modulAjar.createStep1');
    Route::post('/modul-ajar/create-step2', [ModulAjarController::class, 'createStep2'])->name('modulAjar.createStep2');
    Route::post('/modul-ajar/store', [ModulAjarController::class, 'store'])->name('modulAjar.store');
    Route::get('/modul-ajar', [ModulAjarController::class, 'index'])->name('modulAjar.index');
    Route::get('/modul-ajar/edit/{id}', [ModulAjarController::class, 'edit'])->name('modulAjar.edit');
    Route::put('/modul-ajar/update/{id}', [ModulAjarController::class, 'update'])->name('modulAjar.update');
    Route::delete('/modul-ajar/delete/{id}', [ModulAjarController::class, 'destroy'])->name('modulAjar.delete');

    // Asesmen
    Route::get('/asesmen', [AsesmenController::class, 'index'])->name('asesmen.index');
    Route::get('/asesmen/create', [AsesmenController::class, 'create'])->name('asesmen.create');
    Route::post('/asesmen', [AsesmenController::class, 'store'])->name('asesmen.store');
    Route::get('/asesmen/{id}/edit', [AsesmenController::class, 'edit'])->name('asesmen.edit');
    Route::put('/asesmen/{id}', [AsesmenController::class, 'update'])->name('asesmen.update');
    Route::delete('/asesmen/{id}', [AsesmenController::class, 'destroy'])->name('asesmen.destroy');

    //Penilaian
    Route::get('/detail-asesmen/{id_siswa}', [DetailAsesmenController::class, 'index'])->name('detail-asesmen.index');
    Route::get('/detail-asesmen/{id_siswa}/create', [DetailAsesmenController::class, 'create'])->name('detail-asesmen.create');
    Route::post('/detail-asesmen', [DetailAsesmenController::class, 'store'])->name('detail-asesmen.store');
    Route::get('/detail-asesmen/{id}/edit', [DetailAsesmenController::class, 'edit'])->name('detail-asesmen.edit');
    Route::put('/detail-asesmen/{id}', [DetailAsesmenController::class, 'update'])->name('detail-asesmen.update');
    Route::delete('/detail-asesmen/{id}', [DetailAsesmenController::class, 'destroy'])->name('detail-asesmen.destroy');
    Route::get('/detail-asesmen/{id_asesmen}/show', [DetailAsesmenController::class, 'show'])->name('detail-asesmen.show');

    Route::get('/get-subtema/{tema_id}', function ($tema_id) {
        $subtemas = \App\Models\Subtema::where('tema_id', $tema_id)->get();
        return response()->json($subtemas);
    });


    Route::get('/api/kegiatan', function () {
        $kegiatan = KegiatanTK::select('judul as title', 'tanggal as start', 'id')->get();
        return response()->json($kegiatan);
    });

    Route::get('/kegiatan/calendar', [KegiatanTKController::class, 'calendar'])->name('kegiatan.calendar');
    Route::get('/kalender-anak', [KegiatanTKController::class, 'calendarOrangtua'])->name('kalender.orangtua');
    Route::get('/kegiatan/create', [KegiatanTKController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan/store', [KegiatanTKController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{id}/edit', [KegiatanTKController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/kegiatan/{id}', [KegiatanTKController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [KegiatanTKController::class, 'destroy'])->name('kegiatan.destroy');
    Route::get('/api/kegiatan', [KegiatanTKController::class, 'apiEvents']);

    Route::get('/fotokegiatan', [FotoKegiatanController::class, 'index'])->name('fotokegiatan.index');
    Route::get('/fotokegiatan/create', [FotoKegiatanController::class, 'create'])->name('fotokegiatan.create');
    Route::post('/fotokegiatan/store', [FotoKegiatanController::class, 'store'])->name('fotokegiatan.store');
    Route::delete('/fotokegiatan/{id}/delete', [FotoKegiatanController::class, 'destroy'])->name('fotokegiatan.destroy');
    Route::get('/fotokegiatan/{id}/edit', [FotoKegiatanController::class, 'edit'])->name('fotokegiatan.edit');
    Route::put('/fotokegiatan/{id}', [FotoKegiatanController::class, 'update'])->name('fotokegiatan.update');
    Route::delete('/fotokegiatan/{id}/delete-group', [FotoKegiatanController::class, 'deleteGroup'])->name('fotokegiatan.deleteGroup');
    Route::get('/fotokegiatan/{id}/detail', [FotoKegiatanController::class, 'show'])->name('fotokegiatan.show');




    Route::get('/asesmen-anekdot', [AsesmenAnekdotController::class, 'index'])->name('asesmen.anekdot.index');
    Route::get('/asesmen-anekdot/create', [AsesmenAnekdotController::class, 'create'])->name('asesmen.anekdot.create');
    Route::post('/asesmen-anekdot', [AsesmenAnekdotController::class, 'store'])->name('asesmen.anekdot.store');
    Route::get('/asesmen-anekdot/{id}', [AsesmenAnekdotController::class, 'show'])->name('asesmen.anekdot.show');
    Route::get('/asesmen-anekdot/{id}/edit', [AsesmenAnekdotController::class, 'edit'])->name('asesmen.anekdot.edit');
    Route::put('/asesmen-anekdot/{id}', [AsesmenAnekdotController::class, 'update'])->name('asesmen.anekdot.update');
    Route::delete('/asesmen-anekdot/{id}', [AsesmenAnekdotController::class, 'destroy'])->name('asesmen.anekdot.destroy');
    Route::get('/profil-anak/asesmen-anekdot', [AsesmenAnekdotController::class, 'profilAnekdotOrangtua'])->name('profil-anak.anekdot.orangtua');

    
        // Hasil Asesmen
    Route::get('/hasil-asesmen', [HasilAsesmenController::class, 'index'])->name('hasil-asesmen.index');
    Route::get('/hasil-asesmen/{id_asesmen}', [HasilAsesmenController::class, 'show'])->name('hasil-asesmen.show');


    Route::get('/prediksi-awal/{id_siswa}', [SistemPrediksiAwalController::class, 'jalankanSistemPakar'])->name('prediksi.awal.jalankan');
    Route::get('/sistem-pakar/jalankan/{id}', [SistemPakarController::class, 'jalankan'])->name('sistem-pakar.jalankan');


    Route::get('/tumbuh-kembang', [TumbuhKembangController::class, 'index'])->name('tumbuh_kembang.index');
    Route::get('/tumbuh-kembang/create', [TumbuhKembangController::class, 'create'])->name('tumbuh_kembang.create');
    Route::post('/tumbuh-kembang/store', [TumbuhKembangController::class, 'store'])->name('tumbuh_kembang.store');
    Route::get('/tumbuh-kembang/{id}/edit', [TumbuhKembangController::class, 'edit'])->name('tumbuh_kembang.edit');
    Route::post('/tumbuh-kembang/{id}/update', [TumbuhKembangController::class, 'update'])->name('tumbuh_kembang.update');
    Route::delete('/tumbuh-kembang/{id}/delete', [TumbuhKembangController::class, 'destroy'])->name('tumbuh_kembang.destroy');



    Route::get('/ddtk', [DdtkController::class, 'index'])->name('ddtk.index');
    Route::get('/ddtk/jalankan/{id}', [DdtkController::class, 'jalankan'])->name('ddtk.jalankan');
    Route::get('/ddtk/{id}', [DdtkController::class, 'show'])->name('ddtk.show');


    Route::get('/rapor', [RaporController::class, 'index'])->name('rapor.index');
    Route::get('/rapor/show/{id_siswa}', [RaporController::class, 'show'])->name('rapor.show');
    Route::get('/rapor/cetak/{id_siswa}', [RaporController::class, 'generateRapor'])->name('rapor.cetak');
    Route::get('/rapor/generate/{id_siswa}', [RaporController::class, 'generateOpenAI'])->name('rapor.generate');
    Route::get('/orangtua/rapor', [RaporController::class, 'raporOrangTua'])->name('orangtua.rapor.index');



    Route::prefix('notifikasi-orangtua')->middleware(['auth'])->group(function () {
        Route::get('/', [NotifikasiOrangTuaController::class, 'index'])->name('notifikasi.orangtua.index');
        Route::get('/unread-count', [NotifikasiOrangTuaController::class, 'countUnread']);
        Route::post('/mark-as-read/{id}', [NotifikasiOrangTuaController::class, 'markAsRead'])->name('notifikasi.orangtua.read');
        Route::post('/mark-all-as-read', [NotifikasiOrangTuaController::class, 'markAllAsRead'])->name('notifikasi.orangtua.read.all');
    });

    Route::prefix('kepsek/notifikasi')->middleware(['auth', 'role:kepala sekolah'])->group(function () {
        Route::get('/', [NotifikasiKepsekController::class, 'index'])->name('notifikasi.kepsek.index');
        Route::post('/mark-all', [NotifikasiKepsekController::class, 'markAllAsRead'])->name('notifikasi.kepsek.read.all');
        Route::post('/mark/{id}', [NotifikasiKepsekController::class, 'markAsRead'])->name('notifikasi.kepsek.read');
    });

Route::get('/guru/dashboard', [DashboardSekolahController::class, 'dashboard'])->name('guru.dashboard');
Route::get('/kepala-sekolah/dashboard', [DashboardSekolahController::class, 'dashboard'])->name('kepala_sekolah.dashboard');
Route::get('/dashboard-sekolah/asesmen-chart/{id_siswa}', [DashboardSekolahController::class, 'getAsesmenChartData']);
Route::get('/dashboard-sekolah/angkatan-distribusi', [DashboardSekolahController::class, 'angkatanDistribusi']);
Route::get('/dashboard-sekolah/perkembangan-chart/{id}', [DashboardSekolahController::class, 'chartPerkembangan']);
Route::get('/dashboard-sekolah/hasil-prediksi-awal/{id_siswa}', [DashboardSekolahController::class, 'getHasilPrediksiAwal']);
Route::get('/dashboard-sekolah/chart-polinomial/{id_siswa}', [DashboardSekolahController::class, 'chartPolinomial']);
Route::get('/kepala-sekolah/dashboard', [DashboardSekolahController::class, 'tampilanddtk'])->name('kepala_sekolah.dashboard');
Route::get('/dashboard-sekolah/statistik', [DashboardSekolahController::class, 'dataStatistikSekolah']);



Route::resource('kurikulum', KurikulumController::class)->names('kurikulum');



});
require __DIR__.'/auth.php';