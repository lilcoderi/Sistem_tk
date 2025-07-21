<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>TK MARHAMAH HASANAH 2</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

            <a href="#hero" class="logo d-flex align-items-center me-auto me-xl-0">
                <img src="{{ asset('assets/img/logo_name.png') }}" alt="">
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Beranda</a></li>
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#services">Aktivitas</a></li>
                    <li><a href="#pendaftaran">Pendaftaran</a></li>
                    <li><a href="#pricing">Biaya</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('login') }}">Login</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <img src="{{ asset('assets/img/marhas.jpg') }}" alt="" data-aos="fade-in">

            <div class="container">
                <div class="row">
                    <div class="col-lg-10">
                        <h2 data-aos="fade-up" data-aos-delay="100">TK Marhamah Hasanah 2</h2>
                        <p data-aos="fade-up" data-aos-delay="200">Membentuk peserta didik yang berakhlak mulia, cerdas,
                            mandiri,</p>
                        <p data-aos="fade-up" data-aos-delay="200"> berwawasan lingkungan, dan berkebinekaan global</p>
                    </div>
                    <div class="col-lg-5" data-aos="fade-up" data-aos-delay="300">
                        <div class="sign-up-form">
                            <a href="{{ route('register') }}" class="btn btn-getstarted">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tentang Section -->
        <section id="tentang" class="features section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Tentang</h2>
                <p>Sejarah, Visi dan Misi</p>
            </div>

            <div class="container">
                <div class="row gy-4 align-items-center features-item">
                    <div class="col-lg-5 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                        <h3>Sejarah TK Marhamah Hasanah 2</h3>
                        <p>
                            TK Marhamah Hasanah 2 awalnya bernama TK Asri 2 dan merupakan pelopor pendidikan anak usia
                            dini di kawasan Permata Kopo sejak tahun 2000. Karena pengelolaan sebelumnya terkendala
                            jarak dengan yayasan di Antapani, kepemilikan TK kemudian dialihkan. Pada tahun 2016,
                            yayasan Marhamah Hasanah resmi mengambil alih dan mengganti namanya menjadi TK Marhamah
                            Hasanah 2, yang kini menjadi bagian dari jaringan pendidikan yang lebih besar dan
                            terintegrasi
                        </p>
                    </div>
                    <div class="col-lg-7 order-1 order-lg-2 d-flex align-items-center" data-aos="zoom-out"
                        data-aos-delay="100">
                        <div class="image-stack">
                            <img src="{{ asset('assets/img/features-light-1.jpg') }}" alt=""
                                class="stack-front">
                            <img src="{{ asset('assets/img/features-light-2.jpg') }}" alt=""
                                class="stack-back">
                        </div>
                    </div>
                </div>

                <div class="row gy-4 align-items-stretch justify-content-between features-item">
                    <div class="col-lg-6 d-flex align-items-center features-img-bg" data-aos="zoom-out">
                        <img src="{{ asset('assets/img/features-light-3.jpg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-5 d-flex justify-content-center flex-column" data-aos="fade-up">
                        <h3>Visi dan Misi</h3>
                        <p>
                            Membentuk peserta didik yang berakhlak mulia, cerdas, mandiri, kreatif, berwawasan
                            lingkungan, dan berkebinekaan global.
                        </p>
                        <ul>
                            <li><i class="bi bi-check"></i> <span>Menanamkan akhlak mulia melalui kegiatan keagamaan
                                    harian.</span></li>
                            <li><i class="bi bi-check"></i><span>Meningkatkan pengetahuan dan kecerdasan anak secara
                                    menyenangkan.</span></li>
                            <li><i class="bi bi-check"></i> <span>Membentuk kemandirian lewat pembiasaan
                                    positif.</span>.</li>
                            <li><i class="bi bi-check"></i> <span>Mengembangkan kreativitas melalui aktivitas tematik
                                    dan edukatif.</span>.</li>
                            <li><i class="bi bi-check"></i> <span>Menumbuhkan kepedulian lingkungan dari potensi
                                    lokal.</span>.</li>
                            <li><i class="bi bi-check"></i> <span>Menanamkan toleransi dan cinta keberagaman sejak
                                    dini.</span>.</li>
                        </ul>
                        <a href="#contact" class="btn btn-get-started align-self-start">Kontak Kami</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Aktivitas Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Intrakulikuler & Ekstrakulikuler</h2>
                <p>Pengembangkan capaian pembelajaran sebagai fase fondasi siswa dan mengenalkan siswa pada berbagai
                    bidang keterampilan</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6 " data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-moon-stars"></i></div>
                            <div>
                                <h4 class="title">Nilai Agama dan Budi Pekerti serta Jati Diri</h4>
                                <p class="description">Membentuk karakter anak melalui pembelajaran nilai-nilai agama,
                                    akhlak mulia, dan penguatan jati diri.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Item -->

                    <div class="col-lg-6 " data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-award"></i></div>
                            <div>
                                <h4 class="title">Dasar-Dasar Literasi, Matematika, Sains, Teknologi,
                                    Rekayasa dan Seni</h4>
                                <p class="description">Mengembangkan kemampuan dasar anak dalam literasi, numerasi, dan
                                    eksplorasi sains serta kreativitas secara terpadu.</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-6 " data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-music-note-list"></i></div>
                            <div>
                                <h4 class="title">Musik Angklung</h4>
                                <p class="description">Melatih kepekaan musikal dan kerja sama anak melalui permainan
                                    alat musik tradisional angklung.</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-6 " data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-music-note-beamed"></i></div>
                            <div>
                                <h4 class="title">Drumband</h4>
                                <p class="description">Menumbuhkan disiplin, kekompakan, dan ritme motorik melalui
                                    latihan memainkan alat musik drumband.</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-6 " data-aos="fade-up" data-aos-delay="500">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-palette"></i></div>
                            <div>
                                <h4 class="title">Mewarnai dan Melukis</h4>
                                <p class="description">Menstimulasi imajinasi dan ekspresi diri anak melalui aktivitas
                                    menggambar dan mewarnai.</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-6 " data-aos="fade-up" data-aos-delay="600">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-person-walking"></i></div>
                            <div>
                                <h4 class="title">Menari</h4>
                                <p class="description">Mengembangkan motorik, ekspresi seni, dan rasa percaya diri anak
                                    melalui gerakan tari yang menyenangkan.</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->


        <!-- Pendaftaran Section -->
        <section id="pendaftaran" class="faq section">

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="content px-xl-5">
                            <h3><span>Prosedur </span><strong>Pendaftaran</strong></h3>
                            <p>
                                Langkah - langkah pendaftaran online TK Marhamah Hasanah 2 adalah sebagai berikut:
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">

                        <div class="faq-container">
                            <div class="faq-item faq-active">
                                <h3><span class="num">1.</span> <span>Membuat Akun Baru untuk Melakukan
                                        Pendaftaran</span></h3>
                                <div class="faq-content">
                                    <p>Calon orang tua siswa perlu membuat akun baru melalui halaman pendaftaran. Akun
                                        ini digunakan untuk mengakses dan memantau proses pendaftaran, asesmen, dan
                                        rapor anak.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3><span class="num">2.</span> <span>Mengisi Folmulir Data Calon Siswa secara
                                        Online </span></h3>
                                <div class="faq-content">
                                    <p>Setelah akun dibuat, pengguna diminta mengisi formulir dengan data lengkap calon
                                        siswa dan sebagainya. Pastikan semua informasi diisi dengan benar untuk
                                        kelancaran proses
                                        verifikasi.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3><span class="num">3.</span> <span>Mengirimkan Dokumen Persyaratan Pendaftaran
                                        secara Online</span></h3>
                                <div class="faq-content">
                                    <p>Unggah dokumen seperti akta kelahiran, KTP orang tua, dan kartu keluarga sesuai
                                        ketentuan. Semua dokumen dikirim melalui sistem untuk diverifikasi oleh kepala
                                        sekolah.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3><span class="num">4.</span> <span>Melakukan Pembayaran via Transfer dan
                                        Mengirimkan Bukti Pembayaran</span></h3>
                                <div class="faq-content">
                                    <p>Unggah dokumen seperti akta kelahiran, KTP orang tua, dan kartu keluarga sesuai
                                        ketentuan. Semua dokumen dikirim melalui sistem untuk diverifikasi oleh panitia.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3><span class="num">5.</span> <span>Menunggu Konfirmasi Pembayaran
                                        Pendaftaran</span></h3>
                                <div class="faq-content">
                                    <p>Unggah dokumen seperti akta kelahiran, KTP orang tua, dan kartu keluarga sesuai
                                        ketentuan. Semua dokumen dikirim melalui sistem untuk diverifikasi oleh kepala
                                        sekolah.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>

                    </div>
                </div>

            </div>

        </section><!-- /Faq Section -->


        <!-- Pricing Section -->
        <section id="pricing" class="pricing section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Biaya Sekolah</h2>
                <p>Informasi Biaya dan Pendaftaran TK Marhamah Hasanah 2</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="zoom-in" data-aos-delay="100">

                <div class="row g-4 justify-content-center">
                    <div class="col-lg-4 text-center">
                        <div class="pricing-item">
                            <h3>Biaya Pendaftaran </h3>
                            <div class="icon">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <h4><sup>Rp</sup>325.000<span> / Pendaftaran</span></h4>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Biaya Pendaftaran Rp. 150.000</span></li>
                                <li><i class="bi bi-check"></i> <span>Biaya Psikotes Rp. 175.000</span></li>
                                <li><i class="bi bi-check"></i> <span>Usia anak minimal 4 tahun</span></li>
                            </ul>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-4 text-center">
                        <div class="pricing-item">
                            <h3>Biaya Administrasi Pendidikan </h3>
                            <div class="icon">
                                <i class="bi bi-bank"></i>
                            </div>
                            <h4><sup>Rp</sup>2.770.000<span> / Tahun</span></h4>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Seragam 5 Stel Rp. 800.000</span></li>
                                <li><i class="bi bi-check"></i> <span>ATK 1 Tahun Rp. 400.000</span></li>
                                <li><i class="bi bi-check"></i> <span>Buku Paket 1 Tahun Rp. 300.000</span></li>
                                <li><i class="bi bi-check"></i> <span>Ekstrakulikuler 1 Tahun Rp. 300.000</span></li>
                                <li><i class="bi bi-check"></i> <span>Dana Pengembang Sekolah Rp. 750.000</span></li>
                                <li><i class="bi bi-check"></i> <span>SPP Rp. 220.000 / Bulan</span></li>
                            </ul>
                        </div>
                    </div><!-- End Pricing Item -->
                </div>

            </div>

        </section><!-- /Pricing Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak</h2>
                <p>Jika terdapat kendala, hubungi kontak ini (a. n. Kepala Sekolah)</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-6">

                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="200">
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>Alamat</h3>
                                    <p>K.Permata Kopo Blok DA 31A/B, Kab. Bandung </p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="300">
                                    <i class="bi bi-telephone"></i>
                                    <h3>Telepon</h3>
                                    <p>+62 819 1031 9272</p>
                                    <p>+62 877 1056 3882</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="400">
                                    <i class="bi bi-envelope"></i>
                                    <h3>Email Kami</h3>
                                    <p>tkmarhas2@gmail.com</p>
                                    <p>hartono@gmail.com</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="500">
                                    <i class="bi bi-clock"></i>
                                    <h3>Jam Buka</h3>
                                    <p>Senin - jumat</p>
                                    <p>08.00 - 14.00</p>
                                </div>
                            </div><!-- End Info Item -->

                        </div>

                    </div>

                    <div class="col-lg-6">
                        <form action="" method="POST" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            @csrf
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Nama Anda" required>
                                </div>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Email Anda" required>
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subjek"
                                        required>
                                </div>

                                <div class="col-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Pesan" required></textarea>
                                </div>

                                <div class="col-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Pesan kamu sudah terkirim. Terima Kasih!</div>

                                    <button type="submit">Kirim Pesan</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>

    <footer id="footer" class="footer position-relative light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                        <img src="{{ asset('assets/img/logo_name.png') }}" alt="Logo TK Marhamah Hasanah 2">
                    </a>
                    <p>
                        TK Marhamah Hasanah 2 bertujuan membentuk anak yang berakhlak mulia, cerdas, mandiri, dan peduli
                        lingkungan. Nilai keagamaan, kreativitas, dan toleransi ditanamkan melalui pembelajaran yang
                        menyenangkan. Semua kegiatan dirancang untuk menumbuhkan karakter dan kecerdasan sejak dini.
                    </p>
                    <div class="social-links d-flex mt-4">
                        <a href="#"><i class="bi bi-envelope"></i></a>
                        <a href="#"><i class="bi bi-whatsapp"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Tentang Kami</h4>
                    <ul>
                        <li><a href="#hero">Beranda</a></li>
                        <li><a href="#tentang">Tentang</a></li>
                        <li><a href="#services">Aktivitas</a></li>
                        <li><a href="#pendaftaran">Pendaftaran</a></li>
                        <li><a href="#pricing">Biaya</a></li>
                        <li><a href="#contact">Kontak</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Kontak Kami</h4>
                    <p>K.Permata Kopo Blok DA 31A/B</p>
                    <p>Kec. Margahayu, Kab. Bandung</p>
                    <p>Indonesia</p>
                    <p class="mt-4"><strong>Phone:</strong> <span>+62 819 1031 9272</span></p>
                    <p><strong>Email:</strong> <span>tkmarhas2@gmail.com</span></p>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="sitename">TK Marhamah Hasanah 2</strong> <span>All Rights
                    Reserved | 2025</span></p>
            <div class="credits">
                Developed by <a href="#">Hartono</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader"></div>



    <!-- Tambahkan script JS di bagian bawah sebelum </body> jika perlu -->
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>


</body>

</html>
