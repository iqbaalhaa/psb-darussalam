@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
  <div class="page-title">
    <div>
      <h1>Dashboard</h1>
      <p>Ringkasan penerimaan santri baru — cepat, rapi, dan minim ribet.</p>
    </div>
    <div class="actions">
      <a class="btn" href="{{ route('admin.pendaftar.index') }}">Lihat Data Pendaftar</a>
      <button class="btn primary" type="button" onclick="alert('Nanti: Export laporan')">Export Rekap</button>
    </div>
  </div>

  <div class="grid">
    <div class="card" style="grid-column: span 4;">
      <h3>Total Pendaftar</h3>
      <div class="stat">
        <div class="value">128</div>
        <div class="chip">+12 minggu ini</div>
      </div>
      <div class="progress"><div style="width:74%"></div></div>
      <div class="muted" style="margin-top:8px;">Target gelombang: 170</div>
    </div>

    <div class="card" style="grid-column: span 4;">
      <h3>Menunggu Verifikasi</h3>
      <div class="stat">
        <div class="value">34</div>
        <div class="chip">Perlu ditangani</div>
      </div>
      <div class="progress"><div style="width:40%"></div></div>
      <div class="muted" style="margin-top:8px;">Prioritas: berkas kurang lengkap</div>
    </div>

    <div class="card" style="grid-column: span 4;">
      <h3>Diterima</h3>
      <div class="stat">
        <div class="value">67</div>
        <div class="chip">Aman</div>
      </div>
      <div class="progress"><div style="width:52%"></div></div>
      <div class="muted" style="margin-top:8px;">Update terakhir: hari ini</div>
    </div>

    <div class="card" style="grid-column: span 12;">
      <h3>Info</h3>
      <p class="muted" style="margin:0;">Dashboard ini masih dummy. Nanti kita hubungkan ke data MySQL (registrations, documents, statuses).</p>
    </div>
  </div>
@endsection
