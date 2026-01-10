@extends('admin.layouts.master')

@section('title', 'Data Pendaftar')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Data Pendaftar</h1>
            <p>Kelola data penerimaan santri baru dengan mudah.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="search-box">
            <i class="fa-solid fa-search"></i>
            <input type="text" id="filter-q" placeholder="Cari berdasarkan nama atau email..." value="{{ request('q') }}">
        </div>
        <div class="filter-group">
            <select id="filter-jenjang" class="form-select">
                <option value="">Semua Jenjang</option>
                {{-- <option value="MTS" {{ request('jenjang') == 'MTS' ? 'selected' : '' }}>MTS</option>
                <option value="MA" {{ request('jenjang') == 'MA' ? 'selected' : '' }}>MA</option> --}}
                <option value="MTS" {{ request('jenjang') == 'MTS' ? 'selected' : '' }}>MTS</option>
                <option value="MA" {{ request('jenjang') == 'MA' ? 'selected' : '' }}>MA</option>
            </select>
            <select id="filter-status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="incomplete_file" {{ request('status') == 'incomplete_file' ? 'selected' : '' }}>Berkas Belum
                    Lengkap
                </option>
                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table" id="table-pendaftar">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama Lengkap</th>
                        <th width="15%">Tahun Ajaran</th>
                        <th width="15%">Jenjang</th>
                        <th width="20%">Kontak</th>
                        <th width="15%">Status</th>
                        <th width="20%" style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendaftar as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 600; color: var(--text-main);">{{ $item->nama }}</span>
                                    <span
                                        style="font-size: 0.8rem; color: var(--text-light);">{{ $item->user->email ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 500; color: var(--text-light);">{{ $item->tahun_ajaran }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 500; color: var(--text-light);">{{ $item->jenjang }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-light);">
                                    <i class="fa-brands fa-whatsapp" style="color: #25D366;"></i>
                                    {{ $item->wa }}
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $item->status }}">
                                    @if ($item->status == 'pending')
                                        <i class="fa-solid fa-clock" style="margin-right: 4px;"></i>
                                    @elseif($item->status == 'diterima')
                                        <i class="fa-solid fa-check-circle" style="margin-right: 4px;"></i>
                                    @else
                                        <i class="fa-solid fa-times-circle" style="margin-right: 4px;"></i>
                                    @endif
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btn-group" style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <button class="action-btn view btn-detail"
                                        data-url="{{ route('admin.pendaftar.show', $item->id) }}" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <a href="{{ url('admin/detail-pendaftar/' . $item->id) }}" class="action-btn"
                                        style="background: #f3e8ff; color: #9333ea; border-color: #e9d5ff;"
                                        title="Cek Lengkap">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </a>

                                    <a href="{{ url('admin/edit-pendaftar/' . $item->id) }}" class="action-btn edit"
                                        title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Generic Modal Container for AJAX Content --}}
    <div class="modal-backdrop">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title" data-modal-title>Detail Pendaftar</strong>
                <button type="button" class="close-modal" data-close-modal>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body" data-modal-body>
                {{-- Content injected via JS --}}
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#table-pendaftar').DataTable({
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
                        "targets": [0, 5]
                    }],
                    "dom": 'rtip',
                    "pageLength": 10
                });

                // Custom Search
                $('#filter-q').on('keyup', function() {
                    table.search(this.value).draw();
                });

                // Custom Filter Jenjang
                $('#filter-jenjang').on('change', function() {
                    table.column(3).search(this.value).draw();
                });

                // Custom Filter Status
                $('#filter-status').on('change', function() {

                    var val = this.value;
                    if (val) {
                        table.column(5).search(val).draw();
                    } else {
                        table.column(5).search('').draw();
                    }
                });

                // --- Modal Logic ---
                const modalBackdrop = document.querySelector(".modal-backdrop");
                const modalTitle = document.querySelector("[data-modal-title]");
                const modalBody = document.querySelector("[data-modal-body]");

                function openModal(title, content) {
                    if (modalTitle) modalTitle.textContent = title;
                    if (modalBody) modalBody.innerHTML = content;
                    if (modalBackdrop) modalBackdrop.style.display = "flex";
                }

                function closeModal() {
                    if (modalBackdrop) modalBackdrop.style.display = "none";
                }

                document.querySelectorAll("[data-close-modal]").forEach(btn => {
                    btn.addEventListener("click", closeModal);
                });
                if (modalBackdrop) {
                    modalBackdrop.addEventListener("click", (e) => {
                        if (e.target === modalBackdrop) closeModal();
                    });
                }

                // Handle Detail Click
                $('#table-pendaftar').on('click', '.btn-detail', function() {
                    var url = $(this).data('url');
                    openModal("Detail Pendaftar",
                        '<div style="padding:40px; text-align:center;"><i class="fa-solid fa-circle-notch fa-spin fa-2x" style="color:var(--primary)"></i><p style="margin-top:10px; color:var(--text-light)">Memuat data...</p></div>'
                    );

                    $.get(url, function(data) {
                        openModal("Detail Pendaftar", data);
                        attachModalActionHandlers();
                    }).fail(function() {
                        openModal("Error",
                            '<div style="padding:20px; text-align:center; color:var(--danger);">Gagal memuat data.</div>'
                        );
                    });
                });

                function attachModalActionHandlers() {
                    // Status Update
                    $('#form-update-status').on('submit', function(e) {
                        e.preventDefault();
                        var form = $(this);
                        var btn = form.find('button[type="submit"]');
                        var originalText = btn.html();

                        btn.prop('disabled', true).html(
                            '<i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...');

                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan: ' + (xhr.responseJSON
                                        ?.message || 'Gagal update status')
                                });
                            },
                            complete: function() {
                                btn.prop('disabled', false).html(originalText);
                            }
                        });
                    });

                    // Delete Action
                    $('#btn-delete').on('click', function() {
                        Swal.fire({
                            title: 'Yakin hapus data?',
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#64748b',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var url = $(this).data('url');
                                var btn = $(this);
                                btn.prop('disabled', true).html(
                                    '<i class="fa-solid fa-circle-notch fa-spin"></i>');

                                $.ajax({
                                    url: url,
                                    method: 'POST',
                                    data: {
                                        _method: 'DELETE',
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        Swal.fire(
                                            'Terhapus!',
                                            response.message,
                                            'success'
                                        ).then(() => location.reload());
                                    },
                                    error: function(xhr) {
                                        Swal.fire(
                                            'Gagal!',
                                            'Gagal menghapus data.',
                                            'error'
                                        );
                                        btn.prop('disabled', false).html(
                                            '<i class="fa-solid fa-trash"></i> Hapus Permanen'
                                        );
                                    }
                                });
                            }
                        })
                    });
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
@endsection
