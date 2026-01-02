@extends('admin.layouts.master')

@section('title', 'Data Pendaftar')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<style>
  /* DataTables Dark Theme Support */
  table.dataTable tbody tr {
    background-color: transparent !important;
    color: var(--text);
  }
  table.dataTable tbody tr.odd {
    background-color: rgba(255, 255, 255, 0.02) !important;
  }
  table.dataTable tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.05) !important;
  }
  
  /* Text Colors for DataTables Controls */
  .dataTables_wrapper .dataTables_length, 
  .dataTables_wrapper .dataTables_filter, 
  .dataTables_wrapper .dataTables_info, 
  .dataTables_wrapper .dataTables_processing, 
  .dataTables_wrapper .dataTables_paginate {
    color: var(--text) !important;
  }

  /* Pagination Buttons */
  .dataTables_wrapper .dataTables_paginate .paginate_button {
    color: var(--text) !important;
    border: 1px solid var(--border) !important;
    background: transparent !important;
    border-radius: 4px;
    margin-left: 5px;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button.current,
  .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: var(--primary) !important;
    color: #fff !important;
    border: 1px solid var(--primary) !important;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    color: var(--text) !important;
    border: 1px solid var(--border) !important;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
  .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
  .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
    color: var(--muted) !important;
    background: transparent !important;
    border: 1px solid transparent !important;
  }
</style>
@endpush

@section('content')
  <div class="page-title">
    <div>
      <h1>Data Pendaftar</h1>
      <p>Kelola data santri baru di sini.</p>
    </div>
    <div class="actions">
      <div style="display: flex; gap: 10px; align-items: center;">
        <input type="text" id="filter-q" name="q" placeholder="Cari Nama/Email..." value="{{ request('q') }}" class="form-control" style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px; min-width: 200px;">
        
        <select name="jenjang" id="filter-jenjang" class="form-control" style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px;">
          <option value="">Semua Jenjang</option>
          <option value="MTS" {{ request('jenjang') == 'MTS' ? 'selected' : '' }}>MTS</option>
          <option value="MA" {{ request('jenjang') == 'MA' ? 'selected' : '' }}>MA</option>
        </select>

        <select name="status" id="filter-status" class="form-control" style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px;">
          <option value="">Semua Status</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
          <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table" id="table-pendaftar">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenjang</th>
            <th>Email</th>
            <th>WhatsApp</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pendaftar as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->nama }}</td>
              <td>{{ $item->jenjang }}</td>
              <td>{{ $item->email }}</td>
              <td>{{ $item->wa }}</td>
              <td>
                <span class="badge {{ $item->status == 'pending' ? 'warning' : ($item->status == 'diterima' ? 'success' : 'danger') }}">
                  {{ ucfirst($item->status) }}
                </span>
              </td>
              <td>
                <button class="btn sm btn-detail" data-url="{{ route('admin.pendaftar.show', $item->id) }}">Detail</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    var table = $('#table-pendaftar').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
      },
      "columnDefs": [
        { "searchable": false, "orderable": false, "targets": [0, 6] }
      ],
      "dom": 'rtip' // Hilangkan search default (f) dan length (l) karena kita pakai custom
    });

    // Custom Search
    $('#filter-q').on('keyup', function() {
      table.search(this.value).draw();
    });

    // Custom Filter Jenjang (Column 2)
    $('#filter-jenjang').on('change', function() {
      table.column(2).search(this.value).draw();
    });

    // Custom Filter Status (Column 5)
    $('#filter-status').on('change', function() {
      var val = this.value;
      if(val) {
        table.column(5).search(val, true, false).draw();
      } else {
        table.column(5).search('').draw();
      }
    });

    // Apply initial filters from server-side request (if any)
    var initialQ = $('#filter-q').val();
    var initialJenjang = $('#filter-jenjang').val();
    var initialStatus = $('#filter-status').val();

    if(initialQ) table.search(initialQ);
    if(initialJenjang) table.column(2).search(initialJenjang);
    if(initialStatus) table.column(5).search(initialStatus, true, false);
    
    if(initialQ || initialJenjang || initialStatus) table.draw();

    // --- Modal Logic & Action Handlers ---

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

    // Close handlers (duplicate safe)
    document.querySelectorAll("[data-close-modal]").forEach(btn => {
        btn.addEventListener("click", closeModal);
    });
    if(modalBackdrop) {
        modalBackdrop.addEventListener("click", (e) => {
            if (e.target === modalBackdrop) closeModal();
        });
    }

    // Handle Detail Click
    $('#table-pendaftar').on('click', '.btn-detail', function() {
        var url = $(this).data('url');
        openModal("Detail Pendaftar", '<div style="padding:20px; text-align:center;">Loading data...</div>');
        
        $.get(url, function(data) {
            openModal("Detail Pendaftar", data);
            attachModalActionHandlers();
        }).fail(function() {
             openModal("Error", '<div style="padding:20px; text-align:center; color:red;">Gagal memuat data.</div>');
        });
    });

    function attachModalActionHandlers() {
        // Status Update
        $('#form-update-status').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = form.find('button[type="submit"]');
            var originalText = btn.text();
            
            btn.prop('disabled', true).text('Menyimpan...');
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    alert(response.message);
                    location.reload(); 
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + (xhr.responseJSON?.message || 'Gagal update status'));
                },
                complete: function() {
                    btn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Delete Action
        $('#btn-delete').on('click', function() {
            if(confirm('Yakin ingin menghapus data ini secara permanen?')) {
                var url = $(this).data('url');
                var btn = $(this);
                btn.prop('disabled', true).text('Menghapus...');
                
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus data.');
                        btn.prop('disabled', false).text('Hapus Data Pendaftar');
                    }
                });
            }
        });
    }
  });
</script>
@endpush
@endsection
