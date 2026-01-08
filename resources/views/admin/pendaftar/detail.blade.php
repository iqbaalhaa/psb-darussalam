@extends('admin.layouts.master')

@section('content')
    @push('styles')
        <style>
            .container-profile {
                font-family: Arial, sans-serif;
                max-width: 1000px;
                margin: 20px auto;
                color: #333;
                line-height: 1.6;
            }

            .card {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .header-card {
                background: #f8f9fa;
                border-left: 5px solid #3498db;
            }

            .header-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #eee;
                padding-bottom: 10px;
                margin-bottom: 15px;
            }

            .header-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }

            .info-item label {
                display: block;
                font-size: 11px;
                text-transform: uppercase;
                color: #777;
                font-weight: bold;
            }

            .main-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .section-title {
                border-bottom: 2px solid #3498db;
                padding-bottom: 5px;
                margin-bottom: 15px;
                font-size: 18px;
            }

            .detail-table {
                width: 100%;
                border-collapse: collapse;
            }

            .detail-table td {
                padding: 8px 0;
                border-bottom: 1px solid #f5f5f5;
            }

            .parent-box {
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 10px;
            }

            .ayah {
                background: #e3f2fd;
                border: 1px solid #bbdefb;
            }

            .ibu {
                background: #fce4ec;
                border: 1px solid #f8bbd0;
            }

            .parent-box h4 {
                margin: 0 0 5px 0;
                font-size: 14px;
            }

            .badge {
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: bold;
            }

            .locked {
                background: #ffebee;
                color: #c62828;
            }

            .unlocked {
                background: #e8f5e9;
                color: #2e7d32;
            }

            .file-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 10px;
            }

            .file-link {
                display: block;
                padding: 10px;
                text-align: center;
                background: #f1f1f1;
                text-decoration: none;
                color: #333;
                border-radius: 4px;
                font-size: 12px;
            }

            .file-link:hover {
                background: #e0e0e0;
            }

            /* Responsif untuk HP */
            @media (max-width: 768px) {
                .main-grid {
                    grid-template-columns: 1fr;
                }
            }

            /* Modal */
            /* Tombol Status */
            .btn-status {
                background-color: #f39c12;
                color: white;
                border: none;
                padding: 8px 15px;
                border-radius: 5px;
                cursor: pointer;
                margin-right: 10px;
                font-weight: bold;
            }

            /* Overlay Modal */
            .modal-overlay {
                display: none;
                /* Tersembunyi di awal */
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(2px);
            }

            /* Konten Modal */
            .modal-content {
                background-color: #fff;
                margin: 10% auto;
                width: 90%;
                max-width: 500px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                overflow: hidden;
            }

            .modal-header,
            .modal-footer {
                padding: 15px 20px;
                background: #f8f9fa;
            }

            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #eee;
            }

            .modal-body {
                padding: 20px;
            }

            /* Styling Input */
            .radio-group {
                display: flex;
                flex-direction: column;
                gap: 10px;
                margin-bottom: 20px;
            }

            .radio-item {
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                cursor: pointer;
            }

            .radio-item:hover {
                background: #f0f7ff;
            }

            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
            }

            textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-sizing: border-box;
                /* Penting agar tidak overflow */
                font-family: inherit;
            }

            /* Tombol Modal */
            .btn-save {
                background: #2ecc71;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-close {
                background: #95a5a6;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                margin-right: 5px;
            }

            .close-modal {
                cursor: pointer;
                font-size: 20px;
                font-weight: bold;
                color: #777;
            }
        </style>
    @endpush

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
                            <input type="radio" name="status" value="reject"
                                {{ $data->status == 'reject' ? 'checked' : '' }}>
                            Tolak
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="status" value="accept"
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

    <div class="container-profile">
        <div class="card header-card">
            <div class="header-top">
                <h2>Profil Siswa: {{ $data->nama }}</h2>
                <div class="header-actions">
                    <button id="btnOpenStatus" class="btn-status">Update Status</button>
                    {{-- <span class="badge {{ $data->is_locked ? "locked" : "unlocked" }}"> --}}

                    @if ($data->status == 'pending')
                        <span class="badge" style="background: yellow">Pending</span>
                    @elseif ($data->status == 'incomplete_file')
                        <span class="badge" style="background: grey">Berkas Belum Lengkap</span>
                    @elseif ($data->status == 'reject')
                        <span class="badge" style="background: red">Ditolak</span>
                    @else
                        <span class="badge" style="background: green">Diterima</span>
                    @endif

                </div>
            </div>
            <div class="header-grid">
                <div class="info-item">
                    <label>Keterangan</label>
                    <span>{{ $data->keterangan }}</span>
                </div>
            </div>
            <hr>
            <div class="header-grid">
                <div class="info-item">
                    <label>Jenjang</label>
                    <span>{{ $data->jenjang }}</span>
                </div>
                <div class="info-item">
                    <label>Email</label>
                    <span>{{ $data->email }}</span>
                </div>
                <div class="info-item">
                    <label>WhatsApp</label>
                    <span>{{ $data->wa }}</span>
                </div>
                <div class="info-item">
                    <label>Status Perubah Data</label>
                    @if ($data->is_locked)
                        <span>Data tidak bisa dirubah oleh user </span>
                    @else
                        <span> Data bisa dirubah oleh user</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="main-grid">
            <div class="card">
                <h3 class="section-title">Biodata Pribadi</h3>
                <table class="detail-table">
                    <tr>
                        <td>NISN</td>
                        <td>: {{ $data->nisn }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: {{ $data->nik }}</td>
                    </tr>
                    <tr>
                        <td>TTL</td>
                        <td>: {{ $data->tempat_lahir }}, {{ $data->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>: {{ $data->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td>Sekolah Asal</td>
                        <td>: {{ $data->asal_sekolah }}</td>
                    </tr>
                    <tr>
                        <td>Anak Ke</td>
                        <td>: {{ $data->anak_ke }} dari {{ $data->jumlah_saudara }} bersaudara</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $data->alamat }}</td>
                    </tr>
                </table>
            </div>

            <div class="card">
                <h3 class="section-title">Data Orang Tua</h3>
                <div class="parent-box ayah">
                    <h4>Data Ayah</h4>
                    <table class="detail-table">
                        <tr>
                            <td width="30%">Nama</td>
                            <td>: <strong>{{ $data->nama_ayah }}</strong></td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>: {{ $data->nik_ayah }}</td>
                        </tr>
                        <tr>
                            <td>TTL</td>
                            <td>: {{ $data->tempat_lahir_ayah }}, {{ $data->tanggal_lahir_ayah }}</td>
                        </tr>
                        <tr>
                            <td>Pendidikan</td>
                            <td>: {{ $data->pendidikan_terakhir_ayah }}</td>
                        </tr>
                        <tr>
                            <td>No HP / WA</td>
                            <td>: {{ $data->no_hp_ayah }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $data->alamat_ayah ?? $data->alamat }}</td>
                            {{-- Gunakan alamat siswa jika alamat ayah kosong --}}
                        </tr>
                    </table>
                </div>
                <div class="parent-box ibu" style="margin-top: 20px;">
                    <h4>Data Ibu</h4>
                    <table class="detail-table">
                        <tr>
                            <td width="30%">Nama</td>
                            <td>: <strong>{{ $data->nama_ibu }}</strong></td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>: {{ $data->nik_ibu }}</td>
                        </tr>
                        <tr>
                            <td>TTL</td>
                            <td>: {{ $data->tempat_lahir_ibu }}, {{ $data->tanggal_lahir_ibu }}</td>
                        </tr>
                        <tr>
                            <td>Pendidikan</td>
                            <td>: {{ $data->pendidikan_terakhir_ibu }}</td>
                        </tr>
                        <tr>
                            <td>No HP / WA</td>
                            <td>: {{ $data->no_hp_ibu }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $data->alamat_ibu ?? $data->alamat }}</td>
                        </tr>
                    </table>
                </div>
                <p style="font-size: 12px; margin-top: 10px;">No. KK: {{ $data->no_kk }} | Kode Pos:
                    {{ $data->kode_pos }}</p>
            </div>
        </div>

        <div class="card">
            <h3 class="section-title">Dokumen Pendukung</h3>
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
                        <a href="{{ asset('Berkas/' . $file) }}" target="_blank" class="file-link">
                            📄 {{ $label }}
                        </a>
                    @else
                        <div class="file-link" style="background: red">📄 {{ $label }}</div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    @session('success')
        <script>
            alert("Berhasil mengupdate status")
        </script>
    @endsession

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Membuka Modal
                $('#btnOpenStatus').on('click', function() {
                    $('#modalStatus').fadeIn(300);
                });

                // Menutup Modal (Klik X, tombol Batal, atau klik di luar modal)
                $('.close-modal').on('click', function() {
                    $('#modalStatus').fadeOut(300);
                });

                $(window).on('click', function(event) {
                    if ($(event.target).is('#modalStatus')) {
                        $('#modalStatus').fadeOut(300);
                    }
                });

                // Logika Radio Item (Agar klik di seluruh area kotak radio juga memilih)
                $('.radio-item').on('click', function() {
                    $(this).find('input[type="radio"]').prop('checked', true);
                });

                // Handle Submit via AJAX (Optional) atau biarkan default form
                // $('#formUpdateStatus').on('submit', function() {
                //     // Tampilkan loading jika diperlukan
                //     $('.btn-save').text('Menyimpan...').prop('disabled', true);
                // });
            });
        </script>
    @endpush
@endsection
