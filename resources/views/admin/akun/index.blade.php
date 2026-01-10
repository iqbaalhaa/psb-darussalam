@extends('admin.layouts.master')

@section('title', 'Manajemen Akun')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Manajemen Akun & Role</h1>
            <p>Kelola data pengguna dan hak akses sistem.</p>
        </div>
        <button class="btn-save" id="btn-add-account">
            <i class="fa-solid fa-plus"></i> Tambah Akun
        </button>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="search-box">
            <i class="fa-solid fa-search"></i>
            <input type="text" id="filter-q" placeholder="Cari nama atau email..." value="{{ request('q') }}">
        </div>
        <div class="filter-group">
            <select id="filter-role" class="form-select">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="santri">Santri</option>
            </select>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px; padding: 15px; background: #d1fae5; color: #065f46; border-radius: 8px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 20px; padding: 15px; background: #fee2e2; color: #991b1b; border-radius: 8px;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px; padding: 15px; background: #fee2e2; color: #991b1b; border-radius: 8px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Data Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table" id="table-akun">
                <thead>
                    <tr>
                        <th class="w-5">No</th>
                        <th class="w-30">Nama Lengkap</th>
                        <th class="w-30">Email</th>
                        <th class="w-15">Role</th>
                        <th class="w-20 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-600 text-main">{{ $user->name }}</span>
                            </td>
                            <td>
                                <span class="text-sm text-muted">{{ $user->email }}</span>
                            </td>
                            <td>
                                <span class="status-badge {{ $user->role == 'admin' ? 'diterima' : 'pending' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button class="action-btn edit btn-edit" 
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}"
                                        data-update-url="{{ route('admin.akun.update', $user->id) }}"
                                        title="Edit Akun">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    @if(auth()->id() != $user->id)
                                        <form action="{{ route('admin.akun.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Hapus Akun">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Template -->
    <div class="modal-backdrop" id="accountModal">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title" id="modalTitle">Tambah Akun</strong>
                <button type="button" class="close-modal" id="closeModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="accountForm" action="{{ route('admin.akun.store') }}" method="POST">
                    @csrf
                    <div id="methodField"></div>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password <span id="passwordHint" class="text-muted text-sm font-normal" style="display:none;">(Kosongkan jika tidak ingin mengubah)</span></label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="santri">Santri</option>
                        </select>
                    </div>

                    <div class="modal-footer" style="padding: 0; border: none; margin-top: 20px;">
                        <button type="button" class="btn-cancel" id="btnCancel">Batal</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table-akun').DataTable({
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
                    "targets": [0, 4]
                }],
                "dom": 'rtip',
                "pageLength": 10
            });

            // Custom Search
            $('#filter-q').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Custom Filter Role
            $('#filter-role').on('change', function() {
                table.column(3).search(this.value).draw();
            });

            // Modal Logic
            const modal = document.getElementById('accountModal');
            const form = document.getElementById('accountForm');
            const modalTitle = document.getElementById('modalTitle');
            const methodField = document.getElementById('methodField');
            const passwordHint = document.getElementById('passwordHint');
            const passwordInput = document.getElementById('password');

            function openModal() {
                modal.classList.add('show');
            }

            function closeModal() {
                modal.classList.remove('show');
                form.reset();
                methodField.innerHTML = '';
                passwordInput.removeAttribute('required');
                passwordHint.style.display = 'none';
                form.action = "{{ route('admin.akun.store') }}";
                modalTitle.textContent = "Tambah Akun";
            }

            $('#btn-add-account').on('click', function() {
                openModal();
                passwordInput.setAttribute('required', 'required');
            });

            $('.btn-edit').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                const role = $(this).data('role');
                const updateUrl = $(this).data('update-url');

                modalTitle.textContent = "Edit Akun";
                form.action = updateUrl;
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                
                $('#name').val(name);
                $('#email').val(email);
                $('#role').val(role);
                
                passwordHint.style.display = 'inline';
                passwordInput.removeAttribute('required');

                openModal();
            });

            $('#closeModal, #btnCancel').on('click', closeModal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });
        });
    </script>
@endpush
