@extends('admin.layouts.master')

@section('title', 'Laporan Penerimaan Santri Baru')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Laporan PSB</h1>
        <p>Rekapitulasi data pendaftar dan penerimaan santri baru.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa-solid fa-filter"></i> Filter Data
        </h3>
    </div>
    <div class="card-body" style="padding: 20px;">
        <form action="{{ route('admin.laporan.index') }}" method="GET">
            <div class="main-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; align-items: end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <select name="tahun_ajaran" id="tahun_ajaran" class="form-select" style="width: 100%;">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunAjarans as $tahun)
                            <option value="{{ $tahun->nama }}" {{ request('tahun_ajaran') == $tahun->nama ? 'selected' : '' }}>
                                {{ $tahun->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="jenjang" class="form-label">Jenjang</label>
                    <select name="jenjang" id="jenjang" class="form-select" style="width: 100%;">
                        <option value="">Semua Jenjang</option>
                        <option value="MTS" {{ request('jenjang') == 'MTS' ? 'selected' : '' }}>MTS</option>
                        <option value="MA" {{ request('jenjang') == 'MA' ? 'selected' : '' }}>MA</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" style="width: 100%;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="visibility: hidden;">Aksi</label>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn-save" style="flex: 1; justify-content: center;">
                            <i class="fa-solid fa-search"></i> Tampilkan
                        </button>
                        <a href="{{ route('admin.laporan.print', request()->all()) }}" target="_blank" class="btn-save" style="flex: 1; justify-content: center; background-color: #4b5563; border-color: #4b5563;">
                            <i class="fa-solid fa-print"></i> Cetak
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Tanggal Daftar</th>
                    <th>Nama Lengkap</th>
                    <th>Jenjang</th>
                    <th>Asal Sekolah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                <tr>
                    <td>{{ ($laporan->currentPage() - 1) * $laporan->perPage() + $loop->iteration }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $item->nama }}</strong><br>
                        <small class="text-muted">{{ $item->email }}</small>
                    </td>
                    <td>{{ $item->jenjang }}</td>
                    <td>{{ $item->asal_sekolah ?? '-' }}</td>
                    <td>
                        <span class="status-badge {{ $item->status }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-light);">
                        <i class="fa-solid fa-file-circle-xmark" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                        Tidak ada data ditemukan sesuai filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 20px;">
        {{ $laporan->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
