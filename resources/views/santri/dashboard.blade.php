<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Santri - PSB Darussalam</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('landing/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/dashboard.css') }}"> {{-- tambahkan ini --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<style>
    /* modal */
    /* Overlay Modal */
    .modal-overlay, .modal {
        display: none;
        /* Tersembunyi secara default */
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        overflow-y: auto;
    }

    .modal.is-open {
        display: block;
    }

    /* Kotak Modal */
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 24px;
        border-radius: 8px;
        width: 90%;
        max-width: 450px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .close-btn {
        font-size: 28px;
        cursor: pointer;
        color: #888;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        font-weight: bold;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    /* Utility Button (opsional jika belum ada di CSS Anda) */
    .btn--primary {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn--secondary {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<body class="dash">

    @session('success')
        <script>
            alert("Berhasil merubah password");
        </script>
    @endsession

    @session('successLengkapiBerkas')
        <script>
            alert("Berhasil melengkapi data");
        </script>
    @endsession

    <a class="skip-link" href="#main">Lewati ke konten</a>

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="topbar__inner container">
            <div class="brand">
                <div class="brand__mark">PSB</div>
                <div>
                    <div class="brand__name">PSB DARUSSALAM</div>
                    <div class="brand__tagline">Dashboard Calon Santri Baru</div>
                </div>
            </div>

            <div class="dashTopbarRight">
                <div class="dashUser">
                    <div class="dashUser__avatar" aria-hidden="true">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="dashUser__meta">
                        <div class="dashUser__hello">Assalamu’alaikum</div>
                        <div class="dashUser__name">{{ Auth::user()->name }}</div>
                    </div>
                </div>

                <div class="dashActions">
                    {{-- opsional: arahkan ke halaman ubah password --}}

                    <button id="openModalBtn" class="btn btn--outline dashBtnSm">Ubah Password</button>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn--primary dashBtnSm">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- BACKDROP -->
    <div class="dashBackdrop" aria-hidden="true"></div>

    <main id="main" class="dashWrap container">
        <!-- Alerts -->
        @if (session('success'))
            <div class="dashAlert dashAlert--success" role="status" aria-live="polite">
                <div class="dashAlert__icon">✓</div>
                <div class="dashAlert__content">{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="dashAlert dashAlert--error" role="alert" aria-live="assertive">
                <div class="dashAlert__icon">!</div>
                <div class="dashAlert__content">
                    <div class="dashAlert__title">Ada yang perlu diperbaiki:</div>
                    <ul class="dashAlert__list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Header Card -->
        <section class="dashHeaderCard">
            <div class="dashHeaderCard__left">
                <div class="dashKicker">Nomor Pendaftaran</div>
                <div class="dashReg">
                    REG-{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}
                </div>

                <div class="dashStatusRow">
                    <span class="dashStatusPill dashStatusPill--{{ $registration->status }}">
                        @if ($registration->status == 'pending')
                            Menunggu Verifikasi
                        @elseif($registration->status == 'incomplete_file')
                            Berkas Belum Lengkap
                        @elseif($registration->status == 'accept')
                            Diterima
                        @else
                            Ditolak
                        @endif
                    </span>

                    <div class="dashProgress">
                        <div class="dashProgress__top">
                            <div class="dashProgress__title">Kelengkapan Data</div>
                            <div class="dashProgress__pct"><span id="dashPct">0</span>%</div>
                        </div>

                        <div class="dashProgress__bar" aria-label="Progress kelengkapan">
                            <div class="dashProgress__fill" id="dashFill" style="width:0%"></div>
                        </div>

                        <div class="dashProgress__hint" id="dashProgressHint">
                            Lengkapi biodata & upload berkas untuk mempercepat verifikasi.
                        </div>
                    </div>

                    <span class="dashHint">
                        Lengkapi biodata & upload berkas untuk mempercepat verifikasi.
                    </span>

                    @if ($registration->keterangan)
                        <span class="dashHint">Keterangan dari Admin: {{ $registration->keterangan }}</span>
                    @endif
                </div>
            </div>

            <div class="dashHeaderCard__right">
                <div class="dashStepsMini">
                    <div class="dashStepsMini__item is-done">
                        <span class="dashStepsMini__dot">✓</span>
                        <span>Daftar Akun</span>
                    </div>
                    <div class="dashStepsMini__item is-active">
                        <span class="dashStepsMini__dot">2</span>
                        <span>Lengkapi Data</span>
                    </div>
                    <div class="dashStepsMini__item">
                        <span class="dashStepsMini__dot">3</span>
                        <span>Verifikasi</span>
                    </div>
                    <div class="dashStepsMini__item">
                        <span class="dashStepsMini__dot">4</span>
                        <span>Pengumuman</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Form Card -->
        <section class="dashCard">
            <div class="dashCard__head">
                <div>
                    <h1 class="dashTitle">Lengkapi Data Santri</h1>
                    <p class="dashSubtitle">Pastikan data sesuai dokumen agar verifikasi lancar.</p>
                </div>
                <div class="dashMetaNote">
                    <span class="dashMetaNote__badge">PDF/JPG/PNG</span>
                    <span class="dashMetaNote__badge">Maks 2MB/berkas</span>
                </div>
            </div>

            <form class="dashForm" action="{{ route('santri.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Tabs / Steps -->
                <div class="tabs" data-tabs>
                    <div class="tabs__list" role="tablist" aria-label="Tahapan pengisian">
                        <button type="button" class="tabs__tab is-active" role="tab" aria-selected="true"
                            aria-controls="tab-pribadi">
                            Data Pribadi
                        </button>
                        <button type="button" class="tabs__tab" role="tab" aria-selected="false"
                            aria-controls="tab-wali" tabindex="-1">
                            Orang Tua / Wali
                        </button>
                        <button type="button" class="tabs__tab" role="tab" aria-selected="false"
                            aria-controls="tab-berkas" tabindex="-1">
                            Upload Berkas
                        </button>
                    </div>

                    <fieldset style="border:none; padding:0; margin:0;"
                        {{ $registration->is_locked ? 'disabled' : '' }}>
                        <div class="tabs__panels">
                            <!-- Panel: Data Pribadi -->
                            <section id="tab-pribadi" class="tabs__panel is-active" role="tabpanel">
                                <div class="dashGrid">
                                    <label class="field">
                                        <span class="field__label">Nama Lengkap</span>
                                        <input type="text" class="field__input is-readonly"
                                            value="{{ $registration->nama }}" disabled>
                                        <span class="field__hint">Nama dari pendaftaran awal (tidak bisa
                                            diubah).</span>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">NISN</span>
                                        <input id="nisn" type="text" name="nisn" class="field__input"
                                            value="{{ old('nisn', $registration->nisn) }}" required
                                            inputmode="numeric" autocomplete="off" data-required="1" minlength="10"
                                            maxlength="10" data-rule="nisn" placeholder="10 digit angka">
                                        <div class="dashError" data-error-for="nisn"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">NIK</span>
                                        <input id="nik" type="text" name="nik" class="field__input"
                                            value="{{ old('nik', $registration->nik) }}" required inputmode="numeric"
                                            autocomplete="off" data-required="1" minlength="16" maxlength="16"
                                            data-rule="nik" placeholder="16 digit angka">
                                        <div class="dashError" data-error-for="nik"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Tempat Lahir</span>
                                        <input id="tempat_lahir" type="text" name="tempat_lahir"
                                            class="field__input"
                                            value="{{ old('tempat_lahir', $registration->tempat_lahir) }}" required
                                            data-required="1" placeholder="Contoh: Jambi">
                                        <div class="dashError" data-error-for="tempat_lahir"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Tanggal Lahir</span>
                                        <input id="tanggal_lahir" type="date" name="tanggal_lahir"
                                            class="field__input"
                                            value="{{ old('tanggal_lahir', $registration->tanggal_lahir) }}" required
                                            data-required="1" data-rule="dob">
                                        <div class="dashError" data-error-for="tanggal_lahir"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Jenis Kelamin</span>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="field__input" required
                                            data-required="1">
                                            <option value="">Pilih...</option>
                                            <option value="L"
                                                {{ old('jenis_kelamin', $registration->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="P"
                                                {{ old('jenis_kelamin', $registration->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        <div class="dashError" data-error-for="jenis_kelamin"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Alamat Lengkap</span>
                                        <textarea id="alamat" name="alamat" class="field__input dashTextarea" required data-required="1"
                                            placeholder="Tulis alamat lengkap sesuai KK">{{ old('alamat', $registration->alamat) }}</textarea>
                                        <div class="dashError" data-error-for="alamat"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Asal Sekolah</span>
                                        <input id="asal_sekolah" type="text" name="asal_sekolah"
                                            class="field__input"
                                            value="{{ old('asal_sekolah', $registration->asal_sekolah) }}" required
                                            data-required="1" placeholder="Contoh: MTsN 1 Jambi">
                                        <div class="dashError" data-error-for="asal_sekolah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Anak Ke</span>
                                        <input id="anak_ke" type="number" name="anak_ke" class="field__input"
                                            value="{{ old('anak_ke', $registration->anak_ke) }}" required
                                            data-required="1" placeholder="Contoh: 1">
                                        <div class="dashError" data-error-for="anak_ke"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Jumlah Saudara</span>
                                        <input id="jumlah_saudara" type="number" name="jumlah_saudara"
                                            class="field__input"
                                            value="{{ old('jumlah_saudara', $registration->jumlah_saudara) }}"
                                            required data-required="1" placeholder="Contoh: 1">
                                        <div class="dashError" data-error-for="jumlah_saudara"></div>
                                    </label>

                                </div>

                                <div class="dashPanelActions">
                                    <button type="button" class="btn btn--ghost" data-next-tab="tab-wali">Lanjut:
                                        Orang Tua/Wali →</button>
                                </div>
                            </section>

                            <!-- Panel: Orang Tua / Wali -->
                            {{-- ========================= Data Ayah ================================= --}}
                            <section id="tab-wali" class="tabs__panel" role="tabpanel">
                                <div class="dashGrid">
                                    <label class="field">
                                        <span class="field__label">No KK (Kartu Keluarga)</span>
                                        <input id="no_kk" type="text" name="no_kk" class="field__input"
                                            value="{{ old('no_kk', $registration->no_kk) }}" required
                                            data-required="1" maxlength="16" minlength="16">
                                        <div class="dashError" data-error-for="no_kk"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">NIK Ayah</span>
                                        <input id="nik_ayah" type="text" name="nik_ayah" class="field__input"
                                            value="{{ old('nik_ayah', $registration->nik_ayah) }}" required
                                            data-required="1" maxlength="16" minlength="16">
                                        <div class="dashError" data-error-for="nik_ayah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Nama Ayah</span>
                                        <input id="nama_ayah" type="text" name="nama_ayah" class="field__input"
                                            value="{{ old('nama_ayah', $registration->nama_ayah) }}" required
                                            data-required="1" maxlength="250">
                                        <div class="dashError" data-error-for="nama_ayah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Tanggal Lahir Ayah</span>
                                        <input id="tanggal_lahir_ayah" type="date" name="tanggal_lahir_ayah"
                                            class="field__input"
                                            value="{{ old('tanggal_lahir_ayah', $registration->tanggal_lahir_ayah) }}"
                                            required data-required="1">
                                        <div class="dashError" data-error-for="tanggal_lahir_ayah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Umur Ayah</span>
                                        <input id="umur_ayah" type="number" name="umur_ayah" class="field__input"
                                            value="{{ old('umur_ayah', $registration->umur_ayah) }}" min="1"
                                            required data-required="1" maxlength="250">
                                        <div class="dashError" data-error-for="umur_ayah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Tempat Lahir Ayah</span>
                                        <input id="tempat_lahir_ayah" type="string" name="tempat_lahir_ayah"
                                            class="field__input"
                                            value="{{ old('tempat_lahir_ayah', $registration->tempat_lahir_ayah) }}"
                                            min="1" required data-required="1" maxlength="250">
                                        <div class="dashError" data-error-for="umur_ayah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Jenjang Pendidikan Ayah</span>
                                        <select id="pendidikan_terakhir_ayah" name="pendidikan_terakhir_ayah"
                                            class="field__input" required data-required="1">
                                            <option value="" disabled
                                                {{ old('pendidikan_terakhir_ayah', $registration->pendidikan_terakhir_ayah) == '' ? 'selected' : '' }}>
                                                Pilih Pendidikan</option>
                                            <option value="SD"
                                                {{ old('pendidikan_terakhir_ayah', $registration->pendidikan_terakhir_ayah) == 'SD' ? 'selected' : '' }}>
                                                SD / Sederajat</option>
                                            <option value="SMP"
                                                {{ old('pendidikan_terakhir_ayah', $registration->pendidikan_terakhir_ayah) == 'SMP' ? 'selected' : '' }}>
                                                SMP / Sederajat</option>
                                            <option value="SMA"
                                                {{ old('pendidikan_terakhir_ayah', $registration->pendidikan_terakhir_ayah) == 'SMA' ? 'selected' : '' }}>
                                                SMA / SMK / Sederajat</option>
                                            <option value="D3"
                                                {{ old('pendidikan_terakhir_ayah', $registration->pendidikan_terakhir_ayah) == 'D3' ? 'selected' : '' }}>
                                                Diploma 3 (D3)</option>
                                            <option value="S1"
                                                {{ old('pendidikan_terakhir_ayah', $registration->pendidikan_terakhir_ayah) == 'S1' ? 'selected' : '' }}>
                                                Sarjana (S1)</option>
                                            <option value="S2"
                                                {{ old('pendidikan_terakhir_ayah', $registration->pendidikan_terakhir_ayah) == 'S2' ? 'selected' : '' }}>
                                                Magister (S2)</option>
                                            <option value="S3"
                                                {{ old('pendidikan_terakhir_ayah', $registration->pendidikan_terakhir_ayah) == 'S3' ? 'selected' : '' }}>
                                                Doktor (S3)</option>
                                            <option value="Tidak Sekolah"
                                                {{ old('pendidikan_terakhir_ayah', $registration->pendidikan_terakhir_ayah) == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                Tidak Sekolah</option>
                                        </select>
                                        <div class="dashError" data-error-for="pendidikan_terakhir_ayah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Alamat Lengkap Ayah</span>
                                        <input id="alamat_lengkap_ayah" type="text" name="alamat_lengkap_ayah"
                                            class="field__input"
                                            value="{{ old('alamat_lengkap_ayah', $registration->alamat_lengkap_ayah) }}"
                                            maxlength="250" required data-required="1">
                                        <div class="dashError" data-error-for="alamat_lengkap_ayah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">No. HP/(WA) Ayah</span>
                                        <input id="no_hp_ayah" type="text" name="no_hp_ayah" class="field__input"
                                            value="{{ old('no_hp_ayah', $registration->no_hp_ayah) }}" required
                                            data-required="1" maxlength="15" data-rule="wa" inputmode="tel"
                                            placeholder="Contoh: 08xxxxxxxxxx">
                                        <span class="field__hint">Boleh format 08… / 62… / +62…</span>
                                        <div class="dashError" data-error-for="no_hp_ayah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Pekerjaan Ayah</span>
                                        <input id="pekerjaan_ayah" type="text" name="pekerjaan_ayah"
                                            class="field__input"
                                            value="{{ old('pekerjaan_ayah', $registration->pekerjaan_ayah) }}"
                                            required data-required="1" maxlength="250"
                                            placeholder="Contoh: Wirausaha">
                                        <div class="dashError" data-error-for="pekerjaan_ayah"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Kode Pos</span>
                                        <input id="kode_pos" type="text" name="kode_pos" class="field__input"
                                            value="{{ old('kode_pos', $registration->kode_pos) }}" required
                                            data-required="1" maxlength="5" placeholder="Contoh: 12345">
                                        <div class="dashError" data-error-for="kode_pos"></div>
                                    </label>

                                    {{-- ========================= Data Ibu ============================================== --}}

                                    <label class="field">
                                        <span class="field__label">NIK Ibu</span>
                                        <input id="nik_ibu" type="text" name="nik_ibu" class="field__input"
                                            value="{{ old('nik_ibu', $registration->nik_ibu) }}" required
                                            data-required="1" maxlength="16" minlength="16">
                                        <div class="dashError" data-error-for="nik_ibu"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Nama Ibu</span>
                                        <input id="nama_ibu" type="text" name="nama_ibu" class="field__input"
                                            value="{{ old('nama_ibu', $registration->nama_ibu) }}" required
                                            data-required="1" maxlength="250">
                                        <div class="dashError" data-error-for="nama_ibu"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Tanggal Lahir Ibu</span>
                                        <input id="tanggal_lahir_ibu" type="date" name="tanggal_lahir_ibu"
                                            class="field__input"
                                            value="{{ old('tanggal_lahir_ibu', $registration->tanggal_lahir_ibu) }}"
                                            min="1" required data-required="1">
                                        <div class="dashError" data-error-for="tanggal_lahir_ibu"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Umur Ibu</span>
                                        <input id="umur_ibu" type="number" name="umur_ibu" class="field__input"
                                            value="{{ old('umur_ibu', $registration->umur_ibu) }}" min="1"
                                            required data-required="1" maxlength="250">
                                        <div class="dashError" data-error-for="umur_ibu"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Tempat Lahir Ibu</span>
                                        <input id="tempat_lahir_ibu" type="text" name="tempat_lahir_ibu"
                                            class="field__input"
                                            value="{{ old('tempat_lahir_ibu', $registration->tempat_lahir_ibu) }}"
                                            min="1" required data-required="1" maxlength="250">
                                        <div class="dashError" data-error-for="tempat_lahir_ibu"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Jenjang Pendidikan Ibu</span>
                                        <select id="pendidikan_terakhir_ibu" name="pendidikan_terakhir_ibu"
                                            class="field__input" required data-required="1">
                                            <option value="" disabled
                                                {{ old('pendidikan_terakhir_ibu', $registration->pendidikan_terakhir_ibu) == '' ? 'selected' : '' }}>
                                                Pilih Pendidikan</option>
                                            <option value="SD"
                                                {{ old('pendidikan_terakhir_ibu', $registration->pendidikan_terakhir_ibu) == 'SD' ? 'selected' : '' }}>
                                                SD / Sederajat</option>
                                            <option value="SMP"
                                                {{ old('pendidikan_terakhir_ibu', $registration->pendidikan_terakhir_ibu) == 'SMP' ? 'selected' : '' }}>
                                                SMP / Sederajat</option>
                                            <option value="SMA"
                                                {{ old('pendidikan_terakhir_ibu', $registration->pendidikan_terakhir_ibu) == 'SMA' ? 'selected' : '' }}>
                                                SMA / SMK / Sederajat</option>
                                            <option value="D3"
                                                {{ old('pendidikan_terakhir_ibu', $registration->pendidikan_terakhir_ibu) == 'D3' ? 'selected' : '' }}>
                                                Diploma 3 (D3)</option>
                                            <option value="S1"
                                                {{ old('pendidikan_terakhir_ibu', $registration->pendidikan_terakhir_ibu) == 'S1' ? 'selected' : '' }}>
                                                Sarjana (S1)</option>
                                            <option value="S2"
                                                {{ old('pendidikan_terakhir_ibu', $registration->pendidikan_terakhir_ibu) == 'S2' ? 'selected' : '' }}>
                                                Magister (S2)</option>
                                            <option value="S3"
                                                {{ old('pendidikan_terakhir_ibu', $registration->pendidikan_terakhir_ibu) == 'S3' ? 'selected' : '' }}>
                                                Doktor (S3)</option>
                                            <option value="Tidak Sekolah"
                                                {{ old('pendidikan_terakhir_ibu', $registration->pendidikan_terakhir_ibu) == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                Tidak Sekolah</option>
                                        </select>
                                        <div class="dashError" data-error-for="pendidikan_terakhir_ibu"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Alamat Lengkap Ibu</span>
                                        <input id="alamat_lengkap_ibu" type="text" name="alamat_lengkap_ibu"
                                            class="field__input"
                                            value="{{ old('alamat_lengkap_ibu', $registration->alamat_lengkap_ibu) }}"
                                            maxlength="250" required data-required="1">
                                        <div class="dashError" data-error-for="alamat_lengkap_ibu"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Pekerjaan Ibu</span>
                                        <input id="pekerjaan_ibu" type="text" name="pekerjaan_ibu"
                                            class="field__input"
                                            value="{{ old('pekerjaan_ibu', $registration->pekerjaan_ibu) }}" required
                                            data-required="1" maxlength="250" placeholder="Contoh: Wirausaha">
                                        <div class="dashError" data-error-for="pekerjaan_ibu"></div>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">No. HP/(WA) Ibu</span>
                                        <input id="no_hp_ibu" type="text" name="no_hp_ibu" class="field__input"
                                            value="{{ old('no_hp_ibu', $registration->no_hp_ibu) }}" required
                                            data-required="1" maxlength="15" data-rule="wa" inputmode="tel"
                                            placeholder="Contoh: 08xxxxxxxxxx">
                                        <span class="field__hint">Boleh format 08… / 62… / +62…</span>
                                        <div class="dashError" data-error-for="no_hp_ibu"></div>
                                    </label>

                                </div>

                                <div class="dashPanelActions dashPanelActions--between">
                                    <button type="button" class="btn btn--outline" data-prev-tab="tab-pribadi">←
                                        Kembali</button>
                                    <button type="button" class="btn btn--ghost" data-next-tab="tab-berkas">Lanjut:
                                        Upload Berkas →</button>
                                </div>
                            </section>

                            {{-- UBAH KODINGAN DIBAWAH INI  --}}
                            <!-- Panel: Upload Berkas -->
                            <section id="tab-berkas" class="tabs__panel" role="tabpanel">
                                <div class="dashUploadGrid">

                                    <!-- File Biodata -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas Biodata</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-biodata">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-biodata">
                                                    Belum
                                                    ada
                                                    file</div>
                                            </div>
                                        </label>
                                        <input id="file-biodata" type="file" name="file_biodata"
                                            class="dashFileInput" accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_biodata ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-biodata"></div>

                                        @if ($registration->file_biodata)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_biodata) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File Rapor -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas Raport</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-rapor">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-rapor">Belum
                                                    ada
                                                    file</div>
                                            </div>
                                        </label>
                                        <input id="file-rapor" type="file" name="file_rapor"
                                            class="dashFileInput" accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_rapor ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-rapor"></div>

                                        @if ($registration->file_rapor)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_rapor) }}"
                                                    target="_blank">Lihat</a>accept
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File Ijazah -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas Ijazah</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-ijazah">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-ijazah">
                                                    Belum
                                                    ada
                                                    file</div>
                                            </div>
                                        </label>
                                        <input id="file-ijazah" type="file" name="file_ijazah"
                                            class="dashFileInput" accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_ijazah ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-ijazah"></div>

                                        @if ($registration->file_ijazah)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_ijazah) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File SKL -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas SKL (Surat Keterangan Lulus
                                                jika
                                                ada)</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-skl">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-skl">Belum
                                                    ada
                                                    file</div>
                                            </div>
                                        </label>
                                        <input id="file-skl" type="file" name="file_skl" class="dashFileInput"
                                            accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_skl ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-skl"></div>

                                        @if ($registration->file_skl)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_skl) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File Akta Kelahiran -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas Akta Kelahiran</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-akta-kelahiran">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-akta-kelahiran">
                                                    Belum
                                                    ada
                                                    file</div>
                                            </div>
                                        </label>
                                        <input id="file-akta-kelahiran" type="file" name="file_akta_kelahiran"
                                            class="dashFileInput" accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_akta_kelahiran ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-akta-kelahiran"></div>

                                        @if ($registration->file_akta_kelahiran)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_akta_kelahiran) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File KK -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas Kartu Keluarga (KK)</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-kk">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-kk">
                                                    Belum
                                                    ada
                                                    file</div>
                                            </div>
                                        </label>
                                        <input id="file-kk" type="file" name="file_kk" class="dashFileInput"
                                            accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_kk ? '1' : '0' }}" data-max-mb="2">
                                        <div class="dashError" data-error-for="file-kk"></div>

                                        @if ($registration->file_kk)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_kk) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File Pas Foto -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Pas Foto (Ukuran 3x2)</div>
                                            <div class="dashUploadCard__meta">Image • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-pas-foto">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-pas-foto">
                                                    Belum
                                                    ada
                                                    file
                                                </div>
                                            </div>
                                        </label>
                                        <input id="file-pas-foto" type="file" name="file_pas_foto"
                                            class="dashFileInput" accept="image/*" data-required-file="1"
                                            data-existing="{{ $registration->file_pas_foto ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-kk"></div>

                                        @if ($registration->file_pas_foto)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_pas_foto) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File KTP Ayah -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas KTP Ayah</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-ktp-ayah">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-ktp-ayah">
                                                    Belum
                                                    ada
                                                    file
                                                </div>
                                            </div>
                                        </label>
                                        <input id="file-ktp-ayah" type="file" name="file_ktp_ayah"
                                            class="dashFileInput" accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_ktp_ayah ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-kk"></div>

                                        @if ($registration->file_ktp_ayah)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_ktp_ayah) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File KTP Ibu -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas KTP Ibu</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-ktp-ibu">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-ktp-ibu">
                                                    Belum
                                                    ada
                                                    file
                                                </div>
                                            </div>
                                        </label>
                                        <input id="file-ktp-ibu" type="file" name="file_ktp_ibu"
                                            class="dashFileInput" accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_ktp_ibu ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-kk"></div>

                                        @if ($registration->file_ktp_ibu)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_ktp_ibu) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File KIP -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas PKH/KIP/KIS (Jika ada)</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-kip">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload</div>
                                                <div class="dashDropzone__muted" data-file-name="file-kip">
                                                    Belum
                                                    ada
                                                    file
                                                </div>
                                            </div>
                                        </label>
                                        <input id="file-kip" type="file" name="file_kip" class="dashFileInput"
                                            accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_kip ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-kk"></div>

                                        @if ($registration->file_kip)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_kip) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File Bpjs -->
                                    <div class="dashUploadCard">
                                        <div class="dashUploadCard__head">
                                            <div class="dashUploadCard__title">Berkas BPJS</div>
                                            <div class="dashUploadCard__meta">PDF • maks 2MB</div>
                                        </div>

                                        <label class="dashDropzone" for="file-bpjs">
                                            <div class="dashDropzone__icon">⬆</div>
                                            <div class="dashDropzone__text">
                                                <div class="dashDropzone__strong">Klik untuk upload
                                                </div>
                                                <div class="dashDropzone__muted" data-file-name="file-bpjs">
                                                    Belum
                                                    ada
                                                    file</div>
                                            </div>
                                        </label>
                                        <input id="file-bpjs" type="file" name="file_bpjs" class="dashFileInput"
                                            accept=".pdf" data-required-file="1"
                                            data-existing="{{ $registration->file_bpjs ? '1' : '0' }}"
                                            data-max-mb="2">
                                        <div class="dashError" data-error-for="file-kk"></div>

                                        @if ($registration->file_bpjs)
                                            <div class="dashUploaded">
                                                <span class="dashUploaded__badge">Sudah diupload</span>
                                                <a class="link"
                                                    href="{{ asset('Berkas/' . $registration->file_bpjs) }}"
                                                    target="_blank">Lihat</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="dashPanelActions dashPanelActions--between">
                                    <button type="button" class="btn btn--outline" data-prev-tab="tab-wali">←
                                        Kembali</button>
                                    <button type="submit" class="btn btn--primary dashBtnSave">
                                        Simpan & Perbarui Data
                                    </button>
                                </div>

                                <div class="dashFootHint">
                                    Dengan menekan “Simpan”, Anda menyatakan data yang diisi benar sesuai
                                    dokumen.
                                </div>
                            </section>
                        </div>
                    </fieldset>
                </div>

                @if (!$registration->is_locked)
                    <div class="dashStickySave" id="dashStickySave">
                        <div class="dashStickySave__left">
                            <div class="dashStickySave__label">Kelengkapan</div>
                            <div class="dashStickySave__value"><span id="dashPct2">0</span>%</div>
                        </div>
                        <button type="button" class="btn btn--primary dashStickySave__btn" id="btnStickySubmit">
                            Simpan Permanen
                        </button>
                    </div>
                @else
                    <div class="dashStickySave"
                        style="justify-content: center; background: #f0fdf4; border-top: 1px solid #16a34a;">
                        <div style="color: #166534; font-weight: 600;">
                            ✓ Data telah dikirim dan sedang dalam verifikasi.
                        </div>
                    </div>
                @endif
            </form>
        </section>

        <footer class="dashFooter">
            <div class="dashFooter__note">
                Butuh bantuan? Hubungi admin melalui WhatsApp (di landing page) atau kontak resmi PSB.
            </div>
        </footer>
    </main>

    <!-- Summary Modal -->
    <div id="summaryModal" class="modal" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ringkasan Data Santri</h3>
                <button type="button" class="modal-close" id="btnModalClose">×</button>
            </div>
            <div class="modal-body" id="modalBodyContent">
                <!-- Summary content will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--outline" id="btnModalCancel">Batal</button>
                <button type="button" class="btn btn--primary" id="btnModalSave">Lanjut Simpan</button>
            </div>
        </div>
    </div>

    <!-- JS kecil untuk pindah tab + nama file (opsional) -->
    <div id="passwordModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Ubah Password</h3>
                <span class="close-btn">&times;</span>
            </div>
            <form id="passwordForm" method="post" action="{{ route('password.update') }}">
                @csrf
                <div class="form-group" style="position: relative;">
                    <label>Password Baru</label>
                    <input type="password" maxlength="20" name="password" id="passwordInput" class="field__input" required>
                    <span id="togglePassword" style="position: absolute; right: 10px; top: 35px; cursor: pointer;">
                        👁️
                    </span>
                </div>
                <div class="form-group" style="position: relative;">
                    <label>Konfirmasi Password</label>
                    <input type="password" maxlength="20" name="password_confirmation" id="passwordConfirmInput" class="field__input" required>
                    <span id="togglePasswordConfirm" style="position: absolute; right: 10px; top: 35px; cursor: pointer;">
                        👁️
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary close-btn-alt">Batal</button>
                    <button type="submit" class="btn btn--primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    @if($registration->status == 'accept')
    <div id="acceptedModal" class="modal-overlay">
        <div class="modal-content" style="text-align: center;">
            <div class="modal-header" style="justify-content: center; border-bottom: none;">
                 <div style="font-size: 50px;">🎉</div>
            </div>
            <h3>Selamat!</h3>
            <p>Assalamu'alaikum, <strong>{{ Auth::user()->name }}</strong></p>
            <p>Email: {{ Auth::user()->email }}</p>
            <p>No. Pendaftaran: <strong>REG-{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
            <br>
            <p>Anda dinyatakan <strong>DITERIMA</strong> sebagai santri di</p>
            <h4>PSB Darussalam</h4>
            <br>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn--primary close-accepted-btn">Alhamdulillah</button>
            </div>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1) Next/Prev tab
            const tabButtons = Array.from(document.querySelectorAll("[data-tabs] .tabs__tab"));
            const panels = Array.from(document.querySelectorAll("[data-tabs] .tabs__panel"));

            function activateTabById(panelId) {
                const panel = document.getElementById(panelId);
                if (!panel) return;

                const btn = tabButtons.find(b => b.getAttribute("aria-controls") === panelId);
                if (!btn) return;

                tabButtons.forEach((b) => {
                    const isActive = b === btn;
                    b.classList.toggle("is-active", isActive);
                    b.setAttribute("aria-selected", String(isActive));
                    b.tabIndex = isActive ? 0 : -1;
                });

                panels.forEach((p) => p.classList.toggle("is-active", p.id === panelId));
                panel.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }

            document.querySelectorAll("[data-next-tab]").forEach((el) => {
                el.addEventListener("click", () => activateTabById(el.getAttribute("data-next-tab")));
            });
            document.querySelectorAll("[data-prev-tab]").forEach((el) => {
                el.addEventListener("click", () => activateTabById(el.getAttribute("data-prev-tab")));
            });

            // 2) Tampilkan nama file di dropzone
            document.querySelectorAll(".dashFileInput").forEach((input) => {
                input.addEventListener("change", () => {
                    const id = input.id;
                    const label = document.querySelector(`[data-file-name="${id}"]`);
                    if (!label) return;

                    const file = input.files && input.files[0];
                    label.textContent = file ? file.name : "Belum ada file";
                });
            });

            // 3) Modal & Confirmation Logic
            const btnSubmit = document.getElementById("btnStickySubmit");
            // Ambil juga tombol simpan yang ada di dalam form
            const btnFormSubmit = document.querySelector(".dashBtnSave");

            const form = document.querySelector(".dashForm");
            const modal = document.getElementById('summaryModal');
            const modalBody = document.getElementById('modalBodyContent');
            const btnModalClose = document.getElementById('btnModalClose');
            const btnModalCancel = document.getElementById('btnModalCancel');
            const btnModalSave = document.getElementById('btnModalSave');

            // Close modal functions
            const closeModal = () => {
                if (modal) modal.classList.remove('is-open');
            };

            // Gunakan onclick untuk memastikan event terpasang dengan benar
            if (btnModalClose) {
                btnModalClose.onclick = (e) => {
                    e.preventDefault();
                    closeModal();
                };
            }

            if (btnModalCancel) {
                btnModalCancel.onclick = (e) => {
                    e.preventDefault();
                    closeModal();
                };
            }

            // Close on backdrop click
            if (modal) {
                modal.onclick = (e) => {
                    if (e.target === modal) closeModal();
                };
            }

            // Fungsi untuk menampilkan modal ringkasan
            const showSummaryModal = (e) => {
                e.preventDefault();

                // Manual validation check to handle hidden tabs
                // This prevents "An invalid form control is not focusable" error
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    const panel = firstInvalid.closest('.tabs__panel');
                    if (panel && !panel.classList.contains('is-active')) {
                        const panelId = panel.id;
                        const tabBtn = document.querySelector(`.tabs__tab[aria-controls="${panelId}"]`);
                        if (tabBtn) tabBtn.click();
                    }
                    
                    // Focus the element after a brief delay to ensure tab is visible
                    setTimeout(() => {
                        firstInvalid.focus();
                        form.reportValidity(); 
                    }, 100);
                    
                    return;
                }

                // Gather data for summary
                const nisn = document.getElementById("nisn")?.value || "-";
                const nik = document.getElementById("nik")?.value || "-";
                const nama = "{{ $registration->nama }}";
                const tempatLahir = document.getElementById("tempat_lahir")?.value || "-";
                const tanggalLahir = document.getElementById("tanggal_lahir")?.value || "-";
                const elJK = document.getElementById("jenis_kelamin");
                const jenisKelamin = elJK?.options[elJK.selectedIndex]?.text || "-";
                const alamat = document.getElementById("alamat")?.value || "-";
                const asalSekolah = document.getElementById("asal_sekolah")?.value || "-";
                // const namaAyah = document.getElementById("nama_ayah")?.value || "-";
                // const namaIbu = document.getElementById("nama_ibu")?.value || "-";
                // const noHp = document.getElementById("no_hp_wali")?.value || "-";

                // Tambahan : 
                const anakKe = document.getElementById("anak_ke")?.value || "-";
                const jumlahSaudara = document.getElementById("jumlah_saudara")?.value || "-";

                // Data Ayah : 
                const noKk = document.getElementById("no_kk")?.value || "-";
                const namaAyah = document.getElementById("nama_ayah")?.value || "-";
                const nikAyah = document.getElementById("nik_ayah")?.value || "-";
                const umurAyah = document.getElementById("umur_ayah")?.value || "-";
                const tempatLahirAyah = document.getElementById("tempat_lahir_ayah")?.value || "-";
                const tanggalLahirAyah = document.getElementById("tanggal_lahir_ayah")?.value || "-";
                const pendidikanTerakhirAyah = document.getElementById("pendidikan_terakhir_ayah")?.value ||
                    "-";
                const alamatAyah = document.getElementById("alamat_lengkap_ayah")?.value || "-";
                const noHpAyah = document.getElementById("no_hp_ayah")?.value || "-";
                const kodePos = document.getElementById("kode_pos")?.value || "-";
                const pekerjaanAyah = document.getElementById("pekerjaan_ayah")?.value || "-";

                // Data Ibu
                const namaIbu = document.getElementById("nama_ibu")?.value || "-";
                const nikIbu = document.getElementById("nik_ibu")?.value || "-";
                const umurIbu = document.getElementById("umur_ibu")?.value || "-";
                const tempatLahiribu = document.getElementById("tempat_lahir_ibu")?.value || "-";
                const tanggalLahirIbu = document.getElementById("tanggal_lahir_Ibu")?.value || "-";
                const pendidikanTerakhiribu = document.getElementById("pendidikan_terakhir_ibu")?.value ||
                    "-";
                const alamatIbu = document.getElementById("alamat_lengkap_ibu")?.value || "-";
                const pekerjaanIbu = document.getElementById("pekerjaan_ibu")?.value || "-";
                const noHpibu = document.getElementById("no_hp_ibu")?.value || "-";



                // Files check helper
                const checkFile = (id) => {
                    const input = document.getElementById(id);
                    if (input?.files?.length)
                        return "<span style='color:#0f766e'>✓ Ada (Akan diupload)</span>";
                    const existing = input?.getAttribute("data-existing") === "1";
                    return existing ? "<span style='color:#0f766e'>✓ Sudah ada</span>" :
                        "<span style='color:#b91c1c'>✕ Belum ada</span>";
                };

                const fileBiodata = checkFile("file-biodata");
                const fileRapor = checkFile("file-rapor");
                const fileIjazah = checkFile("file-ijazah");
                const fileSKL = checkFile("file-skl");
                const fileAkta = checkFile("file-akta-kelahiran");
                const fileKK = checkFile("file-kk");
                const fileFoto = checkFile("file-pas-foto");
                const fileKtpAyah = checkFile("file-ktp-ayah");
                const fileKtpIbu = checkFile("file-ktp-ibu");
                const fileKip = checkFile("file-kip");
                const fileBpjs = checkFile("file-bpjs");



                const fileAkte = checkFile("file-akte");

                const summaryHtml = `
                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Nama Lengkap</div>
                        <div class="modal-summary-value">${nama}</div>
                    </div>
                    <div class="modal-summary-item">
                        <div class="modal-summary-label">NISN / NIK</div>
                        <div class="modal-summary-value">${nisn} / ${nik}</div>
                    </div>
                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Tempat, Tanggal Lahir</div>
                        <div class="modal-summary-value">${tempatLahir}, ${tanggalLahir}</div>
                    </div>
                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Jenis Kelamin</div>
                        <div class="modal-summary-value">${jenisKelamin}</div>
                    </div>
                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Alamat</div>
                        <div class="modal-summary-value">${alamat}</div>
                    </div>
                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Asal Sekolah</div>
                        <div class="modal-summary-value">${asalSekolah}</div>
                    </div>
                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Anak Ke</div>
                        <div class="modal-summary-value">${anakKe}</div>
                    </div>
                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Jumlah Saudara</div>
                        <div class="modal-summary-value">${jumlahSaudara}</div>
                    </div>
                    <br>
                    

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Orang Tua / Wali</div>
                        <div class="modal-summary-value">Ayah: ${namaAyah}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">No KK</div>
                        <div class="modal-summary-value">${noKk}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Nik Ayah</div>
                        <div class="modal-summary-value">${nikAyah}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Umur Ayah</div>
                        <div class="modal-summary-value">${umurAyah}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Tempat Lahir Ayah</div>
                        <div class="modal-summary-value">${tempatLahirAyah}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Pendidikan Ayah</div>
                        <div class="modal-summary-value">${pendidikanTerakhirAyah}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Alamat Ayah</div>
                        <div class="modal-summary-value">${alamatAyah}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Pekerjaan Ayah</div>
                        <div class="modal-summary-value">${pekerjaanAyah}</div>
                    </div>


                    <div class="modal-summary-item">
                        <div class="modal-summary-label">No Hp Ayah</div>
                        <div class="modal-summary-value">${noHpAyah}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Kode Pos</div>
                        <div class="modal-summary-value">${kodePos}</div>
                    </div>



                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Orang Tua / Wali</div>
                        <div class="modal-summary-value">Ibu: ${namaIbu}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Nik Ibu</div>
                        <div class="modal-summary-value">${nikIbu}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Umur Ibu</div>
                        <div class="modal-summary-value">${umurIbu}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Tempat Lahir Ibu</div>
                        <div class="modal-summary-value">${tempatLahiribu}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Pekerjaan Ibu</div>
                        <div class="modal-summary-value">${pekerjaanIbu}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Pendidikan Ibu</div>
                        <div class="modal-summary-value">${pendidikanTerakhiribu}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Alamat Ibu</div>
                        <div class="modal-summary-value">${alamatIbu}</div>
                    </div>

                    <div class="modal-summary-item">
                        <div class="modal-summary-label">No Hp Ibu</div>
                        <div class="modal-summary-value">${noHpibu}</div>
                    </div>


                        <br>
                    <div class="modal-summary-item" style="border:none">
                        <div class="modal-summary-label">Kelengkapan Berkas</div>
                        <div class="modal-summary-value">
                            Biodata : ${fileBiodata}<br>
                            Rapor : ${fileRapor}<br>
                            Ijazah : ${fileIjazah}<br>
                            SKL : ${fileSKL}<br>
                            Akta Kelahiran : ${fileAkta}<br>
                            Kartu Keluarga : ${fileKK}<br>
                            Pas Foto : ${fileFoto}<br>
                            Ktp Ayah : ${fileKtpAyah}<br>
                            Ktp Ibu : ${fileKtpIbu}<br>
                            KIP/PKH/KIS : ${fileKip}<br>
                            BPJS : ${fileBpjs}<br>
                        </div>
                    </div>
                `;

                modalBody.innerHTML = summaryHtml;
                modal.classList.add('is-open');
            };

            // Step 1: Click Simpan -> Show Modal with Summary
            if (form && modal) {
                if (btnSubmit) btnSubmit.addEventListener("click", showSummaryModal);
                if (btnFormSubmit) btnFormSubmit.addEventListener("click", showSummaryModal);
            }

            // Step 2: Click Simpan in Modal -> Show SweetAlert Confirmation
            if (btnModalSave) {
                btnModalSave.addEventListener('click', () => {
                    closeModal();

                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: "Data yang disimpan tidak dapat diperbaiki lagi. Pastikan semua data sudah benar.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0f766e',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Simpan Permanen',
                        cancelButtonText: 'Batal, Cek Lagi'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }

            const pwdModalContainer = document.getElementById('passwordModal');
            const pwdTriggerBtn = document.getElementById('openModalBtn');
            const pwdCloseControls = document.querySelectorAll('.close-btn, .close-btn-alt');
            const pwdFormElement = document.getElementById('passwordForm');

            // Fungsi membuka modal password
            pwdTriggerBtn.onclick = () => {
                pwdModalContainer.style.display = 'block';
            }

            // Fungsi menutup modal (klik tombol silang atau batal)
            pwdCloseControls.forEach(control => {
                control.onclick = () => {
                    pwdModalContainer.style.display = 'none';
                }
            });

            // Menutup modal jika user mengklik area di luar kotak modal
            window.onclick = (event) => {
                if (event.target == pwdModalContainer) {
                    pwdModalContainer.style.display = 'none';
                }
                const acceptedModal = document.getElementById('acceptedModal');
                if (acceptedModal && event.target == acceptedModal) {
                    acceptedModal.style.display = 'none';
                }
            }

            // Accepted Modal Logic
            const acceptedModal = document.getElementById('acceptedModal');
            if (acceptedModal) {
                // Show automatically
                acceptedModal.style.display = 'block';

                const closeAcceptedBtn = document.querySelector('.close-accepted-btn');
                if (closeAcceptedBtn) {
                    closeAcceptedBtn.onclick = () => {
                        acceptedModal.style.display = 'none';
                    };
                }
            }

            // Toggle Password Visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.textContent = type === 'password' ? '👁️' : '🙈';
                });
            }

            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordConfirmInput = document.getElementById('passwordConfirmInput');

            if (togglePasswordConfirm && passwordConfirmInput) {
                togglePasswordConfirm.addEventListener('click', function() {
                    const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordConfirmInput.setAttribute('type', type);
                    this.textContent = type === 'password' ? '👁️' : '🙈';
                });
            }

            // Logika saat form dikirim
            // pwdFormElement.onsubmit = (e) => {
            //     e.preventDefault();

            //     // Contoh sederhana validasi kecocokan password di sisi client
            //     const newPass = pwdFormElement.new_password.value;
            //     const confirmPass = pwdFormElement.confirm_password.value;

            //     if (newPass !== confirmPass) {
            //         alert('Konfirmasi password baru tidak cocok!');
            //         return;
            //     }

            //     console.log('Data siap dikirim ke server...');
            //     pwdModalContainer.style.display = 'none';
            //     pwdFormElement.reset(); // Mengosongkan form setelah sukses
            // };

            // 4) Auto-switch tab on validation error
            document.querySelectorAll('input, select, textarea').forEach(input => {
                input.addEventListener('invalid', () => {
                    // Find the closest tab panel
                    const panel = input.closest('.tabs__panel');
                    if (panel && !panel.classList.contains('is-active')) {
                        // Find the tab button that controls this panel
                        const panelId = panel.id;
                        const tabBtn = document.querySelector(`.tabs__tab[aria-controls="${panelId}"]`);
                        if (tabBtn) {
                            tabBtn.click(); // Activate the tab
                        }
                    }
                });
            });

        });
    </script>
    <script src="{{ asset('landing/dashboard.js') }}"></script>
</body>

</html>
