@extends('admin.layouts.master')

@section('content')


    {{-- Modal --}}
    <div id="modalStatus" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Update Status Pendaftaran</h3>
                <span class="close-modal">&times;</span>
            </div>
            <form id="formUpdateStatus" action="{{ url('admin/update-status-pendaftaran/' . $data->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Pilih Status Baru:</p>
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="status" value="pending"
                                {{ $data->status == 'pending' ? 'checked' : '' }}>
                            Pending
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="status" value="incomplete_file"
                                {{ $data->status == 'incomplete_file' ? 'checked' : '' }}>
                            Berkas Belum Lengkap
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="status" value="ditolak"
                                {{ $data->status == 'reject' ? 'checked' : '' }}>
                            Tolak
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="status" value="diterima"
                                {{ $data->status == 'accept' ? 'checked' : '' }}>
                            Terima
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <textarea name="keterangan" id="keterangan" rows="4" placeholder="Tambahkan alasan atau instruksi tambahan...">{{ $data->keterangan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-close close-modal">Batal</button>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Status Pembayaran --}}
    <div id="modalStatusPembayaran" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Update Status Pendaftaran</h3>
                <span class="close-modal">&times;</span>
            </div>
            {{-- FORM UPDATE STATUS PEMBAYARAN --}}
            <form id="formUpdateStatusPembayaran" action="{{ url('admin/update-status-pembayaran/' . $data->id) }}"
                method="POST">
                @csrf
                <div class="modal-body">
                    <p>Pilih Status Baru:</p>
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="status_pembayaran" value="belum_lunas"
                                {{ $data->status_pembayaran == 'belum_lunas' ? 'checked' : '' }}>
                            Belum Lunas
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="status_pembayaran" value="lunas"
                                {{ $data->status_pembayaran == 'lunas' ? 'checked' : '' }}>
                            Lunas
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-close close-modal-pembayaran">Batal</button>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- KODINGAN PERTAMA CONFLICT (AKU) --}}
    {{-- END KODINGAN PERTAMA CONFLICT (AKU) --}}


    <div class="container-profile">
        {{-- Breadcrumb / Header --}}
        <div class="page-header">
            <div class="page-title">
                <h1>Detail Pendaftar</h1>
                <p>Informasi lengkap dan status pendaftaran siswa</p>
            </div>
            <a href="{{ url('admin/pendaftar') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Profile Header Card --}}
        <div class="profile-header">
            <div class="profile-info">
                <h2>{{ $data->nama }}</h2>
                <div class="profile-meta">
                    <span><i class="fa-solid fa-graduation-cap"></i> {{ $data->jenjang }}</span>
                    <span><i class="fa-solid fa-envelope"></i> {{ $data->email }}</span>
                    <span><i class="fa-brands fa-whatsapp"></i> {{ $data->wa }}</span>
                </div>
            </div>

            {{-- KODINGAN KEDUA CONFLICT (AKU) --}}
            {{-- END KODINGAN KEDUA CONFLICT --}}



            <div class="profile-actions">
                <button id="btnOpenStatus" class="btn-action btn-update">
                    <i class="fa-solid fa-pen-to-square"></i> Update Status
                </button>
                @php
                    $statusClass = match ($data->status) {
                        'pending' => 'status-pending',
                        'incomplete_file' => 'status-incomplete',
                        'ditolak' => 'status-reject',
                        'diterima' => 'status-accept',
                        default => 'status-pending',
                    };
                    $statusLabel = match ($data->status) {
                        'pending' => 'Pending',
                        'incomplete_file' => 'Berkas Belum Lengkap',
                        'ditolak' => 'Ditolak',
                        'diterima' => 'Diterima',
                        default => 'Pending',
                    };
                    $statusIcon = match ($data->status) {
                        'pending' => 'fa-clock',
                        'incomplete_file' => 'fa-file-circle-exclamation',
                        'ditolak' => 'fa-circle-xmark',
                        'diterima' => 'fa-circle-check',
                        default => 'fa-clock',
                    };
                @endphp
                <div class="status-badge {{ $statusClass }}">
                    <i class="fa-solid {{ $statusIcon }}"></i> {{ $statusLabel }}
                </div>
            </div>
        </div>

        <div class="main-grid">
            {{-- Left Column: Biodata & Parents --}}
            <div class="left-col">
                {{-- Info Utama --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-circle-info"></i> Informasi Pendaftaran</h3>
                    </div>
                    <div class="info-grid">
                        <div class="detail-item">
                            <div class="detail-label">Status Pembayaran</div>
                            <div class="detail-value">
                                {{ $data->status_pembayaran == 'belum_lunas' ? 'Belum Lunas' : 'Lunas' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Keterangan</div>
                            <div class="detail-value">{{ $data->keterangan ?? '-' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status Data</div>
                            <div class="detail-value">
                                @if ($data->is_locked)
                                    <span class="text-danger"><i class="fa-solid fa-lock"></i> Terkunci</span>
                                @else
                                    <span class="text-success"><i class="fa-solid fa-lock-open"></i>
                                        Terbuka</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Biodata Siswa --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-user"></i> Biodata Pribadi</h3>
                    </div>
                    <div class="info-grid">
                        <div class="detail-item">
                            <div class="detail-label">NISN</div>
                            <div class="detail-value">{{ $data->nisn }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">NIK</div>
                            <div class="detail-value">{{ $data->nik }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Tempat, Tanggal Lahir</div>
                            <div class="detail-value">{{ $data->tempat_lahir }}, {{ $data->tanggal_lahir }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Jenis Kelamin</div>
                            <div class="detail-value">{{ $data->jenis_kelamin }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Sekolah Asal</div>
                            <div class="detail-value">{{ $data->asal_sekolah }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Anak Ke</div>
                            <div class="detail-value">{{ $data->anak_ke }} dari {{ $data->jumlah_saudara }} bersaudara
                            </div>
                        </div>
                        <div class="detail-item col-span-full">
                            <div class="detail-label">Alamat Lengkap</div>
                            <div class="detail-value">{{ $data->alamat }}</div>
                        </div>
                    </div>
                </div>

                {{-- Data Orang Tua --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-users"></i> Data Orang Tua</h3>
                    </div>
                    <div class="grid-gap-20">
                        {{-- Ayah --}}
                        <div class="parent-section">
                            <div class="parent-header"><i class="fa-solid fa-mars"></i> Data Ayah</div>
                            <div class="info-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Nama Lengkap</div>
                                    <div class="detail-value">{{ $data->nama_ayah }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">NIK</div>
                                    <div class="detail-value">{{ $data->nik_ayah }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Pendidikan</div>
                                    <div class="detail-value">{{ $data->pendidikan_terakhir_ayah }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">No. HP / WA</div>
                                    <div class="detail-value">{{ $data->no_hp_ayah }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Ibu --}}
                        <div class="parent-section">
                            <div class="parent-header"><i class="fa-solid fa-venus"></i> Data Ibu</div>
                            <div class="info-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Nama Lengkap</div>
                                    <div class="detail-value">{{ $data->nama_ibu }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">NIK</div>
                                    <div class="detail-value">{{ $data->nik_ibu }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Pendidikan</div>
                                    <div class="detail-value">{{ $data->pendidikan_terakhir_ibu }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">No. HP / WA</div>
                                    <div class="detail-value">{{ $data->no_hp_ibu }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-sm text-muted text-center">
                        <i class="fa-solid fa-info-circle"></i> No. KK: <strong>{{ $data->no_kk }}</strong> | Kode Pos:
                        <strong>{{ $data->kode_pos }}</strong>
                    </div>
                </div>
            </div>

            {{-- Right Column: Files --}}
            <div class="right-col">
                <div class="card sticky-top-20">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-folder-open"></i> Dokumen</h3>
                    </div>
                    <div class="file-grid">
                        @php
                            $files = [
                                'Biodata' => $data->file_biodata,
                                'Rapor' => $data->file_rapor,
                                'Ijazah' => $data->file_ijazah,
                                'SKL' => $data->file_skl,
                                'Akta' => $data->file_akta_kelahiran,
                                'KK' => $data->file_kk,
                                'Foto' => $data->file_pas_foto,
                                'KTP Ayah' => $data->file_ktp_ayah,
                                'KTP Ibu' => $data->file_ktp_ibu,
                                'KIP' => $data->file_kip,
                                'BPJS' => $data->file_bpjs,
                            ];
                        @endphp

                        @foreach ($files as $label => $file)
                            @if ($file)
                                <a href="{{ asset('Berkas/' . $file) }}" target="_blank" class="file-card">
                                    <div class="file-icon"><i class="fa-solid fa-file-pdf"></i></div>
                                    <div class="file-name">{{ $label }}</div>
                                    <span class="text-xs text-success">Tersedia</span>
                                </a>
                            @else
                                <div class="file-card file-missing">
                                    <div class="file-icon"><i class="fa-solid fa-file-circle-xmark"></i></div>
                                    <div class="file-name">{{ $label }}</div>
                                    <span class="text-xs">Tidak Ada</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Premium Modal Update Status --}}
    <div id="modalStatus" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title-group">
                    <h3 class="modal-title">Update Status</h3>
                    <span class="modal-subtitle">Ubah status pendaftaran siswa</span>
                </div>
                <button class="close-modal"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="formUpdateStatus" action="{{ url('admin/update-status-pendaftaran/' . $data->id) }}"
                method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label">Pilih Status Baru</label>
                    <div class="status-grid">
                        {{-- Pending --}}
                        <div class="status-card pending {{ $data->status == 'pending' ? 'selected' : '' }}"
                            onclick="selectStatus(this, 'pending')">
                            <input type="radio" name="status" value="pending"
                                {{ $data->status == 'pending' ? 'checked' : '' }}>
                            <div class="status-icon"><i class="fa-solid fa-clock"></i></div>
                            <div class="status-info">
                                <span class="status-label">Pending</span>
                                <span class="status-desc">Menunggu verifikasi</span>
                            </div>
                            <div class="check-indicator"><i class="fa-solid fa-check"></i></div>
                        </div>

                        {{-- Incomplete --}}
                        <div class="status-card incomplete {{ $data->status == 'incomplete_file' ? 'selected' : '' }}"
                            onclick="selectStatus(this, 'incomplete_file')">
                            <input type="radio" name="status" value="incomplete_file"
                                {{ $data->status == 'incomplete_file' ? 'checked' : '' }}>
                            <div class="status-icon"><i class="fa-solid fa-file-circle-exclamation"></i></div>
                            <div class="status-info">
                                <span class="status-label">Belum Lengkap</span>
                                <span class="status-desc">Berkas kurang</span>
                            </div>
                            <div class="check-indicator"><i class="fa-solid fa-check"></i></div>
                        </div>

                        {{-- Reject --}}
                        <div class="status-card reject {{ $data->status == 'reject' ? 'selected' : '' }}"
                            onclick="selectStatus(this, 'reject')">
                            <input type="radio" name="status" value="reject"
                                {{ $data->status == 'reject' ? 'checked' : '' }}>
                            <div class="status-icon"><i class="fa-solid fa-circle-xmark"></i></div>
                            <div class="status-info">
                                <span class="status-label">Ditolak</span>
                                <span class="status-desc">Tidak lolos seleksi</span>
                            </div>
                            <div class="check-indicator"><i class="fa-solid fa-check"></i></div>
                        </div>

                        {{-- Accept --}}
                        <div class="status-card accept {{ $data->status == 'accept' ? 'selected' : '' }}"
                            onclick="selectStatus(this, 'accept')">
                            <input type="radio" name="status" value="accept"
                                {{ $data->status == 'accept' ? 'checked' : '' }}>
                            <div class="status-icon"><i class="fa-solid fa-circle-check"></i></div>
                            <div class="status-info">
                                <span class="status-label">Diterima</span>
                                <span class="status-desc">Lolos seleksi masuk</span>
                            </div>
                            <div class="check-indicator"><i class="fa-solid fa-check"></i></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan" class="form-label">Catatan / Keterangan Tambahan</label>
                        <textarea name="keterangan" id="keterangan" rows="4"
                            placeholder="Tuliskan alasan perubahan status atau instruksi selanjutnya...">{{ $data->keterangan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel close-modal">Batal</button>
                    <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container-profile">
        <div class="card" style="position: sticky; top: 20px;">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-folder-open"></i> Dokumen </h3>
            </div>
            <div class="file-grid">

                <a href="{{ url('form-pendaftaran-pdf/' . $data->id) }}" target="_blank" class="file-card">
                    <div class="file-icon"><i class="fa-solid fa-file-pdf"></i></div>
                    <div class="file-name">Dokumen Pendaftaran</div>
                    {{-- <span style="font-size: 0.7rem; color: var(--success);">Tersedia</span> --}}
                </a>

                <a href="{{ url('form-pernyataan-pdf/' . $data->id) }}" target="_blank" class="file-card">
                    <div class="file-icon"><i class="fa-solid fa-file-pdf"></i></div>
                    <div class="file-name">Dokumen Pernyataan</div>
                    {{-- <span style="font-size: 0.7rem; color: var(--success);">Tersedia</span> --}}
                </a>

                <a href="{{ url('form-janji-santri-pdf/' . $data->id) }}" target="_blank" class="file-card">
                    <div class="file-icon"><i class="fa-solid fa-file-pdf"></i></div>
                    <div class="file-name">Dokumen Janji Santri</div>
                    {{-- <span style="font-size: 0.7rem; color: var(--success);">Tersedia</span> --}}
                </a>

                <a href="{{ url('form-syarat-pendaftaran/') }}" target="_blank" class="file-card">
                    <div class="file-icon"><i class="fa-solid fa-file-pdf"></i></div>
                    <div class="file-name">Dokumen Janji Santri</div>
                    {{-- <span style="font-size: 0.7rem; color: var(--success);">Tersedia</span> --}}
                </a>

                {{-- @php
                    $files = [
                        'dokument penrnyataan' => $data->file_biodata,
                        'Rapor' => $data->file_rapor,
                        'Ijazah' => $data->file_ijazah,
                        'SKL' => $data->file_skl,
                        'Akta' => $data->file_akta_kelahiran,
                        'KK' => $data->file_kk,
                        'Foto' => $data->file_pas_foto,
                        'KTP Ayah' => $data->file_ktp_ayah,
                        'KTP Ibu' => $data->file_ktp_ibu,
                        'KIP' => $data->file_kip,
                        'BPJS' => $data->file_bpjs,
                    ];
                @endphp

                @foreach ($files as $label => $file)
                    @if ($file)
                        <a href="{{ asset('Berkas/' . $file) }}" target="_blank" class="file-card">
                            <div class="file-icon"><i class="fa-solid fa-file-pdf"></i></div>
                            <div class="file-name">{{ $label }}</div>
                            <span style="font-size: 0.7rem; color: var(--success);">Tersedia</span>
                        </a>
                    @else
                        <div class="file-card file-missing">
                            <div class="file-icon"><i class="fa-solid fa-file-circle-xmark"></i></div>
                            <div class="file-name">{{ $label }}</div>
                            <span style="font-size: 0.7rem;">Tidak Ada</span>
                        </div>
                    @endif
                @endforeach --}}
            </div>
        </div>
    </div>

    @session('success')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'animated bounceIn'
                    }
                });
            });
        </script>
    @endsession

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- Pastikan SweetAlert2 sudah diload di master layout --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Helper function for status selection
            function selectStatus(element, value) {
                // Remove selected class from all cards
                document.querySelectorAll('.status-card').forEach(card => {
                    card.classList.remove('selected');
                });

                // Add selected class to clicked card
                element.classList.add('selected');

                // Check the radio input
                const radio = element.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            }

            $(document).ready(function() {
                const modal = $('#modalStatus');
                $('#btnOpenStatus').on('click', function() {
                    modal.css('display', 'flex').hide().fadeIn(200);
                    // Prevent body scroll
                    $('body').css('overflow', 'hidden');
                });

                // KODINGAN KETIGA CONFLICT (KODINGAN AKU)
                // END KODINGAN KETIGA CONFLICT (KODINGAN AKU)


                // Close Modal Logic
                function closeModal() {
                    modal.fadeOut(200, function() {
                        $('body').css('overflow', 'auto');
                    });
                }

                $('.close-modal').on('click', function(e) {
                    e.preventDefault(); // Prevent form submission if button inside form
                    closeModal();
                });

                // Close on click outside
                $(window).on('click', function(event) {
                    if ($(event.target).is(modal)) {
                        closeModal();
                    }
                });

                // Escape key to close
                $(document).keydown(function(e) {
                    if (e.key === "Escape" && modal.is(':visible')) {
                        closeModal();
                    }
                });
            });
        </script>
    @endpush
@endsection
