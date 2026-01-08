@extends('admin.layouts.master')

@section('title', 'Tahun Ajaran')

@section('content')
<div class="page-title">
  <div>
    <h1>Tahun Ajaran</h1>
    <p>Kelola tahun ajaran penerimaan santri baru.</p>
  </div>
  <div class="actions">
    <button class="btn primary" onclick="document.getElementById('addYearModal').style.display='flex'">
      <span class="icon">
        <i class="fa-solid fa-plus"></i>
      </span>
      Tambah Tahun Ajaran
    </button>
  </div>
</div>

@if(session('success'))
<div class="alert success" style="margin-bottom: 20px; padding: 12px; background: #d1fae5; color: #065f46; border-radius: 8px; border: 1px solid #a7f3d0;">
  {{ session('success') }}
</div>
@endif

<div class="card">
  <table class="table" style="width: 100%; border-collapse: collapse;">
    <thead>
      <tr style="border-bottom: 1px solid #e2e8f0; text-align: left;">
        <th style="padding: 12px 16px;">Tahun Ajaran</th>
        <th style="padding: 12px 16px;">Status</th>
        <th style="padding: 12px 16px; text-align: right;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($tahunAjarans as $tahun)
      <tr style="border-bottom: 1px solid #f1f5f9;">
        <td style="padding: 12px 16px;"><strong>{{ $tahun->nama }}</strong></td>
        <td style="padding: 12px 16px;">
          @if($tahun->is_active)
            <span style="display: inline-block; padding: 4px 10px; border-radius: 99px; font-size: 12px; font-weight: 600; background: #dcfce7; color: #166534;">Aktif</span>
          @else
            <span style="display: inline-block; padding: 4px 10px; border-radius: 99px; font-size: 12px; font-weight: 600; background: #f1f5f9; color: #64748b;">Non-aktif</span>
          @endif
        </td>
        <td style="padding: 12px 16px; text-align: right;">
          <form action="{{ route('admin.tahun.updateStatus', $tahun->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('PATCH')
            @if($tahun->is_active)
              <button type="submit" class="icon-btn" title="Nonaktifkan" style="color: #10b981;">
                <i class="fa-solid fa-toggle-on fa-lg"></i>
              </button>
            @else
              <button type="submit" class="icon-btn" title="Aktifkan" style="color: #cbd5e1;">
                <i class="fa-solid fa-toggle-off fa-lg"></i>
              </button>
            @endif
          </form>
          
          <form action="{{ route('admin.tahun.destroy', $tahun->id) }}" method="POST" style="display:inline-block; margin-left: 8px;" onsubmit="return confirm('Hapus tahun ajaran ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="icon-btn danger" title="Hapus">
              <i class="fa-solid fa-trash"></i>
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="3" style="text-align: center; padding: 30px; color: var(--muted);">Belum ada data tahun ajaran.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Modal Tambah --}}
<div id="addYearModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center;">
  <div class="modal" style="background: white; width: 100%; max-width: 400px; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); overflow: hidden;">
    <header style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #e2e8f0;">
      <strong style="font-size: 16px;">Tambah Tahun Ajaran</strong>
      <button type="button" class="icon-btn" onclick="document.getElementById('addYearModal').style.display='none'">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </header>
    <form action="{{ route('admin.tahun.store') }}" method="POST">
      @csrf
      <div class="body" style="padding: 20px;">
        <div class="form-group" style="margin-bottom: 16px;">
          <label for="nama" style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px;">Nama Tahun Ajaran</label>
          <input type="text" name="nama" id="nama" placeholder="Contoh: 2025/2026" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 14px;">
        </div>
        <div class="form-group">
          <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
            <input type="checkbox" name="is_active" value="1" style="width: 16px; height: 16px; cursor: pointer;">
            <span style="font-size: 14px;">Set sebagai Aktif</span>
          </label>
          <p style="font-size: 12px; color: #64748b; margin-top: 6px; margin-left: 26px;">Jika diaktifkan, tahun ajaran lain akan otomatis menjadi non-aktif.</p>
        </div>
      </div>
      <div class="footer" style="padding: 16px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right; display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn" onclick="document.getElementById('addYearModal').style.display='none'" style="background: white; border: 1px solid #cbd5e1; padding: 8px 16px; border-radius: 8px; font-weight: 500; cursor: pointer;">Batal</button>
        <button type="submit" class="btn primary" style="background: var(--primary, #0f766e); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 500; cursor: pointer;">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
