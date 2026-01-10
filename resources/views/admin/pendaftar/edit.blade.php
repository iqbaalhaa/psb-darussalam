@extends('admin.layouts.master')

@section('content')
    <div class="container-profile">
        {{-- Header --}}
        <div class="page-header">
            <div class="page-title">
                <h1>Edit Data Pendaftaran</h1>
                <p>Perbarui informasi siswa: <strong>{{ $data->nama }}</strong></p>
            </div>
            <a href="{{ url('admin/pendaftar') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="alert" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('admin/update-pendaftar/' . $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Biodata Siswa --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-user"></i> Biodata Siswa</h3>
                </div>
                <div class="grid-gap-20" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $data->nama) }}" class="form-control"
                            maxlength="250" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenjang</label>
                        <select name="jenjang" class="form-select">
                            <option value="MTS" {{ $data->jenjang == 'MTS' ? 'selected' : '' }}>MTS</option>
                            <option value="MA" {{ $data->jenjang == 'MA' ? 'selected' : '' }}>MA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $data->user->email ?? '') }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" name="wa" value="{{ old('wa', $data->wa) }}" class="form-control"
                            maxlength="15" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $data->nisn) }}" class="form-control"
                            maxlength="10" minlength="10" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NIK Siswa</label>
                        <input type="text" name="nik" value="{{ old('nik', $data->nik) }}" class="form-control"
                            maxlength="16" minlength="16" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $data->tempat_lahir) }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $data->tanggal_lahir) }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki" {{ $data->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="Perempuan" {{ $data->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $data->asal_sekolah) }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Anak Ke</label>
                        <input type="number" name="anak_ke" value="{{ old('anak_ke', $data->anak_ke) }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Saudara</label>
                        <input type="number" name="jumlah_saudara"
                            value="{{ old('jumlah_saudara', $data->jumlah_saudara) }}" class="form-control" required>
                    </div>
                    <div class="form-group col-span-full">
                        <label class="form-label">Alamat Lengkap Siswa</label>
                        <textarea name="alamat" class="form-control" rows="2" maxlength="250">{{ $data->alamat }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password (Kosongkan jika tidak ingin merubah)</label>
                        <input type="text" name="password" class="form-control" placeholder="Masukkan password baru...">
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
                        <div class="grid-gap-20" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                            <div class="form-group">
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" name="nama_ayah" value="{{ $data->nama_ayah }}" class="form-control"
                                    maxlength="250">
                            </div>
                            <div class="form-group">
                                <label class="form-label">NIK Ayah</label>
                                <input type="text" name="nik_ayah" value="{{ $data->nik_ayah }}" class="form-control"
                                    maxlength="16" minlength="16">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tempat Lahir Ayah</label>
                                <input type="text" name="tempat_lahir_ayah" value="{{ $data->tempat_lahir_ayah }}"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir Ayah</label>
                                <input type="date" name="tanggal_lahir_ayah" value="{{ $data->tanggal_lahir_ayah }}"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pendidikan Ayah</label>
                                <select name="pendidikan_terakhir_ayah" class="form-select">
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
                                <label class="form-label">Pekerjaan Ayah</label>
                                <input type="text" name="pekerjaan_ayah" value="{{ $data->pekerjaan_ayah }}"
                                    class="form-control" maxlength="100">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Penghasilan Ayah</label>
                                <select name="penghasilan_ayah" class="form-select">
                                    <option value="< 1 Juta"
                                        {{ old('penghasilan_ayah', $data->penghasilan_ayah) == '< 1 Juta' ? 'selected' : '' }}>
                                        < 1 Juta</option>
                                    <option value="1 - 3 Juta"
                                        {{ old('penghasilan_ayah', $data->penghasilan_ayah) == '1 - 3 Juta' ? 'selected' : '' }}>
                                        1 - 3 Juta</option>
                                    <option value="3 - 5 Juta"
                                        {{ old('penghasilan_ayah', $data->penghasilan_ayah) == '3 - 5 Juta' ? 'selected' : '' }}>
                                        3 - 5 Juta</option>
                                    <option value="> 5 Juta"
                                        {{ old('penghasilan_ayah', $data->penghasilan_ayah) == '> 5 Juta' ? 'selected' : '' }}>
                                        > 5 Juta</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No HP Ayah</label>
                                <input type="text" name="no_hp_ayah" value="{{ $data->no_hp_ayah }}"
                                    class="form-control" maxlength="15">
                            </div>
                            <div class="form-group col-span-full">
                                <label class="form-label">Alamat Lengkap Ayah</label>
                                <textarea name="alamat_lengkap_ayah" class="form-control" rows="2" maxlength="250">{{ $data->alamat_lengkap_ayah }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Ibu --}}
                    <div class="parent-section">
                        <div class="parent-header"><i class="fa-solid fa-venus"></i> Data Ibu</div>
                        <div class="grid-gap-20" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                            <div class="form-group">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" name="nama_ibu" value="{{ $data->nama_ibu }}" class="form-control"
                                    maxlength="250">
                            </div>
                            <div class="form-group">
                                <label class="form-label">NIK Ibu</label>
                                <input type="text" name="nik_ibu" value="{{ $data->nik_ibu }}" class="form-control"
                                    maxlength="16" minlength="16">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tempat Lahir Ibu</label>
                                <input type="text" name="tempat_lahir_ibu" value="{{ $data->tempat_lahir_ibu }}"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir Ibu</label>
                                <input type="date" name="tanggal_lahir_ibu" value="{{ $data->tanggal_lahir_ibu }}"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pendidikan Ibu</label>
                                <select name="pendidikan_terakhir_ibu" class="form-select">
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
                                <label class="form-label">Pekerjaan Ibu</label>
                                <input type="text" name="pekerjaan_ibu" value="{{ $data->pekerjaan_ibu }}"
                                    class="form-control" maxlength="100">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Penghasilan Ibu</label>
                                <select name="penghasilan_ibu" class="form-select">
                                    <option value="< 1 Juta"
                                        {{ old('penghasilan_ibu', $data->penghasilan_ibu) == '< 1 Juta' ? 'selected' : '' }}>
                                        < 1 Juta</option>
                                    <option value="1 - 3 Juta"
                                        {{ old('penghasilan_ibu', $data->penghasilan_ibu) == '1 - 3 Juta' ? 'selected' : '' }}>
                                        1 - 3 Juta</option>
                                    <option value="3 - 5 Juta"
                                        {{ old('penghasilan_ibu', $data->penghasilan_ibu) == '3 - 5 Juta' ? 'selected' : '' }}>
                                        3 - 5 Juta</option>
                                    <option value="> 5 Juta"
                                        {{ old('penghasilan_ibu', $data->penghasilan_ibu) == '> 5 Juta' ? 'selected' : '' }}>
                                        > 5 Juta</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No HP Ibu</label>
                                <input type="text" name="no_hp_ibu" value="{{ $data->no_hp_ibu }}" class="form-control"
                                    maxlength="15">
                            </div>
                            <div class="form-group col-span-full">
                                <label class="form-label">Alamat Lengkap Ibu</label>
                                <textarea name="alamat_lengkap_ibu" class="form-control" rows="2" maxlength="250">{{ $data->alamat_lengkap_ibu }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status & Dokumen --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-file-contract"></i> Status & Data Lainnya</h3>
                </div>
                <div class="grid-gap-20" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                    <div class="form-group">
                        <label class="form-label">Status Lock Data</label>
                        <select name="is_locked" class="form-select">
                            <option value="1" {{ $data->is_locked ? 'selected' : '' }}>Terkunci (User tidak bisa edit)
                            </option>
                            <option value="0" {{ !$data->is_locked ? 'selected' : '' }}>Buka (User bisa edit)
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. KK</label>
                        <input type="text" name="no_kk" value="{{ $data->no_kk }}" class="form-control"
                            maxlength="16" minlength="16">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" value="{{ $data->kode_pos }}" class="form-control"
                            maxlength="10">
                    </div>
                    <div class="form-group col-span-full">
                        <label class="form-label">Keterangan Admin</label>
                        <textarea name="keterangan" class="form-control" rows="3" maxlength="250">{{ $data->keterangan }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Update Berkas --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-folder-open"></i> Update Berkas</h3>
                </div>
                <div class="alert" style="background: #eff6ff; color: #1e40af; border: 1px solid #dbeafe; margin-bottom: 20px;">
                    <i class="fa-solid fa-info-circle"></i> Kosongkan jika tidak ingin mengganti file yang sudah ada.
                </div>
                
                <div class="grid-gap-20" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
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
                        <div class="form-group">
                            <label class="form-label">{{ $label }}</label>
                            <input type="file" name="{{ $field }}" class="form-control">
                            @if ($data->$field)
                                <div class="mt-3">
                                    <a href="{{ asset('Berkas/' . $data->$field) }}" target="_blank"
                                        class="text-sm text-primary" style="text-decoration: none;">
                                        <i class="fa-solid fa-eye"></i> Lihat File Lama
                                    </a>
                                </div>
                            @else
                                <div class="mt-3 text-sm text-muted">
                                    <i class="fa-solid fa-times-circle"></i> Belum ada file
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card" style="position: sticky; bottom: 20px; z-index: 99;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="text-muted text-sm"><i class="fa-solid fa-info-circle"></i> Pastikan data sudah benar sebelum menyimpan.</span>
                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    @session('success')
        <script>
            alert("Berhasil mengupdate data");
        </script>
    @endsession
@endsection