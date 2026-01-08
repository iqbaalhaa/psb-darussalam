@extends('admin.layouts.master')

@section('content')
    <div class="container-edit">
        <div class="card-form">
            <div class="form-header">
                <h2>Edit Data Pendaftaran: {{ $data->nama }}</h2>
                <a href="{{ url('admin/pendaftar') }}" class="btn-back">Kembali</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('admin/update-pendaftar/' . $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h3 class="section-title">I. Biodata Siswa</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama', $data->nama) }}" maxlength="250"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Jenjang</label>
                            <select name="jenjang">
                                <option value="SMP" {{ $data->jenjang == 'MTS' ? 'selected' : '' }}>MTS</option>
                                <option value="SMA" {{ $data->jenjang == 'MA' ? 'selected' : '' }}>MA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ $data->user->email }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>WhatsApp</label>
                            <input type="text" name="wa" value="{{ $data->wa }}" maxlength="15">
                        </div>
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" name="nisn" value="{{ $data->nisn }}" maxlength="10" minlength="10">
                        </div>
                        <div class="form-group">
                            <label>NIK Siswa</label>
                            <input type="text" name="nik" value="{{ $data->nik }}" maxlength="16" minlength="16">
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ $data->tempat_lahir }}" maxlength="250">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ $data->tanggal_lahir }}">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin">
                                <option value="L" {{ $data->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="P" {{ $data->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" value="{{ $data->asal_sekolah }}" maxlength="250">
                        </div>
                        <div class="form-group">
                            <label>Anak Ke</label>
                            <input type="number" name="anak_ke" value="{{ $data->anak_ke }}">
                        </div>
                        <div class="form-group">
                            <label>Jumlah Saudara</label>
                            <input type="number" name="jumlah_saudara" value="{{ $data->jumlah_saudara }}">
                        </div>
                        <div class="form-group full-width">
                            <label>Alamat Lengkap Siswa</label>
                            <textarea name="alamat" rows="2" maxlength="250">{{ $data->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Password (Kosongkan jika tidak ingin merubah password)</label>
                            <input type="text" name="password">
                        </div>
                    </div>
                </div>

                <div class="form-section highlight-ayah">
                    <h3 class="section-title">II. Data Ayah</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Ayah</label>
                            <input type="text" name="nama_ayah" value="{{ $data->nama_ayah }}" maxlength="250">
                        </div>
                        <div class="form-group">
                            <label>NIK Ayah</label>
                            <input type="text" name="nik_ayah" value="{{ $data->nik_ayah }}" maxlength="16"
                                minlength="16">
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir Ayah</label>
                            <input type="text" name="tempat_lahir_ayah" value="{{ $data->tempat_lahir_ayah }}"
                                maxlength="250">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir Ayah</label>
                            <input type="date" name="tanggal_lahir_ayah" value="{{ $data->tanggal_lahir_ayah }}">
                        </div>
                        <div class="form-group">
                            <label>Pendidikan Terakhir</label>
                            <select id="pendidikan_terakhir_ayah" name="pendidikan_terakhir_ayah" class="field__input"
                                required data-required="1">
                                <option value="" disabled
                                    {{ old('pendidikan_terakhir_ayah', $data->pendidikan_terakhir_ayah) == '' ? 'selected' : '' }}>
                                    Pilih Pendidikan</option>
                                <option value="SD"
                                    {{ old('pendidikan_terakhir_ayah', $data->pendidikan_terakhir_ayah) == 'SD' ? 'selected' : '' }}>
                                    SD / Sederajat</option>
                                <option value="SMP"
                                    {{ old('pendidikan_terakhir_ayah', $data->pendidikan_terakhir_ayah) == 'SMP' ? 'selected' : '' }}>
                                    SMP / Sederajat</option>
                                <option value="SMA"
                                    {{ old('pendidikan_terakhir_ayah', $data->pendidikan_terakhir_ayah) == 'SMA' ? 'selected' : '' }}>
                                    SMA / SMK / Sederajat</option>
                                <option value="D3"
                                    {{ old('pendidikan_terakhir_ayah', $data->pendidikan_terakhir_ayah) == 'D3' ? 'selected' : '' }}>
                                    Diploma 3 (D3)</option>
                                <option value="S1"
                                    {{ old('pendidikan_terakhir_ayah', $data->pendidikan_terakhir_ayah) == 'S1' ? 'selected' : '' }}>
                                    Sarjana (S1)</option>
                                <option value="S2"
                                    {{ old('pendidikan_terakhir_ayah', $data->pendidikan_terakhir_ayah) == 'S2' ? 'selected' : '' }}>
                                    Magister (S2)</option>
                                <option value="S3"
                                    {{ old('pendidikan_terakhir_ayah', $data->pendidikan_terakhir_ayah) == 'S3' ? 'selected' : '' }}>
                                    Doktor (S3)</option>
                                <option value="Tidak Sekolah"
                                    {{ old('pendidikan_terakhir_ayah', $data->pendidikan_terakhir_ayah) == 'Tidak Sekolah' ? 'selected' : '' }}>
                                    Tidak Sekolah</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No. HP Ayah</label>
                            <input type="text" name="no_hp_ayah" value="{{ $data->no_hp_ayah }}" maxlength="15">
                        </div>
                        <div class="form-group">
                            <label>Umur</label>
                            <input type="text" name="umur_ayah" value="{{ $data->umur_ayah }}">
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap Ayah</label>
                            <textarea name="alamat_lengkap_ayah" rows="2" maxlength="250">{{ $data->alamat_lengkap_ayah }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section highlight-ibu">
                    <h3 class="section-title">III. Data Ibu</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Ibu</label>
                            <input type="text" name="nama_ibu" value="{{ $data->nama_ibu }}" maxlength="250">
                        </div>
                        <div class="form-group">
                            <label>NIK Ibu</label>
                            <input type="text" name="nik_ibu" value="{{ $data->nik_ibu }}" maxlength="16"
                                minlength="16">
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir Ibu</label>
                            <input type="text" name="tempat_lahir_ibu" value="{{ $data->tempat_lahir_ibu }}"
                                maxlength="250">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir Ibu</label>
                            <input type="date" name="tanggal_lahir_ibu" value="{{ $data->tanggal_lahir_ibu }}">
                        </div>
                        <div class="form-group">
                            <label>Pendidikan Terakhir Ibu</label>
                            <select id="pendidikan_terakhir_ibu" name="pendidikan_terakhir_ibu" class="field__input"
                                required data-required="1">
                                <option value="" disabled
                                    {{ old('pendidikan_terakhir_ibu', $data->pendidikan_terakhir_ibu) == '' ? 'selected' : '' }}>
                                    Pilih Pendidikan</option>
                                <option value="SD"
                                    {{ old('pendidikan_terakhir_ibu', $data->pendidikan_terakhir_ibu) == 'SD' ? 'selected' : '' }}>
                                    SD / Sederajat</option>
                                <option value="SMP"
                                    {{ old('pendidikan_terakhir_ibu', $data->pendidikan_terakhir_ibu) == 'SMP' ? 'selected' : '' }}>
                                    SMP / Sederajat</option>
                                <option value="SMA"
                                    {{ old('pendidikan_terakhir_ibu', $data->pendidikan_terakhir_ibu) == 'SMA' ? 'selected' : '' }}>
                                    SMA / SMK / Sederajat</option>
                                <option value="D3"
                                    {{ old('pendidikan_terakhir_ibu', $data->pendidikan_terakhir_ibu) == 'D3' ? 'selected' : '' }}>
                                    Diploma 3 (D3)</option>
                                <option value="S1"
                                    {{ old('pendidikan_terakhir_ibu', $data->pendidikan_terakhir_ibu) == 'S1' ? 'selected' : '' }}>
                                    Sarjana (S1)</option>
                                <option value="S2"
                                    {{ old('pendidikan_terakhir_ibu', $data->pendidikan_terakhir_ibu) == 'S2' ? 'selected' : '' }}>
                                    Magister (S2)</option>
                                <option value="S3"
                                    {{ old('pendidikan_terakhir_ibu', $data->pendidikan_terakhir_ibu) == 'S3' ? 'selected' : '' }}>
                                    Doktor (S3)</option>
                                <option value="Tidak Sekolah"
                                    {{ old('pendidikan_terakhir_ibu', $data->pendidikan_terakhir_ibu) == 'Tidak Sekolah' ? 'selected' : '' }}>
                                    Tidak Sekolah</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No. HP Ibu</label>
                            <input type="text" name="no_hp_ibu" value="{{ $data->no_hp_ibu }}" maxlength="15">
                        </div>
                        <div class="form-group">
                            <label>Umur</label>
                            <input type="text" name="umur_ibu" value="{{ $data->umur_ibu }}">
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap Ibu</label>
                            <textarea name="alamat_lengkap_ibu" rows="2" maxlength="250">{{ $data->alamat_lengkap_ibu }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">IV. Status & Dokumen</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Status Lock Data</label>
                            <select name="is_locked">
                                <option value="1" {{ $data->is_locked ? 'selected' : '' }}>Terkunci (User tidak bisa
                                    edit)</option>
                                <option value="0" {{ !$data->is_locked ? 'selected' : '' }}>Buka (User bisa edit)
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No. KK</label>
                            <input type="text" name="no_kk" value="{{ $data->no_kk }}" maxlength="16"
                                minlength="16">
                        </div>
                        <div class="form-group">
                            <label>Kode Pos</label>
                            <input type="text" name="kode_pos" value="{{ $data->kode_pos }}" maxlength="10">
                        </div>
                        <div class="form-group full-width">
                            <label>Keterangan Admin</label>
                            <textarea name="keterangan" rows="3" maxlength="250">{{ $data->keterangan }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">V. Update Berkas (Kosongkan jika tidak ingin ganti)</h3>
                    <div class="file-edit-grid">
                        @php
                            $fileFields = [
                                'file_biodata' => 'Biodata',
                                'file_rapor' => 'Rapor',
                                'file_ijazah' => 'Ijazah',
                                'file_skl' => 'SKL',
                                'file_akta_kelahiran' => 'Akta Kelahiran',
                                'file_kk' => 'Kartu Keluarga',
                                'file_pas_foto' => 'Pas Foto',
                                'file_ktp_ayah' => 'KTP Ayah',
                                'file_ktp_ibu' => 'KTP Ibu',
                                'file_kip' => 'KIP',
                                'file_bpjs' => 'BPJS',
                            ];
                        @endphp

                        @foreach ($fileFields as $field => $label)
                            <div class="file-group">
                                <label>{{ $label }}</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="{{ $field }}">
                                    @if ($data->$field)
                                        <a href="{{ asset('Berkas/' . $data->$field) }}" target="_blank"
                                            class="view-old">
                                            Lihat File Lama
                                        </a>
                                    @else
                                        <span class="no-file">Belum ada file</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Simpan Perubahan Data</button>
                </div>
            </form>
        </div>
    </div>

    @session('success')
        <script>
            alert("Berhasil mengupdate data");
        </script>
    @endsession

    <style>
        .container-edit {
            max-width: 1100px;
            margin: 20px auto;
            padding: 0 15px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-form {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e1e4e8;
        }

        .form-header {
            background: #2c3e50;
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-header h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .form-section {
            padding: 30px;
            border-bottom: 1px solid #eee;
        }

        .section-title {
            margin-top: 0;
            margin-bottom: 25px;
            color: #3498db;
            font-size: 1.2rem;
            border-left: 4px solid #3498db;
            padding-left: 15px;
        }

        .highlight-ayah {
            background-color: #f0f7ff;
        }

        .highlight-ibu {
            background-color: #fff5f8;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px 14px;
            border: 1.5px solid #dcdfe6;
            border-radius: 6px;
            font-size: 1rem;
            transition: 0.3s;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-actions {
            padding: 30px;
            background: #f8f9fa;
            text-align: right;
        }

        .btn-submit {
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #219150;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
        }

        /* CSS Tambahan untuk Section Berkas */
        .file-edit-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }

        .file-group {
            background: #fdfdfd;
            border: 1px solid #eee;
            padding: 12px;
            border-radius: 8px;
        }

        .file-group label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 5px;
            display: block;
        }

        .file-input-wrapper {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .file-input-wrapper input[type="file"] {
            font-size: 0.8rem;
            padding: 5px;
            border: none;
        }

        .view-old {
            font-size: 0.75rem;
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .view-old:hover {
            text-decoration: underline;
        }

        .no-file {
            font-size: 0.75rem;
            color: #e74c3c;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
@endsection
