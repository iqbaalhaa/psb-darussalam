// KODINGAN AKU 

    <div class="container-profile">
        <div class="card header-card">
            <div class="header-top">
                <h2>Profil Siswa: {{ $data->nama }}</h2>
                <div class="header-actions">
                    <button id="btnOpenStatus" class="btn-status">Update Status Penerimaan</button>
                    <button id="btnOpenStatusPembayaran" class="btn-status">Update Status Pembayaran</button>
                    {{-- <span class="badge {{ $data->is_locked ? "locked" : "unlocked" }}"> --}}

                    @if ($data->status == 'pending')
                        <span class="badge" style="background: yellow">Pending</span>
                    @elseif ($data->status == 'incomplete_file')
                        <span class="badge" style="background: grey">Berkas Belum Lengkap</span>
                    @elseif ($data->status == 'reject')
                        <span class="badge" style="background: red">Ditolak</span>
                    @else
                        <span class="badge" style="background: green">Diterima</span>
                    @endif


                    <!-- KODINGAN AKU  -->


                    /=====================================
                    <!-- KODINGAN KEDUA CONFLICT -->

                    <div class="header-grid">
                <div class="info-item">
                    <label>Keterangan</label>
                    <span>{{ $data->keterangan }}</span>
                </div>
            </div>
            <div class="header-grid">
                <div class="info-item">
                    <label>Status Pembayaran</label>
                    <span>{{ $data->status_pembayaran == 'belum_lunas' ? 'Belum Lunas' : 'Lunas' }}</span>
                </div>
            </div>
            <div class="header-grid">
                <div class="info-item">
                    <label>Dokumen Formulir</label>
                    <a href="{{ url('form-pendaftaran-pdf/' . $data->id) }}">Dok Pendaftaran</a><br>
                    <a href="{{ url('form-pernyataan-pdf/' . $data->id) }}">Dok Pernyataan</a><br>
                    <a href="{{ url('form-janji-santri-pdf/' . $data->id) }}">Dok Janji Santri</a><br>
                    <a href="{{ url('form-syarat-pendaftaran') }}">Syarat Pendaftaran</a>
                </div>
            </div>
            <hr>
            <div class="header-grid">
                <div class="info-item">
                    <label>Jenjang</label>
                    <span>{{ $data->jenjang }}</span>
                </div>
                <div class="info-item">
                    <label>Email</label>
                    <span>{{ $data->email }}</span>
                </div>
                <div class="info-item">
                    <label>WhatsApp</label>
                    <span>{{ $data->wa }}</span>
                </div>
                <div class="info-item">
                    <label>Status Perubah Data</label>
                    @if ($data->is_locked)
                        <span>Data tidak bisa dirubah oleh user </span>
                    @else
                        <span> Data bisa dirubah oleh user</span>
                    @endif


                    <!-- KODINGAN KETIGA CONFLICT -->

                    // Membuaka Modal Status Pembayaran
                $('#btnOpenStatusPembayaran').on('click', function() {
                    $('#modalStatusPembayaran').fadeIn(300);
                });

                // Menutup Modal (Klik X, tombol Batal, atau klik di luar modal)
                $('.close-modal').on('click', function() {
                    $('#modalStatus').fadeOut(300);
                });

                // Menutup Modal (Klik X, tombol Batal, atau klik di luar modal)
                $('.close-modal-pembayaran').on('click', function() {
                    $('#modalStatus').fadeOut(300);
                });