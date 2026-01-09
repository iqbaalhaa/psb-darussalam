@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
@php
    $year   = date('Y');
    $target = 170;

    $total  = (int) ($totalPendaftar ?? 0);
    $pending= (int) ($totalPending ?? 0);
    $ok     = (int) ($totalDiterima ?? 0);
    $no     = (int) ($totalDitolak ?? 0);

    $safeTotal = max(1, $total);

    $pTarget  = min(100, (int) round(($total / max(1,$target)) * 100));
    $pPending = min(100, (int) round(($pending / $safeTotal) * 100));
    $pOk      = min(100, (int) round(($ok / $safeTotal) * 100));
    $pNo      = min(100, (int) round(($no / $safeTotal) * 100));
@endphp

<div class="dash-header">
    <div class="dash-title">
        <h1>Dashboard</h1>
        <p>Ringkasan penerimaan santri baru — cepat, rapi, dan minim ribet.</p>
    </div>

    <div class="dash-actions">
        <a class="btn" href="{{ route('admin.pendaftar.index') }}">
            <!-- icon -->
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Lihat Data Pendaftar
        </a>
        <button class="btn primary" type="button" onclick="alert('Nanti: Export laporan')">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path d="M12 3v10m0 0 4-4m-4 4-4-4M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Export Rekap
        </button>
    </div>
</div>

<div class="dash-grid">
    {{-- KPI: Total --}}
    <div class="card span-3">
        <h3>Total Pendaftar Tahun {{ $year }}</h3>

        <div class="kpi">
            <div class="kpi-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <div class="kpi-title">Jumlah pendaftar</div>
                <div class="kpi-value">{{ number_format($total) }}</div>
                <div class="kpi-meta">
                    <span class="chip info dot">Target {{ $target }} ({{ $pTarget }}%)</span>
                </div>
            </div>
        </div>

        <div class="bar" aria-label="Progress target">
            <span style="width: {{ $pTarget }}%"></span>
        </div>
    </div>

    {{-- KPI: Pending --}}
    <div class="card span-3">
        <h3>Menunggu Verifikasi</h3>

        <div class="kpi">
            <div class="kpi-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 8v4l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <div>
                <div class="kpi-title">Belum dicek</div>
                <div class="kpi-value">{{ number_format($pending) }}</div>
                <div class="kpi-meta">
                    <span class="chip warning dot">{{ $pPending }}% dari total</span>
                </div>
            </div>
        </div>

        <div class="bar" aria-label="Progress pending">
            <span style="width: {{ $pPending }}%"></span>
        </div>
    </div>

    {{-- KPI: Diterima --}}
    <div class="card span-3">
        <h3>Diterima</h3>

        <div class="kpi">
            <div class="kpi-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <div class="kpi-title">Lolos seleksi</div>
                <div class="kpi-value">{{ number_format($ok) }}</div>
                <div class="kpi-meta">
                    <span class="chip success dot">{{ $pOk }}% dari total</span>
                </div>
            </div>
        </div>

        <div class="bar" aria-label="Progress diterima">
            <span style="width: {{ $pOk }}%"></span>
        </div>
    </div>

    {{-- KPI: Ditolak --}}
    <div class="card span-3">
        <h3>Ditolak</h3>

        <div class="kpi">
            <div class="kpi-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <div class="kpi-title">Tidak lolos</div>
                <div class="kpi-value">{{ number_format($no) }}</div>
                <div class="kpi-meta">
                    <span class="chip danger dot">{{ $pNo }}% dari total</span>
                </div>
            </div>
        </div>

        <div class="bar" aria-label="Progress ditolak">
            <span style="width: {{ $pNo }}%"></span>
        </div>
    </div>

    {{-- Ringkasan Status --}}
    <div class="card span-12 span-lg-8">
        <h3>Ringkasan Status</h3>

        <div class="rows">
            <div class="row-item">
                <div>
                    <strong>Pending Verifikasi</strong>
                    <small>Data menunggu pengecekan admin</small>
                </div>
                <span class="chip warning dot">{{ number_format($pending) }}</span>
            </div>

            <div class="row-item">
                <div>
                    <strong>Diterima</strong>
                    <small>Sudah ditetapkan lolos</small>
                </div>
                <span class="chip success dot">{{ number_format($ok) }}</span>
            </div>

            <div class="row-item">
                <div>
                    <strong>Ditolak</strong>
                    <small>Belum memenuhi syarat / tidak lolos</small>
                </div>
                <span class="chip danger dot">{{ number_format($no) }}</span>
            </div>
        </div>

        <div class="mini-actions">
            <a class="btn" href="{{ route('admin.pendaftar.index') }}">Kelola Pendaftar</a>
            <button class="btn" type="button" onclick="alert('Nanti: halaman Verifikasi Pending')">Verifikasi Pending</button>
        </div>

        <p class="muted" style="margin:12px 0 0;">Update terakhir: hari ini</p>
    </div>

    {{-- Info / Notes --}}
    <div class="card span-12 span-lg-4">
        <h3>Info</h3>
        <p class="muted" style="margin:0 0 10px;">
            Dashboard ini sudah siap dipakai untuk data real. Tinggal sambungkan ke tabel registrations / documents / statuses.
        </p>

        <div class="rows">
            <div class="row-item">
                <div>
                    <strong>Saran Next</strong>
                    <small>Tambah grafik per hari & filter per gelombang</small>
                </div>
                <span class="chip info dot">Roadmap</span>
            </div>
            <div class="row-item">
                <div>
                    <strong>Keamanan</strong>
                    <small>Batasi akses export + audit log</small>
                </div>
                <span class="chip dot">Checklist</span>
            </div>
        </div>
    </div>
</div>
@endsection
