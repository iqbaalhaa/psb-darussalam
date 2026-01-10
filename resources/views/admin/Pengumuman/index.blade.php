@extends('admin.layouts.master')

@section('title', 'Pengumuman')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Pengumuman</h1>
            <p>Kelola pengumuman ponpes.</p>
        </div>
        <div class="actions">
            <a class="btn-save" href="{{ url('/admin/pengumuman/create') }}">
                <i class="fa-solid fa-plus"></i>
                Tambah Pengumuman
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumumans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->judul }}
                            </td>
                            <td>{{ date('d F Y', strtotime($item->tanggal)) }}
                            </td>
                            <td>

                                <a href="{{ url('admin/pengumuman/' . $item->id) }}" class="action-btn edit"
                                    title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ url('admin/pengumuman/' . $item->id) }}" method="POST"
                                    style="display:inline-block; margin-left: 8px;"
                                    onsubmit="return confirm('Hapus berita ini?')">
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
                            <td colspan="3" style="text-align: center; padding: 30px; color: var(--text-light);">Belum
                                ada data tahun ajaran.</td>
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
                <button type="button" class="close-modal"
                    onclick="document.getElementById('addYearModal').style.display='none'">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="{{ route('admin.tahun.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Tahun Ajaran</label>
                        <input type="text" name="nama" id="nama" class="form-input"
                            placeholder="Contoh: 2025/2026" required>
                    </div>
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1"
                                style="width: 16px; height: 16px; cursor: pointer;">
                            <span style="font-size: 14px; font-weight: 500;">Set sebagai Aktif</span>
                        </label>
                        <p style="font-size: 12px; color: var(--text-light); margin-top: 6px; margin-left: 26px;">Jika
                            diaktifkan, tahun ajaran lain akan otomatis menjadi non-aktif.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel"
                        onclick="document.getElementById('addYearModal').style.display='none'">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
