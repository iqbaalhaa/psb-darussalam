@extends('admin.layouts.master')

@section('title', 'Tahun Ajaran')

@section('content')
<div class="page-header">
  <div class="page-title">
    <h1>Tahun Ajaran</h1>
    <p>Kelola tahun ajaran penerimaan santri baru.</p>
  </div>
  <div class="actions">
    <button class="btn-save" onclick="document.getElementById('addYearModal').style.display='flex'">
      <i class="fa-solid fa-plus"></i>
      Tambah Tahun Ajaran
    </button>
  </div>
</div>

@if(session('success'))
<div class="alert success">
  {{ session('success') }}
</div>
@endif

<div class="table-card">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Tahun Ajaran</th>
          <th>Status</th>
          <th style="text-align: right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tahunAjarans as $tahun)
        <tr>
          <td><strong>{{ $tahun->nama }}</strong></td>
          <td>
            @if($tahun->is_active)
              <span class="status-badge active">Aktif</span>
            @else
              <span class="status-badge inactive">Non-aktif</span>
            @endif
          </td>
          <td style="text-align: right;">
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
          <td colspan="3" style="text-align: center; padding: 30px; color: var(--text-light);">Belum ada data tahun ajaran.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Modal Tambah --}}
<div id="addYearModal" class="modal-backdrop">
  <div class="modal-content">
    <div class="modal-header">
      <strong class="modal-title">Tambah Tahun Ajaran</strong>
      <button type="button" class="close-modal" onclick="document.getElementById('addYearModal').style.display='none'">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <form action="{{ route('admin.tahun.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label for="nama" class="form-label">Nama Tahun Ajaran</label>
          <input type="text" name="nama" id="nama" class="form-input" placeholder="Contoh: 2025/2026" required>
        </div>
        <div class="form-group">
          <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
            <input type="checkbox" name="is_active" value="1" style="width: 16px; height: 16px; cursor: pointer;">
            <span style="font-size: 14px; font-weight: 500;">Set sebagai Aktif</span>
          </label>
          <p style="font-size: 12px; color: var(--text-light); margin-top: 6px; margin-left: 26px;">Jika diaktifkan, tahun ajaran lain akan otomatis menjadi non-aktif.</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="document.getElementById('addYearModal').style.display='none'">Batal</button>
        <button type="submit" class="btn-save">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
