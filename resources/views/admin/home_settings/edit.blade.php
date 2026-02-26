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

      <div class="card" style="grid-column: 1 / -1;">
        <h3>Jadwal Seleksi &amp; Gelombang</h3>
        <form action="{{ route('admin.home-settings.update') }}" method="POST" class="form-grid">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="jadwal_title" class="form-label">Judul Bagian</label>
            <input type="text" id="jadwal_title" name="jadwal_title" class="form-control"
              value="{{ old('jadwal_title', $setting->jadwal_title ?? 'Jadwal Seleksi & Gelombang') }}">
          </div>

          <div class="form-group">
            <label for="jadwal_subtitle" class="form-label">Subjudul</label>
            <textarea id="jadwal_subtitle" name="jadwal_subtitle" rows="2" class="form-control">{{ old('jadwal_subtitle', $setting->jadwal_subtitle ?? 'Masih contoh. Nanti tinggal ganti tanggalnya.') }}</textarea>
          </div>

          @php
            $rows = old('jadwal_gelombang') ? collect(old('jadwal_gelombang'))->map(function ($val, $i) {
                return [
                    'gelombang' => $val,
                    'pendaftaran' => old('jadwal_pendaftaran')[$i] ?? '',
                    'tes' => old('jadwal_tes')[$i] ?? '',
                    'pengumuman' => old('jadwal_pengumuman')[$i] ?? '',
                    'kuota' => old('jadwal_kuota')[$i] ?? '',
                ];
            })->toArray() : ($setting->jadwal_rows ?? [
                ['gelombang' => 'Gelombang 1', 'pendaftaran' => '1 Feb – 15 Mar 2026', 'tes' => '22 Mar 2026', 'pengumuman' => '25 Mar 2026', 'kuota' => '30'],
                ['gelombang' => 'Gelombang 2', 'pendaftaran' => '1 Apr – 15 Mei 2026', 'tes' => '24 Mei 2026', 'pengumuman' => '27 Mei 2026', 'kuota' => '30'],
            ]);
            $maxRows = max(count($rows), 2);
          @endphp

          <div id="jadwal-rows" class="grid" style="grid-template-columns: 1fr;">
            @for ($i = 0; $i < $maxRows; $i++)
              <div class="fieldset jadwal-row" style="border:1px solid #e2e8f0; padding:12px; border-radius:12px; margin-bottom:12px;">
                <div class="grid" style="grid-template-columns: repeat(5, minmax(0, 1fr)); gap:12px;">
                  <div class="form-group">
                    <label class="form-label">Gelombang</label>
                    <input type="text" name="jadwal_gelombang[]" class="form-control"
                      value="{{ $rows[$i]['gelombang'] ?? '' }}" placeholder="Gelombang 1">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Pendaftaran</label>
                    <input type="text" name="jadwal_pendaftaran[]" class="form-control"
                      value="{{ $rows[$i]['pendaftaran'] ?? '' }}" placeholder="1 Feb – 15 Mar 2026">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Tes</label>
                    <input type="text" name="jadwal_tes[]" class="form-control"
                      value="{{ $rows[$i]['tes'] ?? '' }}" placeholder="22 Mar 2026">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Pengumuman</label>
                    <input type="text" name="jadwal_pengumuman[]" class="form-control"
                      value="{{ $rows[$i]['pengumuman'] ?? '' }}" placeholder="25 Mar 2026">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Kuota</label>
                    <input type="text" name="jadwal_kuota[]" class="form-control"
                      value="{{ $rows[$i]['kuota'] ?? '' }}" placeholder="30">
                  </div>
                </div>
                <div style="display:flex; gap:8px; margin-top:8px; justify-content:flex-end;">
                  <button type="button" class="btn" data-remove-row>
                    <i class="fa-solid fa-trash"></i>
                    Hapus Baris
                  </button>
                </div>
              </div>
            @endfor
          </div>

          <div class="form-group" style="margin: 8px 0 16px;">
            <button type="button" class="btn" id="btn-add-row">
              <i class="fa-solid fa-plus"></i>
              Tambah Baris
            </button>
          </div>

          <div class="form-group">
            <label for="jadwal_note" class="form-label">Catatan</label>
            <textarea id="jadwal_note" name="jadwal_note" rows="2" class="form-control">{{ old('jadwal_note', $setting->jadwal_note ?? 'Kuota terbatas. Disarankan daftar lebih awal untuk memilih jadwal tes yang sesuai.') }}</textarea>
          </div>

          <div class="form-group" style="margin-top: 12px;">
            <button type="submit" class="btn primary">Simpan Jadwal</button>
          </div>
        </form>
      </div>

      @push('scripts')
      <template id="tpl-jadwal-row">
        <div class="fieldset jadwal-row" style="border:1px solid #e2e8f0; padding:12px; border-radius:12px; margin-bottom:12px;">
          <div class="grid" style="grid-template-columns: repeat(5, minmax(0, 1fr)); gap:12px;">
            <div class="form-group">
              <label class="form-label">Gelombang</label>
              <input type="text" name="jadwal_gelombang[]" class="form-control" placeholder="Gelombang 3">
            </div>
            <div class="form-group">
              <label class="form-label">Pendaftaran</label>
              <input type="text" name="jadwal_pendaftaran[]" class="form-control" placeholder="1 Jun – 15 Jul 2026">
            </div>
            <div class="form-group">
              <label class="form-label">Tes</label>
              <input type="text" name="jadwal_tes[]" class="form-control" placeholder="22 Jul 2026">
            </div>
            <div class="form-group">
              <label class="form-label">Pengumuman</label>
              <input type="text" name="jadwal_pengumuman[]" class="form-control" placeholder="25 Jul 2026">
            </div>
            <div class="form-group">
              <label class="form-label">Kuota</label>
              <input type="text" name="jadwal_kuota[]" class="form-control" placeholder="30">
            </div>
          </div>
          <div style="display:flex; gap:8px; margin-top:8px; justify-content:flex-end;">
            <button type="button" class="btn" data-remove-row>
              <i class="fa-solid fa-trash"></i>
              Hapus Baris
            </button>
          </div>
        </div>
      </template>
      <script>
        (function () {
          const container = document.getElementById('jadwal-rows');
          const btnAdd = document.getElementById('btn-add-row');
          const tpl = document.getElementById('tpl-jadwal-row');

          function attachRemoveHandlers(scope) {
            scope.querySelectorAll('[data-remove-row]').forEach(btn => {
              btn.addEventListener('click', () => {
                const fieldset = btn.closest('.jadwal-row');
                if (fieldset) fieldset.remove();
              });
            });
          }

          attachRemoveHandlers(container);

          btnAdd?.addEventListener('click', () => {
            const node = tpl.content.cloneNode(true);
            container.appendChild(node);
            attachRemoveHandlers(container);
          });
        })();
      </script>
      @endpush

      <div class="card" style="grid-column: 1 / -1;">
        <h3>Program: Visi, Misi &amp; Unggulan</h3>
        <form action="{{ route('admin.home-settings.update') }}" method="POST" class="form-grid">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label class="form-label" for="program_title">Judul Bagian</label>
            <input type="text" id="program_title" name="program_title" class="form-control"
              value="{{ old('program_title', $setting->program_title ?? 'Visi, Misi & Program Unggulan') }}">
          </div>

          <div class="form-group">
            <label class="form-label" for="program_subtitle">Subjudul</label>
            <textarea id="program_subtitle" name="program_subtitle" rows="2" class="form-control">{{ old('program_subtitle', $setting->program_subtitle ?? 'Ringkasan visi, misi, dan program unggulan MTs & MA Pondok Pesantren DARUSSALAM AL-HAFIDZ.') }}</textarea>
          </div>

          @php
            $tabs = $setting->program_tabs ?? [
                'visi' => [
                    'visi_madrasah' => 'Membentuk generasi muslim yang berilmu, berakhlakul karimah, berdisiplin, dan bertakwa kepada Allah Subhanahu wa Ta’ala.',
                    'arah_pendidikan' => 'Menjadikan MTs & MA Darussalam Al Hafidz sebagai lembaga pendidikan berkualitas yang memadukan ilmu umum dan keislaman dalam suasana pesantren.',
                ],
                'misi' => [
                    'misi_items' => [
                        'Menyelenggarakan pendidikan yang berlandaskan Al-Qur’an dan As-Sunnah.',
                        'Menanamkan akhlakul karimah dan kedisiplinan dalam kehidupan santri.',
                        'Mengembangkan kemampuan akademik, tahfidz, dan keterampilan santri.',
                        'Membiasakan suasana belajar yang islami, tertib, dan penuh kasih sayang.',
                    ],
                    'target_lulusan' => 'Lulusan diharapkan menjadi generasi yang berakidah lurus, mampu membaca dan menghafal Al-Qur’an dengan baik, serta siap melanjutkan pendidikan ke jenjang yang lebih tinggi.',
                ],
                'unggulan' => [
                    'program_unggulan_items' => [
                        'Program Tahfidzul Qur’an.',
                        'Program Madrasah Diniyah.',
                        'Program penguatan bahasa Arab dan Inggris.',
                        'Program pembinaan akhlak dan kedisiplinan santri.',
                        'Program pengembangan minat bakat dan keterampilan.',
                    ],
                    'kegiatan_penunjang_items' => [
                        'Kegiatan keagamaan dan peringatan hari besar Islam.',
                        'Latihan kepemimpinan, organisasi, dan kedisiplinan.',
                        'Olahraga, seni, dan keterampilan lain yang bermanfaat.',
                    ],
                ],
            ];
          @endphp

          <div class="tabs" data-tabs>
            <div class="tabs__list" role="tablist" aria-label="Tab program">
              <button type="button" class="tabs__tab is-active" role="tab" aria-selected="true" aria-controls="tab-visi" id="cms-visi">Visi</button>
              <button type="button" class="tabs__tab" role="tab" aria-selected="false" aria-controls="tab-misi" id="cms-misi">Misi</button>
              <button type="button" class="tabs__tab" role="tab" aria-selected="false" aria-controls="tab-unggulan" id="cms-unggulan">Program Unggulan</button>
            </div>

            <div class="tabs__panels">
              <div class="tabs__panel is-active" role="tabpanel" id="tab-visi" aria-labelledby="cms-visi">
                <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:12px;">
                  <div class="form-group">
                    <label class="form-label" for="visi_1">Visi Madrasah</label>
                    <textarea id="visi_1" name="visi_1" class="form-control" rows="4">{{ old('visi_1', $tabs['visi']['visi_madrasah'] ?? '') }}</textarea>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="visi_2">Arah Pendidikan</label>
                    <textarea id="visi_2" name="visi_2" class="form-control" rows="4">{{ old('visi_2', $tabs['visi']['arah_pendidikan'] ?? '') }}</textarea>
                  </div>
                </div>
              </div>

              <div class="tabs__panel" role="tabpanel" id="tab-misi" aria-labelledby="cms-misi">
                <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:12px;">
                  @php
                    $misiItems = old('misi_items', $tabs['misi']['misi_items'] ?? []);
                    if (!is_array($misiItems)) { $misiItems = []; }
                    if (count($misiItems) === 0) { $misiItems = ['']; }
                  @endphp
                  <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Misi Madrasah</label>
                    <div id="misi-items">
                      @foreach($misiItems as $item)
                        <div class="list-row" style="display:flex; gap:8px; margin-bottom:8px;">
                          <input type="text" name="misi_items[]" class="form-control" value="{{ $item }}" placeholder="Tulis misi...">
                          <button type="button" class="btn" data-remove-row><i class="fa-solid fa-trash"></i></button>
                        </div>
                      @endforeach
                    </div>
                    <button type="button" class="btn" id="btn-add-misi" style="margin-top:6px;">
                      <i class="fa-solid fa-plus"></i> Tambah Baris
                    </button>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="misi_target">Target Lulusan</label>
                    <textarea id="misi_target" name="misi_target" class="form-control" rows="6">{{ old('misi_target', $tabs['misi']['target_lulusan'] ?? '') }}</textarea>
                  </div>
                </div>
              </div>

              <div class="tabs__panel" role="tabpanel" id="tab-unggulan" aria-labelledby="cms-unggulan">
                <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:12px;">
                  @php
                    $unggulanProgramItems = old('unggulan_program_items', $tabs['unggulan']['program_unggulan_items'] ?? []);
                    if (!is_array($unggulanProgramItems)) { $unggulanProgramItems = []; }
                    if (count($unggulanProgramItems) === 0) { $unggulanProgramItems = ['']; }
                    $unggulanKegiatanItems = old('unggulan_kegiatan_items', $tabs['unggulan']['kegiatan_penunjang_items'] ?? []);
                    if (!is_array($unggulanKegiatanItems)) { $unggulanKegiatanItems = []; }
                    if (count($unggulanKegiatanItems) === 0) { $unggulanKegiatanItems = ['']; }
                  @endphp
                  <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Program Unggulan</label>
                    <div id="unggulan-program-items">
                      @foreach($unggulanProgramItems as $item)
                        <div class="list-row" style="display:flex; gap:8px; margin-bottom:8px;">
                          <input type="text" name="unggulan_program_items[]" class="form-control" value="{{ $item }}" placeholder="Tulis program unggulan...">
                          <button type="button" class="btn" data-remove-row><i class="fa-solid fa-trash"></i></button>
                        </div>
                      @endforeach
                    </div>
                    <button type="button" class="btn" id="btn-add-unggulan-program" style="margin-top:6px;">
                      <i class="fa-solid fa-plus"></i> Tambah Baris
                    </button>
                  </div>
                  <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Kegiatan Penunjang</label>
                    <div id="unggulan-kegiatan-items">
                      @foreach($unggulanKegiatanItems as $item)
                        <div class="list-row" style="display:flex; gap:8px; margin-bottom:8px;">
                          <input type="text" name="unggulan_kegiatan_items[]" class="form-control" value="{{ $item }}" placeholder="Tulis kegiatan penunjang...">
                          <button type="button" class="btn" data-remove-row><i class="fa-solid fa-trash"></i></button>
                        </div>
                      @endforeach
                    </div>
                    <button type="button" class="btn" id="btn-add-unggulan-kegiatan" style="margin-top:6px;">
                      <i class="fa-solid fa-plus"></i> Tambah Baris
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group" style="margin-top: 12px;">
            <button type="submit" class="btn primary">Simpan Program</button>
          </div>
        </form>
      </div>

      @push('scripts')
      <script>
        (function () {
          function initList(containerId, addBtnId, inputName, placeholder) {
            const container = document.getElementById(containerId);
            const btnAdd = document.getElementById(addBtnId);
            function attachRemove(scope) {
              (scope || container).querySelectorAll('[data-remove-row]').forEach(btn => {
                btn.addEventListener('click', () => {
                  const row = btn.closest('.list-row');
                  if (row) row.remove();
                });
              });
            }
            attachRemove(container);
            btnAdd?.addEventListener('click', () => {
              const row = document.createElement('div');
              row.className = 'list-row';
              row.style.cssText = 'display:flex; gap:8px; margin-bottom:8px;';
              row.innerHTML = `
                <input type="text" name="${inputName}[]" class="form-control" placeholder="${placeholder}">
                <button type="button" class="btn" data-remove-row><i class="fa-solid fa-trash"></i></button>
              `;
              container.appendChild(row);
              attachRemove(row);
            });
          }
          initList('misi-items', 'btn-add-misi', 'misi_items', 'Tulis misi...');
          initList('unggulan-program-items', 'btn-add-unggulan-program', 'unggulan_program_items', 'Tulis program unggulan...');
          initList('unggulan-kegiatan-items', 'btn-add-unggulan-kegiatan', 'unggulan_kegiatan_items', 'Tulis kegiatan penunjang...');

          document.querySelectorAll('.tabs [role="tab"]').forEach(tab => {
            tab.addEventListener('click', () => {
              const root = tab.closest('.tabs');
              const list = root.querySelectorAll('.tabs__tab');
              const panels = root.querySelectorAll('.tabs__panel');
              list.forEach(b => {
                b.classList.remove('is-active');
                b.setAttribute('aria-selected', 'false');
              });
              panels.forEach(p => p.classList.remove('is-active'));
              tab.classList.add('is-active');
              tab.setAttribute('aria-selected', 'true');
              const id = tab.getAttribute('aria-controls');
              const panel = root.querySelector('#' + id);
              if (panel) panel.classList.add('is-active');
            });
          });
        })();
      </script>
      @endpush

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
