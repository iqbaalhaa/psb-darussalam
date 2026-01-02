<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Santri - PSB Darussalam</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('landing/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/dashboard.css') }}"> {{-- tambahkan ini --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="dash">
    <a class="skip-link" href="#main">Lewati ke konten</a>

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="container topbar__inner">
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
                    <a href="{{ route('password.change') }}" class="btn btn--outline dashBtnSm">Ubah Password</a>

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

    <main id="main" class="container dashWrap">
        <!-- Alerts -->
        @if(session('success'))
            <div class="dashAlert dashAlert--success" role="status" aria-live="polite">
                <div class="dashAlert__icon">✓</div>
                <div class="dashAlert__content">{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="dashAlert dashAlert--error" role="alert" aria-live="assertive">
                <div class="dashAlert__icon">!</div>
                <div class="dashAlert__content">
                    <div class="dashAlert__title">Ada yang perlu diperbaiki:</div>
                    <ul class="dashAlert__list">
                        @foreach($errors->all() as $error)
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
                        @if($registration->status == 'pending')
                            Menunggu Verifikasi
                        @elseif($registration->status == 'accepted')
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

            <form class="dashForm" action="{{ route('santri.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Tabs / Steps -->
                <div class="tabs" data-tabs>
                    <div class="tabs__list" role="tablist" aria-label="Tahapan pengisian">
                        <button type="button" class="tabs__tab is-active" role="tab" aria-selected="true" aria-controls="tab-pribadi">
                            Data Pribadi
                        </button>
                        <button type="button" class="tabs__tab" role="tab" aria-selected="false" aria-controls="tab-wali" tabindex="-1">
                            Orang Tua / Wali
                        </button>
                        <button type="button" class="tabs__tab" role="tab" aria-selected="false" aria-controls="tab-berkas" tabindex="-1">
                            Upload Berkas
                        </button>
                    </div>

                    <fieldset style="border:none; padding:0; margin:0;" {{ $registration->is_locked ? 'disabled' : '' }}>
                    <div class="tabs__panels">
                        <!-- Panel: Data Pribadi -->
                        <section id="tab-pribadi" class="tabs__panel is-active" role="tabpanel">
                            <div class="dashGrid">
                                <label class="field">
                                    <span class="field__label">Nama Lengkap</span>
                                    <input type="text" class="field__input is-readonly" value="{{ $registration->nama }}" disabled>
                                    <span class="field__hint">Nama dari pendaftaran awal (tidak bisa diubah).</span>
                                </label>

                                <label class="field">
                                  <span class="field__label">NISN</span>
                                  <input id="nisn" type="text" name="nisn" class="field__input"
                                         value="{{ old('nisn', $registration->nisn) }}"
                                         required inputmode="numeric" autocomplete="off"
                                         data-required="1" data-rule="nisn" placeholder="10 digit angka">
                                  <div class="dashError" data-error-for="nisn"></div>
                                </label>

                                <label class="field">
                                  <span class="field__label">NIK</span>
                                  <input id="nik" type="text" name="nik" class="field__input"
                                         value="{{ old('nik', $registration->nik) }}"
                                         required inputmode="numeric" autocomplete="off"
                                         data-required="1" data-rule="nik" placeholder="16 digit angka">
                                  <div class="dashError" data-error-for="nik"></div>
                                </label>

                                <label class="field">
                                  <span class="field__label">Tempat Lahir</span>
                                  <input id="tempat_lahir" type="text" name="tempat_lahir" class="field__input"
                                         value="{{ old('tempat_lahir', $registration->tempat_lahir) }}"
                                         required data-required="1" placeholder="Contoh: Jambi">
                                  <div class="dashError" data-error-for="tempat_lahir"></div>
                                </label>

                                <label class="field">
                                  <span class="field__label">Tanggal Lahir</span>
                                  <input id="tanggal_lahir" type="date" name="tanggal_lahir" class="field__input"
                                         value="{{ old('tanggal_lahir', $registration->tanggal_lahir) }}"
                                         required data-required="1" data-rule="dob">
                                  <div class="dashError" data-error-for="tanggal_lahir"></div>
                                </label>

                                <label class="field">
                                  <span class="field__label">Jenis Kelamin</span>
                                  <select id="jenis_kelamin" name="jenis_kelamin" class="field__input"
                                          required data-required="1">
                                    <option value="">Pilih...</option>
                                    <option value="L" {{ old('jenis_kelamin', $registration->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $registration->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                  </select>
                                  <div class="dashError" data-error-for="jenis_kelamin"></div>
                                </label>

                                <label class="field dashColFull">
                                  <span class="field__label">Alamat Lengkap</span>
                                  <textarea id="alamat" name="alamat" class="field__input dashTextarea"
                                            required data-required="1"
                                            placeholder="Tulis alamat lengkap sesuai KK">{{ old('alamat', $registration->alamat) }}</textarea>
                                  <div class="dashError" data-error-for="alamat"></div>
                                </label>

                                <label class="field">
                                  <span class="field__label">Asal Sekolah</span>
                                  <input id="asal_sekolah" type="text" name="asal_sekolah" class="field__input"
                                         value="{{ old('asal_sekolah', $registration->asal_sekolah) }}"
                                         required data-required="1" placeholder="Contoh: MTsN 1 Jambi">
                                  <div class="dashError" data-error-for="asal_sekolah"></div>
                                </label>
                            </div>

                            <div class="dashPanelActions">
                                <button type="button" class="btn btn--ghost" data-next-tab="tab-wali">Lanjut: Orang Tua/Wali →</button>
                            </div>
                        </section>

                        <!-- Panel: Orang Tua / Wali -->
                        <section id="tab-wali" class="tabs__panel" role="tabpanel">
                            <div class="dashGrid">
                                <label class="field">
                                  <span class="field__label">Nama Ayah</span>
                                  <input id="nama_ayah" type="text" name="nama_ayah" class="field__input"
                                         value="{{ old('nama_ayah', $registration->nama_ayah) }}"
                                         required data-required="1">
                                  <div class="dashError" data-error-for="nama_ayah"></div>
                                </label>

                                <label class="field">
                                  <span class="field__label">Nama Ibu</span>
                                  <input id="nama_ibu" type="text" name="nama_ibu" class="field__input"
                                         value="{{ old('nama_ibu', $registration->nama_ibu) }}"
                                         required data-required="1">
                                  <div class="dashError" data-error-for="nama_ibu"></div>
                                </label>

                                <label class="field dashColFull">
                                  <span class="field__label">No. HP Wali (WhatsApp)</span>
                                  <input id="no_hp_wali" type="text" name="no_hp_wali" class="field__input"
                                         value="{{ old('no_hp_wali', $registration->no_hp_wali ?? $registration->wa) }}"
                                         required data-required="1" data-rule="wa"
                                         inputmode="tel" placeholder="Contoh: 08xxxxxxxxxx">
                                  <span class="field__hint">Boleh format 08… / 62… / +62…</span>
                                  <div class="dashError" data-error-for="no_hp_wali"></div>
                                </label>
                            </div>

                            <div class="dashPanelActions dashPanelActions--between">
                                <button type="button" class="btn btn--outline" data-prev-tab="tab-pribadi">← Kembali</button>
                                <button type="button" class="btn btn--ghost" data-next-tab="tab-berkas">Lanjut: Upload Berkas →</button>
                            </div>
                        </section>

                        <!-- Panel: Upload Berkas -->
                        <section id="tab-berkas" class="tabs__panel" role="tabpanel">
                            <div class="dashUploadGrid">
                                <!-- Pas Foto -->
                                <div class="dashUploadCard">
                                    <div class="dashUploadCard__head">
                                        <div class="dashUploadCard__title">Pas Foto Santri</div>
                                        <div class="dashUploadCard__meta">JPG/PNG • maks 2MB</div>
                                    </div>

                                    <label class="dashDropzone" for="file-foto">
                                        <div class="dashDropzone__icon">⬆</div>
                                        <div class="dashDropzone__text">
                                            <div class="dashDropzone__strong">Klik untuk upload</div>
                                            <div class="dashDropzone__muted" data-file-name="file-foto">Belum ada file</div>
                                        </div>
                                    </label>
                                    <input id="file-foto" type="file" name="foto"
                                           class="dashFileInput"
                                           accept="image/*"
                                           data-required-file="1"
                                           data-existing="{{ $registration->foto ? '1' : '0' }}"
                                           data-max-mb="2">
                                    <div class="dashError" data-error-for="file-foto"></div>

                                    @if($registration->foto)
                                        <div class="dashUploaded">
                                            <span class="dashUploaded__badge">Sudah diupload</span>
                                            <a class="link" href="{{ asset('storage/'.$registration->foto) }}" target="_blank">Lihat</a>
                                        </div>
                                    @endif
                                </div>

                                <!-- KK -->
                                <div class="dashUploadCard">
                                    <div class="dashUploadCard__head">
                                        <div class="dashUploadCard__title">Kartu Keluarga (KK)</div>
                                        <div class="dashUploadCard__meta">PDF/JPG/PNG • maks 2MB</div>
                                    </div>

                                    <label class="dashDropzone" for="file-kk">
                                        <div class="dashDropzone__icon">⬆</div>
                                        <div class="dashDropzone__text">
                                            <div class="dashDropzone__strong">Klik untuk upload</div>
                                            <div class="dashDropzone__muted" data-file-name="file-kk">Belum ada file</div>
                                        </div>
                                    </label>
                                    <input id="file-kk" type="file" name="kk_file" class="dashFileInput"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           data-required-file="1"
                                           data-existing="{{ $registration->kk_file ? '1' : '0' }}"
                                           data-max-mb="2">
                                    <div class="dashError" data-error-for="file-kk"></div>

                                    @if($registration->kk_file)
                                        <div class="dashUploaded">
                                            <span class="dashUploaded__badge">Sudah diupload</span>
                                            <a class="link" href="{{ asset('storage/'.$registration->kk_file) }}" target="_blank">Lihat</a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Akte -->
                                <div class="dashUploadCard">
                                    <div class="dashUploadCard__head">
                                        <div class="dashUploadCard__title">Akte Kelahiran</div>
                                        <div class="dashUploadCard__meta">PDF/JPG/PNG • maks 2MB</div>
                                    </div>

                                    <label class="dashDropzone" for="file-akte">
                                        <div class="dashDropzone__icon">⬆</div>
                                        <div class="dashDropzone__text">
                                            <div class="dashDropzone__strong">Klik untuk upload</div>
                                            <div class="dashDropzone__muted" data-file-name="file-akte">Belum ada file</div>
                                        </div>
                                    </label>
                                    <input id="file-akte" type="file" name="akte_file" class="dashFileInput"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           data-required-file="1"
                                           data-existing="{{ $registration->akte_file ? '1' : '0' }}"
                                           data-max-mb="2">
                                    <div class="dashError" data-error-for="file-akte"></div>

                                    @if($registration->akte_file)
                                        <div class="dashUploaded">
                                            <span class="dashUploaded__badge">Sudah diupload</span>
                                            <a class="link" href="{{ asset('storage/'.$registration->akte_file) }}" target="_blank">Lihat</a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Ijazah -->
                                <div class="dashUploadCard">
                                    <div class="dashUploadCard__head">
                                        <div class="dashUploadCard__title">Ijazah / SKL (Jika ada)</div>
                                        <div class="dashUploadCard__meta">PDF/JPG/PNG • maks 2MB</div>
                                    </div>

                                    <label class="dashDropzone" for="file-ijazah">
                                        <div class="dashDropzone__icon">⬆</div>
                                        <div class="dashDropzone__text">
                                            <div class="dashDropzone__strong">Klik untuk upload</div>
                                            <div class="dashDropzone__muted" data-file-name="file-ijazah">Belum ada file</div>
                                        </div>
                                    </label>
                                    <input id="file-ijazah" type="file" name="ijazah_file" class="dashFileInput"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           data-existing="{{ $registration->ijazah_file ? '1' : '0' }}"
                                           data-max-mb="2">
                                    <div class="dashError" data-error-for="file-ijazah"></div>

                                    @if($registration->ijazah_file)
                                        <div class="dashUploaded">
                                            <span class="dashUploaded__badge">Sudah diupload</span>
                                            <a class="link" href="{{ asset('storage/'.$registration->ijazah_file) }}" target="_blank">Lihat</a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="dashPanelActions dashPanelActions--between">
                                <button type="button" class="btn btn--outline" data-prev-tab="tab-wali">← Kembali</button>
                                <button type="submit" class="btn btn--primary dashBtnSave">
                                    Simpan & Perbarui Data
                                </button>
                            </div>

                            <div class="dashFootHint">
                                Dengan menekan “Simpan”, Anda menyatakan data yang diisi benar sesuai dokumen.
                            </div>
                        </section>
                    </div>
                    </fieldset>
                </div>

                @if(!$registration->is_locked)
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
                <div class="dashStickySave" style="justify-content: center; background: #f0fdf4; border-top: 1px solid #16a34a;">
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
    <script>
        document.addEventListener("DOMContentLoaded", () => {
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
                panel.scrollIntoView({ behavior: "smooth", block: "start" });
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
                if(modal) modal.classList.remove('is-open');
            };

            // Gunakan onclick untuk memastikan event terpasang dengan benar
            if(btnModalClose) {
                btnModalClose.onclick = (e) => {
                    e.preventDefault();
                    closeModal();
                };
            }
            
            if(btnModalCancel) {
                btnModalCancel.onclick = (e) => {
                    e.preventDefault();
                    closeModal();
                };
            }
            
            // Close on backdrop click
            if(modal) {
                modal.onclick = (e) => {
                    if (e.target === modal) closeModal();
                };
            }

            // Fungsi untuk menampilkan modal ringkasan
            const showSummaryModal = (e) => {
                e.preventDefault();

                // Check validation
                if (!form.reportValidity()) return;

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
                const namaAyah = document.getElementById("nama_ayah")?.value || "-";
                const namaIbu = document.getElementById("nama_ibu")?.value || "-";
                const noHp = document.getElementById("no_hp_wali")?.value || "-";
                
                // Files check helper
                const checkFile = (id) => {
                    const input = document.getElementById(id);
                    if (input?.files?.length) return "<span style='color:#0f766e'>✓ Ada (Akan diupload)</span>";
                    const existing = input?.getAttribute("data-existing") === "1";
                    return existing ? "<span style='color:#0f766e'>✓ Sudah ada</span>" : "<span style='color:#b91c1c'>✕ Belum ada</span>";
                };

                const fileFoto = checkFile("file-foto");
                const fileKK = checkFile("file-kk");
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
                    <br>
                    <div class="modal-summary-item">
                        <div class="modal-summary-label">Orang Tua / Wali</div>
                        <div class="modal-summary-value">Ayah: ${namaAyah} <br> Ibu: ${namaIbu} <br> HP: ${noHp}</div>
                    </div>
                        <br>
                    <div class="modal-summary-item" style="border:none">
                        <div class="modal-summary-label">Kelengkapan Berkas</div>
                        <div class="modal-summary-value">
                            Pas Foto: ${fileFoto}<br>
                            KK: ${fileKK}<br>
                            Akte: ${fileAkte}
                        </div>
                    </div>
                `;

                modalBody.innerHTML = summaryHtml;
                modal.classList.add('is-open');
            };

            // Step 1: Click Simpan -> Show Modal with Summary
            if (form && modal) {
                if(btnSubmit) btnSubmit.addEventListener("click", showSummaryModal);
                if(btnFormSubmit) btnFormSubmit.addEventListener("click", showSummaryModal);
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
        });
    </script>
    <script src="{{ asset('landing/dashboard.js') }}"></script>
</body>
</html>
