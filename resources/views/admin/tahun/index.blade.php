@extends('admin.layouts.master')

@section('title', 'Tahun Ajaran')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="page-header">
  <div class="page-title">
    <h1>Tahun Ajaran</h1>
    <p>Kelola tahun ajaran penerimaan santri baru.</p>
  </div>
  <div class="actions">
    <button class="btn-save" onclick="document.getElementById('addYearModal').classList.add('show')">
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
    <table class="table" id="table-tahun">
      <thead>
        <tr>
          <th class="w-5">No</th>
          <th class="w-50">Tahun Ajaran</th>
          <th class="w-20">Status</th>
          <th class="w-25 text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tahunAjarans as $tahun)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><span class="fw-600 text-main">{{ $tahun->nama }}</span></td>
          <td>
            @if($tahun->is_active)
              <span class="status-badge active"><i class="fa-solid fa-check-circle"></i> Aktif</span>
            @else
              <span class="status-badge inactive"><i class="fa-solid fa-ban"></i> Non-aktif</span>
            @endif
          </td>
          <td class="text-right">
            <div class="action-btn-group">
                <form action="{{ route('admin.tahun.updateStatus', $tahun->id) }}" method="POST" class="d-inline-block">
                  @csrf
                  @method('PATCH')
                  @if($tahun->is_active)
                    <button type="submit" class="action-btn" title="Nonaktifkan" style="color: var(--danger); border-color: var(--danger);">
                      <i class="fa-solid fa-toggle-on"></i>
                    </button>
                  @else
                    <button type="submit" class="action-btn" title="Aktifkan" style="color: var(--success); border-color: var(--success);">
                      <i class="fa-solid fa-toggle-off"></i>
                    </button>
                  @endif
                </form>
                
                <form action="{{ route('admin.tahun.destroy', $tahun->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus tahun ajaran ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="action-btn" title="Hapus" style="color: var(--danger); border-color: var(--danger);">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="empty-state">Belum ada data tahun ajaran.</td>
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
      <h3 class="modal-title">Tambah Tahun Ajaran</h3>
      <button type="button" class="close-modal" onclick="document.getElementById('addYearModal').classList.remove('show')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <form action="{{ route('admin.tahun.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label for="nama" class="form-label">Nama Tahun Ajaran</label>
          <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: 2025/2026" required>
        </div>
        <div class="form-group">
          <label class="checkbox-wrapper">
            <input type="checkbox" name="is_active" value="1" class="checkbox-input">
            <span class="checkbox-label">Set sebagai Aktif</span>
          </label>
          <p class="checkbox-help">Jika diaktifkan, tahun ajaran lain akan otomatis menjadi non-aktif.</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="document.getElementById('addYearModal').classList.remove('show')">Batal</button>
        <button type="submit" class="btn-save">Simpan</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table-tahun').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    "paginate": {
                        "previous": "<i class='fa-solid fa-chevron-left'></i>",
                        "next": "<i class='fa-solid fa-chevron-right'></i>"
                    }
                },
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": [3] // Kolom Aksi
                }],
                "dom": 'rtip',
                "pageLength": 10
            });
        });
    </script>
@endpush
@endsection
