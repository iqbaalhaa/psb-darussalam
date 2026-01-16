<!-- index.html -->
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Penerimaan Santri Baru MTs &amp; MA Pondok Pesantren DARUSSALAM AL-HAFIDZ, Kenali Asam Atas - Kota Jambi." />
    <meta name="wa-number-display" content="{{ optional(\App\Models\HomeSetting::first())->wa_number_display }}">
    <meta name="wa-number-e164" content="{{ optional(\App\Models\HomeSetting::first())->wa_number_e164 }}">
    <meta name="wa-default-text" content="{{ optional(\App\Models\HomeSetting::first())->wa_default_text }}">
    <title>PSB MTs &amp; MA — DARUSSALAM AL-HAFIDZ (Kota Jambi)</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Optional font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('landing/style.css') }}" />
</head>

<body>
    <a class="skip-link" href="#main">Lewati ke konten</a>

    <!-- Topbar -->
    <header class="topbar" id="top">
        <div class="container topbar__inner">
            <a class="brand" href="#top" aria-label="Beranda PSB">
                <div class="brand__mark" aria-hidden="true">۞</div>
                <div class="brand__text">
                    <div class="brand__name">DARUSSALAM AL-HAFIDZ</div>
                    <div class="brand__tagline">Penerimaan Santri Baru • MTs &amp; MA</div>
                </div>
            </a>

            <nav class="nav" aria-label="Navigasi utama">
                <button class="nav__toggle" type="button" aria-expanded="false" aria-controls="navMenu">
                    <span class="nav__toggleLines" aria-hidden="true"></span>
                    <span class="sr-only">Buka menu</span>
                </button>

                <div class="nav__menu" id="navMenu">
                    <a class="nav__link" href="#program">Program</a>
                    <a class="nav__link" href="#alur">Alur</a>
                    <a class="nav__link" href="#jadwal">Jadwal</a>
                    <a class="nav__link" href="#biaya">Biaya</a>
                    <a class="nav__link" href="#faq">FAQ</a>
                    <div class="nav__actions">
                        <a class="btn btn--ghost" href="#kontak">Konsultasi</a>
                        @auth
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn--primary">Keluar</button>
                            </form>
                        @else
                            <a class="btn btn--primary" href="#" data-modal="loginModal">Masuk/Daftar</a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main id="main">
        <!-- Hero -->
        <section class="hero" aria-label="Hero PSB">
            <div class="container hero__inner">
                <div class="hero__content">
                    <div class="badge">
                        <span class="badge__dot" aria-hidden="true"></span>
                        Penerimaan Santri Baru MTs &amp; MA • <strong>TA {{ $tahunAktif->nama ?? 'TBA' }}</strong> •
                        Gelombang <strong>1</strong> dibuka
                    </div>

                    @php
                        $homeSetting = \App\Models\HomeSetting::first();
                    @endphp
                    <h1>
                        {{ $homeSetting->hero_title ?? 'Menerima Santri Baru ' }}<span class="accent">MTs &amp; MA</span>
                    </h1>

                    <p class="lead">
                        {{ $homeSetting->hero_lead ?? 'Sekolah berkualitas dengan biaya terjangkau, menguatkan tahfidz, adab, dan prestasi santri MTs &amp; MA.' }}
                    </p>

                    <p class="muted">
                        {{ $homeSetting->hero_muted ?? 'Pondok Pesantren DARUSSALAM AL-HAFIDZ berlokasi di Kenali Asam Atas, Kota Jambi, dengan pembinaan harian, pengawasan ustadz/ustadzah, dan komunikasi rutin bersama wali santri.' }}
                    </p>

                    <div class="hero__cta">
                        <a class="btn btn--primary" href="#daftar">Daftar Sekarang</a>
                        @if ($homeSetting && $homeSetting->brochure_url)
                            <a class="btn btn--outline" href="{{ $homeSetting->brochure_url }}" target="_blank"
                                rel="noopener">Lihat Brosur Lengkap</a>
                        @else
                            <a class="btn btn--outline" href="#" target="_blank" rel="noopener">Lihat Brosur Lengkap</a>
                        @endif
                    </div>

                    <div class="chips" role="list" aria-label="Informasi ringkas">
                        <div class="chip" role="listitem">📍 Lokasi:
                            <strong>{{ $homeSetting->hero_chip_location ?? 'Kenali Asam Atas, Kota Jambi' }}</strong>
                        </div>
                        <div class="chip" role="listitem">🎓 Jenjang:
                            <strong>{{ $homeSetting->hero_chip_jenjang ?? 'MTs & MA' }}</strong>
                        </div>
                        <div class="chip" role="listitem">🏫 Program:
                            <strong>{{ $homeSetting->hero_chip_program ?? 'Formal & Non Formal' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="hero__media" aria-label="Foto kegiatan">
                    <div class="mediaCard">
                        @php
                            $homeSetting = $homeSetting ?? \App\Models\HomeSetting::first();
                        @endphp
                        <div class="mediaCard__image" role="img" aria-label="Foto santri belajar dan tahfidz"
                            @if ($homeSetting && $homeSetting->hero_image_path)
                                style="background-image: url('{{ asset($homeSetting->hero_image_path) }}'); background-size: cover; background-position: center;"
                            @endif
                        ></div>
                        <div class="mediaCard__caption">
                            <div class="mediaCard__captionTitle">Lingkungan belajar yang tertib & hangat</div>
                            <div class="mediaCard__captionText">Foto asli kegiatan • DARUSSALAM AL-HAFIDZ</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why -->
        <section class="section">
            <div class="container">
                <div class="section__head">
                    <h2>Mengapa memilih <span class="accent">DARUSSALAM AL-HAFIDZ</span>?</h2>
                    <p class="muted">Fokus pada pembinaan karakter, tahfidz, dan pendampingan belajar yang konsisten.
                    </p>
                </div>

                <div class="grid grid--bento">
                    <article class="card">
                        <h3>Pembinaan Adab & Ibadah</h3>
                        <p class="muted">Tertib ibadah, kedisiplinan, dan adab harian dibina secara berkelanjutan.</p>
                    </article>
                    <article class="card">
                        <h3>Tahfidz Bertahap</h3>
                        <p class="muted">Halaqah sesuai kemampuan, setoran dan murajaah terukur.</p>
                    </article>
                    <article class="card">
                        <h3>Bimbingan Akademik MA</h3>
                        <p class="muted">Pendampingan mapel inti dan kebiasaan belajar mandiri untuk jenjang MA.</p>
                    </article>
                    <article class="card">
                        <h3>Lingkungan Aman & Tertib</h3>
                        <p class="muted">Pengasuhan intensif, aturan jelas, dan budaya saling menjaga.</p>
                    </article>
                    <article class="card">
                        <h3>Pengembangan Diri</h3>
                        <p class="muted">Bahasa, kepemimpinan, public speaking, olahraga/ekskul.</p>
                    </article>
                    <article class="card">
                        <h3>Komunikasi Wali Santri</h3>
                        <p class="muted">Laporan rutin dan kanal konsultasi untuk wali santri.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Program -->
        <section class="section section--soft" id="program">
            <div class="container">
                <div class="section__head">
                    <h2>Visi, Misi &amp; Program Unggulan</h2>
                    <p class="muted">Ringkasan visi, misi, dan program unggulan MTs &amp; MA Pondok Pesantren
                        DARUSSALAM AL-HAFIDZ.</p>
                </div>

                <div class="tabs" data-tabs>
                    <div class="tabs__list" role="tablist" aria-label="Tab program">
                        <button class="tabs__tab is-active" role="tab" aria-selected="true"
                            aria-controls="tab-visi" id="visi">Visi</button>
                        <button class="tabs__tab" role="tab" aria-selected="false" aria-controls="tab-misi"
                            id="misi">Misi</button>
                        <button class="tabs__tab" role="tab" aria-selected="false" aria-controls="tab-unggulan"
                            id="unggulan">Program Unggulan</button>
                        <button class="tabs__tab" role="tab" aria-selected="false" aria-controls="tab-kami"
                            id="kami">Inilah Kami</button>
                    </div>

                    <div class="tabs__panels">
                        <div class="tabs__panel is-active" role="tabpanel" id="tab-visi" aria-labelledby="visi">
                            <div class="panelGrid">
                                <div class="card">
                                    <h3>Visi Madrasah</h3>
                                    <p class="muted">Membentuk generasi muslim yang berilmu, berakhlakul karimah,
                                        berdisiplin, dan bertakwa kepada Allah Subhanahu wa Ta’ala.</p>
                                </div>
                                <div class="card">
                                    <h3>Arah Pendidikan</h3>
                                    <p class="muted">Menjadikan MTs &amp; MA Darussalam Al Hafidz sebagai lembaga
                                        pendidikan berkualitas yang memadukan ilmu umum dan keislaman dalam suasana
                                        pesantren.</p>
                                </div>
                            </div>
                        </div>

                        <div class="tabs__panel" role="tabpanel" id="tab-misi" aria-labelledby="misi">
                            <div class="panelGrid">
                                <div class="card">
                                    <h3>Misi Madrasah</h3>
                                    <ul class="list">
                                        <li>Menyelenggarakan pendidikan yang berlandaskan Al-Qur’an dan As-Sunnah.</li>
                                        <li>Menanamkan akhlakul karimah dan kedisiplinan dalam kehidupan santri.</li>
                                        <li>Mengembangkan kemampuan akademik, tahfidz, dan keterampilan santri.</li>
                                        <li>Membiasakan suasana belajar yang islami, tertib, dan penuh kasih sayang.
                                        </li>
                                    </ul>
                                </div>
                                <div class="card">
                                    <h3>Target Lulusan</h3>
                                    <p class="muted">Lulusan diharapkan menjadi generasi yang berakidah lurus, mampu
                                        membaca dan menghafal Al-Qur’an dengan baik, serta siap melanjutkan pendidikan
                                        ke jenjang yang lebih tinggi.</p>
                                </div>
                            </div>
                        </div>

                        <div class="tabs__panel" role="tabpanel" id="tab-unggulan" aria-labelledby="unggulan">
                            <div class="panelGrid">
                                <div class="card">
                                    <h3>Program Unggulan</h3>
                                    <ul class="list">
                                        <li>Program Tahfidzul Qur’an.</li>
                                        <li>Program Madrasah Diniyah.</li>
                                        <li>Program penguatan bahasa Arab dan Inggris.</li>
                                        <li>Program pembinaan akhlak dan kedisiplinan santri.</li>
                                        <li>Program pengembangan minat bakat dan keterampilan.</li>
                                    </ul>
                                </div>
                                <div class="card">
                                    <h3>Kegiatan Penunjang</h3>
                                    <ul class="list">
                                        <li>Kegiatan keagamaan dan peringatan hari besar Islam.</li>
                                        <li>Latihan kepemimpinan, organisasi, dan kedisiplinan.</li>
                                        <li>Olahraga, seni, dan keterampilan lain yang bermanfaat.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tabs__panel" role="tabpanel" id="tab-kami" aria-labelledby="kami">
                            <div class="panelGrid">
                                <div class="card">
                                    <h3>Inilah Kami</h3>
                                    <ul class="list">
                                        <li>Sekolah yang menanamkan kejujuran dan tanggung jawab dunia-akhirat.</li>
                                        <li>Sekolah yang membudayakan kasih sayang dan persaudaraan.</li>
                                        <li>Sekolah yang membiasakan santri cinta Al-Qur’an.</li>
                                        <li>Sekolah yang menyiapkan generasi yang taat kepada Allah dan Rasul-Nya.</li>
                                    </ul>
                                </div>
                                <div class="card">
                                    <h3>Tagline</h3>
                                    <ul class="list">
                                        <li>Pondok Pesantren Darussalam Al Hafidz.</li>
                                        <li>Kenali Asam Atas – Kota Jambi.</li>
                                        <li>Sekolah berkualitas dengan biaya terjangkau.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- Alur -->
        <section class="section" id="alur">
            <div class="container">
                <div class="section__head">
                    <h2>Alur Pendaftaran</h2>
                    <p class="muted">Ringkas, jelas, dan bisa dibantu admin PSB jika ada kendala.</p>
                </div>

                <ol class="steps">
                    <li class="step">
                        <div class="step__num">1</div>
                        <div class="step__body">
                            <h3>Isi Formulir Online</h3>
                            <p class="muted">±2 menit. Data dasar calon santri & wali.</p>
                        </div>
                    </li>
                    <li class="step">
                        <div class="step__num">2</div>
                        <div class="step__body">
                            <h3>Upload Berkas</h3>
                            <p class="muted">KK, Akta, rapor, foto, dan lainnya (sesuai syarat).</p>
                        </div>
                    </li>
                    <li class="step">
                        <div class="step__num">3</div>
                        <div class="step__body">
                            <h3>Tes & Wawancara</h3>
                            <p class="muted">Baca Qur’an + wawancara wali (jadwal diinformasikan).</p>
                        </div>
                    </li>
                    <li class="step">
                        <div class="step__num">4</div>
                        <div class="step__body">
                            <h3>Pengumuman</h3>
                            <p class="muted">Hasil dikirim via WA/portal PSB.</p>
                        </div>
                    </li>
                    <li class="step">
                        <div class="step__num">5</div>
                        <div class="step__body">
                            <h3>Daftar Ulang</h3>
                            <p class="muted">Administrasi & pembagian perlengkapan (jika ada).</p>
                        </div>
                    </li>
                </ol>

                <div class="note">
                    <strong>Catatan:</strong> Jika berkas belum lengkap, admin akan menghubungi untuk membantu
                    melengkapi.
                </div>
            </div>
        </section>

        <!-- Jadwal -->
        <section class="section section--soft" id="jadwal">
            <div class="container">
                <div class="section__head">
                    <h2>Jadwal Seleksi & Gelombang</h2>
                    <p class="muted">Masih contoh. Nanti tinggal ganti tanggalnya.</p>
                </div>

                <div class="tableCard" role="region" aria-label="Tabel jadwal gelombang">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Gelombang</th>
                                <th>Pendaftaran</th>
                                <th>Tes</th>
                                <th>Pengumuman</th>
                                <th>Kuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="pill pill--primary">Gelombang 1</span></td>
                                <td>1 Feb – 15 Mar 2026</td>
                                <td>22 Mar 2026</td>
                                <td>25 Mar 2026</td>
                                <td><strong>30</strong></td>
                            </tr>
                            <tr>
                                <td><span class="pill">Gelombang 2</span></td>
                                <td>1 Apr – 15 Mei 2026</td>
                                <td>24 Mei 2026</td>
                                <td>27 Mei 2026</td>
                                <td><strong>30</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="note">
                    <strong>Kuota terbatas.</strong> Disarankan daftar lebih awal untuk memilih jadwal tes yang sesuai.
                </div>
            </div>
        </section>

        <!-- Biaya -->
        <section class="section" id="biaya">
            <div class="container">
                <div class="section__head">
                    <h2>Rincian Biaya Pendidikan</h2>
                    <p class="muted">Perkiraan biaya awal berdasarkan brosur PSB MTs &amp; MA Darussalam Al Hafidz,
                        terdiri dari program formal dan non formal.</p>
                </div>

                @php
                    $homeSetting = $homeSetting ?? \App\Models\HomeSetting::first();
                    $formalItems = $homeSetting && $homeSetting->biaya_formal_items
                        ? preg_split('/\r\n|\r|\n/', $homeSetting->biaya_formal_items)
                        : ['Pendaftaran.', 'Uang makan (maṣlahah bulanan).', 'Seragam (3 set gamis).', 'Perlengkapan asrama dan belajar.', 'Pos-pos lain sesuai kebijakan pesantren.'];
                    $nonformalItems = $homeSetting && $homeSetting->biaya_nonformal_items
                        ? preg_split('/\r\n|\r|\n/', $homeSetting->biaya_nonformal_items)
                        : ['Pendaftaran.', 'Uang makan (maṣlahah bulanan).', 'Seragam.', 'Perlengkapan asrama dan belajar.', 'Pos-pos lain sesuai kebijakan pesantren.'];
                @endphp

                <div class="grid grid--2">
                    <article class="priceCard">
                        <div class="priceCard__top">
                            <h3>Program Formal (MTs &amp; MA)</h3>
                            <div class="priceCard__price">
                                {{ $homeSetting->biaya_formal_total ?? 'Rp 5.500.000' }}</div>
                            <div class="priceCard__sub muted">Total biaya awal sesuai rincian pada brosur.</div>
                        </div>
                        <ul class="list">
                            @foreach ($formalItems as $item)
                                @if (trim($item) !== '')
                                    <li>{{ $item }}</li>
                                @endif
                            @endforeach
                        </ul>
                        <a class="btn btn--outline w-full" href="#kontak">Tanya rincian formal</a>
                    </article>

                    <article class="priceCard">
                        <div class="priceCard__top">
                            <h3>Program Non Formal</h3>
                            <div class="priceCard__price">
                                {{ $homeSetting->biaya_nonformal_total ?? 'Rp 4.350.000' }}</div>
                            <div class="priceCard__sub muted">Total biaya awal sesuai rincian pada brosur.</div>
                        </div>
                        <ul class="list">
                            @foreach ($nonformalItems as $item)
                                @if (trim($item) !== '')
                                    <li>{{ $item }}</li>
                                @endif
                            @endforeach
                        </ul>
                        <a class="btn btn--primary w-full" href="#daftar">Daftar program non formal</a>
                    </article>
                </div>

                <div class="beasiswa card">
                    <div class="beasiswa__left">
                        <h3>Beasiswa (Opsional)</h3>
                        <p class="muted">Jika ada beasiswa, tuliskan kategori dan syarat ringkas di sini.</p>
                    </div>
                    <div class="beasiswa__right">
                        <a class="btn btn--ghost" href="#faq">Lihat info</a>
                        <a class="btn btn--outline" href="#kontak">Ajukan</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Syarat -->
        <section class="section section--soft" id="syarat">
            <div class="container">
                <div class="section__head">
                    <h2>Syarat Pendaftaran</h2>
                    <p class="muted">Ringkasan syarat dan berkas pendaftaran sebagaimana tercantum pada brosur resmi.
                    </p>
                </div>

                <div class="grid grid--2">
                    <div class="card">
                        <h3>Syarat Umum</h3>
                        <ul class="checklist">
                            <li>Mengisi formulir pendaftaran santri baru.</li>
                            <li>Siap mengikuti tata tertib pondok pesantren.</li>
                            <li>Siap mengikuti kegiatan belajar mengajar dan kehidupan asrama.</li>
                            <li>Mengikuti tes seleksi dan wawancara sesuai jadwal.</li>
                        </ul>
                    </div>
                    <div class="card">
                        <h3>Berkas yang Dibutuhkan</h3>
                        <ul class="checklist">
                            <li>Fotokopi ijazah/STTB atau surat keterangan lulus (jika sudah tersedia).</li>
                            <li>Fotokopi raport terakhir.</li>
                            <li>Fotokopi Kartu Keluarga dan Akta Kelahiran.</li>
                            <li>Pas foto ukuran 3x4 (sesuai ketentuan brosur).</li>
                            <li>Surat keterangan sehat dari dokter/puskesmas (bila diperlukan).</li>
                        </ul>
                        <div class="card__actions">
                            <a class="btn btn--outline" href="#" target="_blank" rel="noopener">Unduh brosur / syarat
                                lengkap</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fasilitas -->
        {{-- <section class="section" id="fasilitas">
            <div class="container">
                <div class="section__head">
                    <h2>Fasilitas & Kehidupan Santri</h2>
                    <p class="muted">Tambah foto asli agar wali santri makin yakin.</p>
                </div>

                <div class="feature">
                    <div class="feature__media" aria-label="Foto fasilitas">
                        <div class="mediaCard mediaCard--plain">
                            <div class="mediaCard__image mediaCard__image--alt" role="img"
                                aria-label="Foto asrama atau masjid"></div>
                        </div>
                    </div>

                    <div class="feature__content">
                        <div class="card">
                            <h3>Fasilitas</h3>
                            <ul class="list">
                                <li>Masjid / mushalla</li>
                                <li>Asrama</li>
                                <li>Ruang kelas / halaqah</li>
                                <li>Perpustakaan</li>
                                <li>Lapangan / olahraga</li>
                                <li>UKS / klinik (opsional)</li>
                            </ul>
                        </div>

                        <div class="card">
                            <h3>Sehari di Pesantren (contoh)</h3>
                            <ul class="timeline">
                                <li><strong>Subuh</strong> — Shalat berjamaah & dzikir</li>
                                <li><strong>Pagi</strong> — Kelas MA</li>
                                <li><strong>Siang</strong> — Diniyah & istirahat</li>
                                <li><strong>Sore</strong> — Tahfidz & olahraga</li>
                                <li><strong>Malam</strong> — Murajaah & belajar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

        <!-- Testimoni -->
        {{-- <section class="section section--soft" id="testimoni">
            <div class="container">
                <div class="section__head">
                    <h2>Apa kata wali santri & alumni</h2>
                    <p class="muted">Ganti dengan testimoni asli jika sudah ada.</p>
                </div>

                <div class="grid grid--3">
                    <figure class="quote">
                        <blockquote>“Perkembangan adab dan disiplin anak terasa. Komunikasi dengan pengasuh juga jelas.”
                        </blockquote>
                        <figcaption>— <strong>Wali Santri</strong>, Kota Jambi</figcaption>
                    </figure>
                    <figure class="quote">
                        <blockquote>“Program tahfidz bertahap, jadi anak tidak merasa terbebani.”</blockquote>
                        <figcaption>— <strong>Wali Santri</strong>, Kota Jambi</figcaption>
                    </figure>
                    <figure class="quote">
                        <blockquote>“Lingkungan mendukung fokus belajar dan ibadah. Saya jadi lebih mandiri.”
                        </blockquote>
                        <figcaption>— <strong>Alumni</strong>, Angkatan [x]</figcaption>
                    </figure>
                </div>
            </div>
        </section> --}}

        <!-- Daftar -->
        <section class="section" id="daftar" aria-label="Form pendaftaran PSB">
            <div class="container">
                <div class="section__head">
                    <h2>Daftar Online (MA)</h2>
                    <p class="muted">Isi data dasar dulu. Setelah itu admin membantu langkah upload berkas & jadwal
                        tes.</p>
                </div>

                <div class="formWrap">
                    <form class="form card" id="psbForm" novalidate>
                        <div class="form__row">
                            <label class="field">
                                <span class="field__label">Nama Calon Santri</span>
                                <input class="field__input" name="nama" type="text" autocomplete="name"
                                    required placeholder="Mis. Ahmad Fulan" />
                                <span class="field__hint">Sesuai dokumen resmi.</span>
                            </label>

                            <label class="field">
                                <span class="field__label">Jenjang</span>
                                <select class="field__input" name="jenjang" required>
                                    <option value="MTS" selected>MTS</option>
                                    <option value="MA">MA</option>
                                </select>
                                <span class="field__hint">Jenjang yang dibuka: MA</span>
                            </label>
                        </div>

                        <div class="form__row">
                            <label class="field">
                                <span class="field__label">Email</span>
                                <input class="field__input" name="email" type="email" required
                                    placeholder="Mis. fulan@example.com" />
                            </label>

                            <label class="field">
                                <span class="field__label">Password</span>
                                <input class="field__input" name="password" type="password" required
                                    placeholder="Buat password untuk login" />
                                <span class="field__hint">Minimal 8 karakter.</span>
                            </label>
                        </div>

                        <div class="form__row">
                            <label class="field">
                                <span class="field__label">WhatsApp</span>
                                <input class="field__input" name="wa" type="tel" inputmode="tel" required
                                    placeholder="Contoh: 0812xxxxxxx" />
                                <span class="field__hint">Pastikan aktif untuk konfirmasi.</span>
                            </label>
                        </div>

                        <div class="form__actions">
                            <button class="btn btn--primary" type="submit">Kirim & Lanjut</button>
                            <button class="btn btn--ghost" type="button" id="btnPrefill">Isi contoh</button>
                        </div>

                        <div class="form__msg" id="formMsg" role="status" aria-live="polite"></div>
                    </form>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="section section--soft" id="faq">
            <div class="container">
                <div class="section__head">
                    <h2>FAQ</h2>
                    <p class="muted">Pertanyaan yang sering ditanyakan wali santri.</p>
                </div>

                <div class="accordion" data-accordion>
                    <div class="accItem">
                        <button class="accBtn" type="button" aria-expanded="false">
                            Apakah ada tes masuk?
                            <span class="accIcon" aria-hidden="true">+</span>
                        </button>
                        <div class="accPanel" hidden>
                            <p>Tes biasanya meliputi baca Qur’an dan wawancara wali (sesuaikan kebijakan pesantren).</p>
                        </div>
                    </div>

                    <div class="accItem">
                        <button class="accBtn" type="button" aria-expanded="false">
                            Bagaimana aturan membawa HP?
                            <span class="accIcon" aria-hidden="true">+</span>
                        </button>
                        <div class="accPanel" hidden>
                            <p>Umumnya ada aturan khusus. Tulis kebijakan resmi DARUSSALAM AL-HAFIDZ di sini nanti.</p>
                        </div>
                    </div>

                    <div class="accItem">
                        <button class="accBtn" type="button" aria-expanded="false">
                            Apakah tersedia beasiswa / cicilan?
                            <span class="accIcon" aria-hidden="true">+</span>
                        </button>
                        <div class="accPanel" hidden>
                            <p>Jika tersedia, tuliskan kategori beasiswa dan syarat ringkas. Jika cicilan ada, jelaskan
                                opsinya.</p>
                        </div>
                    </div>

                    <div class="accItem">
                        <button class="accBtn" type="button" aria-expanded="false">
                            Jika anak belum lancar baca Qur’an, apakah bisa?
                            <span class="accIcon" aria-hidden="true">+</span>
                        </button>
                        <div class="accPanel" hidden>
                            <p>Bisa (jika kebijakan memungkinkan). Jelaskan program penguatan baca Qur’an/leveling.</p>
                        </div>
                    </div>

                    <div class="accItem">
                        <button class="accBtn" type="button" aria-expanded="false">
                            Jadwal kunjungan wali santri kapan?
                            <span class="accIcon" aria-hidden="true">+</span>
                        </button>
                        <div class="accPanel" hidden>
                            <p>Tuliskan jadwal kunjungan atau sistem komunikasi yang berlaku.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Closing CTA -->
        <section class="closing" id="kontak">
            <div class="container closing__inner">
                <div>
                    <h2>Siap mendaftarkan putra Anda?</h2>
                    <p class="muted">Isi formulir sekarang, admin PSB DARUSSALAM AL-HAFIDZ akan membantu hingga
                        tuntas.</p>
                </div>
                <div class="closing__actions">
                    <a class="btn btn--primary" href="#daftar">Daftar Sekarang</a>
                    <a class="btn btn--outline" id="btnWaClosing" href="#" target="_blank"
                        rel="noopener">Konsultasi WhatsApp</a>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container footer__grid">
            <div>
                <div class="footer__brand">
                    <div class="brand__mark" aria-hidden="true">۞</div>
                    <div>
                        <div class="footer__title">DARUSSALAM AL-HAFIDZ</div>
                        <div class="muted">Sistem Penerimaan Santri Baru • MA</div>
                    </div>
                </div>
                <p class="muted footer__addr">
                    Kota Jambi, Jambi<br>
                    Jam layanan: 08.00–16.00 WIB
                </p>
            </div>

            <div>
                <div class="footer__title">Kontak</div>
                <ul class="footer__list">
                    <li>WhatsApp: <a class="link" href="#" id="footerWa">0812-3456-7890</a></li>
                    <li>Telepon: <a class="link" href="tel:+62741000000">+62 741 000000</a></li>
                    <li>Email: <a class="link"
                            href="mailto:psb@darussalamalhafidz.sch.id">psb@darussalamalhafidz.sch.id</a></li>
                </ul>
            </div>

            <div>
                <div class="footer__title">Tautan</div>
                <ul class="footer__list">
                    <li><a class="link" href="#" target="_blank" rel="noopener">Brosur</a></li>
                    <li><a class="link" href="#syarat">Syarat & Berkas</a></li>
                    <li><a class="link" href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>

        <div class="container footer__bottom">
            <div class="muted">© <span id="year"></span> DARUSSALAM AL-HAFIDZ. All rights reserved.</div>
            <a class="toTop" href="#top">Kembali ke atas ↑</a>
        </div>
    </footer>

    <!-- Floating WhatsApp -->
    <a class="waFloat" id="waFloat" href="#" target="_blank" rel="noopener"
        aria-label="Chat WhatsApp Admin PSB">
        <span aria-hidden="true">💬</span>
    </a>

    <!-- Sticky CTA for mobile -->
    <div class="stickyCta" id="stickyCta" aria-label="Aksi cepat">
        <a class="stickyCta__btn stickyCta__btn--ghost" id="btnWaSticky" href="#" target="_blank"
            rel="noopener">WhatsApp</a>
        <a class="stickyCta__btn stickyCta__btn--primary" href="#daftar">Daftar</a>
    </div>

    <script src="{{ asset('landing/script.js') }}"></script>
    <!-- Login Modal -->
    <div id="loginModal" class="modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-close="loginModal"></div>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="loginTitle">
            <header class="modal__header">
                <h2 id="loginTitle" class="modal__title">Masuk</h2>
                <button class="modal__close" type="button" aria-label="Tutup modal"
                    data-close="loginModal">×</button>
            </header>
            <div class="modal__content">
                <form class="form" action="{{ route('login.public') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div
                            style="background: rgba(200,162,77,0.14); padding: 10px; border-radius: 8px; margin-bottom: 1rem; color: #856404; font-size: 0.9rem;">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label class="field">
                            <span class="field__label">Email / Username</span>
                            <input class="field__input" name="email" type="text" required
                                placeholder="Masukkan email atau username" />
                        </label>
                        <label class="field">
                            <span class="field__label">Password</span>
                            <input class="field__input" name="password" type="password" required
                                placeholder="Masukkan password" />
                        </label>
                    </div>
                    <div class="form__actions" style="margin-top: 1.5rem;">
                        <button class="btn btn--primary w-full" type="submit">Masuk</button>
                    </div>
                </form>
                <div style="margin-top: 1rem; text-align: center; font-size: 0.9rem; color: var(--muted);">
                    Belum punya akun? <a href="#daftar" class="accent" data-close="loginModal">Daftar sekarang</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
