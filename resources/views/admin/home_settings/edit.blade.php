@extends('admin.layouts.master')

@section('title', 'Home CMS')

@section('content')
    <div class="page-title" style="display:flex; align-items:flex-start; justify-content:space-between;">
        <div>
            <h1>Home Content Management</h1>
            <p>Atur teks hero, link brosur, dan informasi WhatsApp untuk halaman utama.</p>
        </div>
        <div class="actions" style="display:flex; gap:10px;">
            <a href="{{ route('admin.dashboard') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert success" style="margin-bottom: 16px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid">
      <div class="card" style="grid-column: span 7 / span 7;">
        <h3>Hero Section</h3>
        <form action="{{ route('admin.home-settings.update') }}" method="POST" class="form-grid" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="hero_title" class="form-label">Judul Utama</label>
            <input type="text" id="hero_title" name="hero_title"
              value="{{ old('hero_title', $setting->hero_title ?? '') }}"
              placeholder="Misal: Menerima Santri Baru MTs &amp; MA"
              class="form-control" />
          </div>

          <div class="form-group">
            <label for="hero_lead" class="form-label">Teks Singkat (Lead)</label>
            <textarea id="hero_lead" name="hero_lead" rows="3"
              placeholder="Teks singkat di bawah judul."
              class="form-control">{{ old('hero_lead', $setting->hero_lead ?? '') }}</textarea>
          </div>

          <div class="form-group">
            <label for="hero_muted" class="form-label">Teks Penjelas</label>
            <textarea id="hero_muted" name="hero_muted" rows="3"
              placeholder="Paragraf penjelas kecil."
              class="form-control">{{ old('hero_muted', $setting->hero_muted ?? '') }}</textarea>
          </div>

          <div class="form-group">
            <label for="brochure_url" class="form-label">URL Brosur (opsional)</label>
            <input type="text" id="brochure_url" name="brochure_url"
              value="{{ old('brochure_url', $setting->brochure_url ?? '') }}"
              placeholder="contoh: {{ asset('landing/brosur-psb.pdf') }}"
              class="form-control" />
            <p class="text-muted" style="font-size: 12px; margin-top: 4px;">
              Jika diisi, tombol &quot;Lihat Brosur Lengkap&quot; di halaman home akan mengarah ke URL ini.
            </p>
          </div>

          <div class="form-group">
            <label for="hero_chip_location" class="form-label">Chip Lokasi</label>
            <input type="text" id="hero_chip_location" name="hero_chip_location"
              value="{{ old('hero_chip_location', $setting->hero_chip_location ?? '') }}"
              placeholder="Misal: Kenali Asam Atas, Kota Jambi"
              class="form-control" />
          </div>

          <div class="form-group">
            <label for="hero_chip_jenjang" class="form-label">Chip Jenjang</label>
            <input type="text" id="hero_chip_jenjang" name="hero_chip_jenjang"
              value="{{ old('hero_chip_jenjang', $setting->hero_chip_jenjang ?? '') }}"
              placeholder="Misal: MTs &amp; MA"
              class="form-control" />
          </div>

          <div class="form-group">
            <label for="hero_chip_program" class="form-label">Chip Program</label>
            <input type="text" id="hero_chip_program" name="hero_chip_program"
              value="{{ old('hero_chip_program', $setting->hero_chip_program ?? '') }}"
              placeholder="Misal: Formal &amp; Non Formal"
              class="form-control" />
          </div>

          <div class="form-group">
            <label for="hero_image" class="form-label">Foto Hero</label>
            <input type="file" id="hero_image" name="hero_image" accept="image/*" class="form-control" />
            @if (!empty($setting->hero_image_path))
              <div style="margin-top:8px; display:flex; align-items:center; gap:10px;">
                <div style="width:80px; height:80px; border-radius:16px; overflow:hidden; border:1px solid #e2e8f0;">
                  <img src="{{ asset($setting->hero_image_path) }}" alt="Hero" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div style="font-size:12px; color:#64748b;">
                  {{ $setting->hero_image_path }}
                </div>
              </div>
            @endif
            <p class="text-muted" style="font-size: 12px; margin-top: 4px;">
              Maksimal 2 MB, format jpg, jpeg, png, atau webp.
            </p>
          </div>

          <div class="form-group" style="margin-top: 12px;">
            <button type="submit" class="btn primary">
              Simpan Pengaturan
            </button>
          </div>
        </form>
      </div>

      <div class="card" style="grid-column: span 5 / span 5;">
        <h3>WhatsApp Info</h3>
        <form action="{{ route('admin.home-settings.update') }}" method="POST" class="form-grid">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="wa_number_display" class="form-label">Nomor WA (Tampilan)</label>
            <input type="text" id="wa_number_display" name="wa_number_display"
              value="{{ old('wa_number_display', $setting->wa_number_display ?? '') }}"
              placeholder="contoh: 0821-7360-4012"
              class="form-control" />
          </div>

          <div class="form-group">
            <label for="wa_number_e164" class="form-label">Nomor WA (Format 62)</label>
            <input type="text" id="wa_number_e164" name="wa_number_e164"
              value="{{ old('wa_number_e164', $setting->wa_number_e164 ?? '') }}"
              placeholder="contoh: 6282173604012"
              class="form-control" />
            <p class="text-muted" style="font-size: 12px; margin-top: 4px;">
              Tanpa tanda + dan tanpa 0 depan. Dipakai untuk link <code>wa.me</code>.
            </p>
          </div>

          <div class="form-group">
            <label for="wa_default_text" class="form-label">Teks Default WhatsApp</label>
            <textarea id="wa_default_text" name="wa_default_text" rows="4"
              placeholder="Teks pesan default ketika orang mengklik tombol WhatsApp."
              class="form-control">{{ old('wa_default_text', $setting->wa_default_text ?? '') }}</textarea>
          </div>

          <div class="form-group" style="margin-top: 12px;">
            <button type="submit" class="btn primary">
              Simpan Pengaturan WA
            </button>
          </div>
        </form>
      </div>

      <div class="card" style="grid-column: 1 / -1;">
        <h3>Biaya & Syarat Pendaftaran</h3>
        <form action="{{ route('admin.home-settings.update') }}" method="POST" class="form-grid">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="biaya_formal_total" class="form-label">Total Biaya Awal Program Formal</label>
            <input type="text" id="biaya_formal_total" name="biaya_formal_total"
              value="{{ old('biaya_formal_total', $setting->biaya_formal_total ?? 'Rp 5.500.000') }}"
              class="form-control" />
          </div>

          <div class="form-group">
            <label for="biaya_nonformal_total" class="form-label">Total Biaya Awal Program Non Formal</label>
            <input type="text" id="biaya_nonformal_total" name="biaya_nonformal_total"
              value="{{ old('biaya_nonformal_total', $setting->biaya_nonformal_total ?? 'Rp 4.350.000') }}"
              class="form-control" />
          </div>

          <div class="form-group">
            <label for="biaya_formal_items" class="form-label">Rincian Singkat Biaya Formal (satu per baris)</label>
            <textarea id="biaya_formal_items" name="biaya_formal_items" rows="3"
              class="form-control">{{ old('biaya_formal_items', $setting->biaya_formal_items ?? "Pendaftaran.\nUang makan (maṣlahah bulanan).\nSeragam (3 set gamis).\nPerlengkapan asrama dan belajar.\nPos-pos lain sesuai kebijakan pesantren.") }}</textarea>
          </div>

          <div class="form-group">
            <label for="biaya_nonformal_items" class="form-label">Rincian Singkat Biaya Non Formal (satu per baris)</label>
            <textarea id="biaya_nonformal_items" name="biaya_nonformal_items" rows="3"
              class="form-control">{{ old('biaya_nonformal_items', $setting->biaya_nonformal_items ?? "Pendaftaran.\nUang makan (maṣlahah bulanan).\nSeragam.\nPerlengkapan asrama dan belajar.\nPos-pos lain sesuai kebijakan pesantren.") }}</textarea>
          </div>

          <div class="form-group">
            <label for="syarat_umum_items" class="form-label">Syarat Umum (satu per baris)</label>
            <textarea id="syarat_umum_items" name="syarat_umum_items" rows="3"
              class="form-control">{{ old('syarat_umum_items', $setting->syarat_umum_items ?? "Mengisi formulir pendaftaran santri baru.\nSiap mengikuti tata tertib pondok pesantren.\nSiap mengikuti kegiatan belajar mengajar dan kehidupan asrama.\nMengikuti tes seleksi dan wawancara sesuai jadwal.") }}</textarea>
          </div>

          <div class="form-group">
            <label for="berkas_items" class="form-label">Berkas yang Dibutuhkan (satu per baris)</label>
            <textarea id="berkas_items" name="berkas_items" rows="3"
              class="form-control">{{ old('berkas_items', $setting->berkas_items ?? "Fotokopi ijazah/STTB atau surat keterangan lulus.\nFotokopi raport terakhir.\nFotokopi Kartu Keluarga dan Akta Kelahiran.\nPas foto ukuran 3x4.\nSurat keterangan sehat dari dokter/puskesmas.") }}</textarea>
          </div>

          <div class="form-group" style="margin-top: 12px;">
            <button type="submit" class="btn primary">
              Simpan Biaya & Syarat
            </button>
          </div>
        </form>
      </div>

      <div class="card" style="grid-column: 1 / -1;">
        <h3>Preview Halaman Home (Versi Tersimpan)</h3>
        <p style="font-size:13px; color:#64748b; margin-bottom:10px;">
          Preview ini menampilkan tampilan home asli menggunakan data yang sudah disimpan.
        </p>
        <div style="border-radius:18px; overflow:hidden; border:1px solid #e2e8f0; background:white;">
          <iframe src="{{ route('home') }}" style="width:100%; height:600px; border:0;" loading="lazy"></iframe>
        </div>
      </div>
    </div>
@endsection
