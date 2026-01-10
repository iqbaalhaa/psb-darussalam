@extends('admin.layouts.master')

@section('content')

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <div class="container-edit">
        <div class="card-form">
            <div class="form-header">
                <h2>Form Tambah Pengumuman</h2>
                <a href="{{ url('admin/pengumuman') }}" class="btn-back">Kembali</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" style="padding: 20px; color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('admin/pengumuman/' . $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="form-section">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Judul Pengumuman</label>
                            <input type="text" name="judul" value="{{ old('judul', $item->judul) }}" maxlength="250"
                                required placeholder="Masukkan judul...">
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal"
                                value="{{ old('tanggal', @old('tanggal', $item->tanggal)) }}">
                        </div>

                        <div class="form-group full-width">
                            <label>Gambar Sampul</label>
                            <div class="image-upload-wrapper">
                                <input type="file" name="gambar" id="imageInput" accept="image/*"
                                    onchange="previewImage()" style="margin-bottom: 10px;">

                                <div id="imagePreviewContainer" class="img-preview-box small-preview">
                                    <img id="imgPreview" src="{{ $item->gambar ? asset('Berkas/' . $item->gambar) : '#' }}"
                                        alt="Preview Gambar" style="{{ $item->gambar ? '' : 'display: none;' }}">

                                    <div id="placeholderText" style="{{ $item->gambar ? 'display: none;' : '' }}">Preview
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>Deskripsi Pengumuman</label>
                            <input id="deskripsi" type="hidden" name="deskripsi"
                                value="{{ old('deskripsi', $item->deskripsi) }}">
                            <trix-editor input="deskripsi" placeholder="Tulis isi pengumuman di sini..."></trix-editor>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Simpan Pengumuman</button>
                </div>
            </form>
        </div>
    </div>

    @session('success')
        <script>
            alert("Berhasil mengupdate data");
        </script>
    @endsession

    <script>
        // Fungsi JS untuk Preview Gambar
        function previewImage() {
            const image = document.querySelector('#imageInput');
            const imgPreview = document.querySelector('#imgPreview');
            const placeholder = document.querySelector('#placeholderText');

            imgPreview.style.display = 'block';
            placeholder.style.display = 'none';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        // Mencegah upload file di Trix (Opsional, agar tidak berat di server)
        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
            alert("Upload gambar langsung ke dalam teks tidak diizinkan. Gunakan input Gambar Sampul.");
        });
    </script>


    <style>
        .container-edit {
            max-width: 1100px;
            margin: 20px auto;
            padding: 0 15px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-form {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e1e4e8;
        }

        .form-header {
            background: #2c3e50;
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-header h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .form-section {
            padding: 30px;
            border-bottom: 1px solid #eee;
        }

        .section-title {
            margin-top: 0;
            margin-bottom: 25px;
            color: #3498db;
            font-size: 1.2rem;
            border-left: 4px solid #3498db;
            padding-left: 15px;
        }

        .highlight-ayah {
            background-color: #f0f7ff;
        }

        .highlight-ibu {
            background-color: #fff5f8;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px 14px;
            border: 1.5px solid #dcdfe6;
            border-radius: 6px;
            font-size: 1rem;
            transition: 0.3s;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-actions {
            padding: 30px;
            background: #f8f9fa;
            text-align: right;
        }

        .btn-submit {
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #219150;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
        }

        /* CSS Tambahan untuk Section Berkas */
        .file-edit-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }

        .file-group {
            background: #fdfdfd;
            border: 1px solid #eee;
            padding: 12px;
            border-radius: 8px;
        }

        .file-group label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 5px;
            display: block;
        }

        .file-input-wrapper {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .file-input-wrapper input[type="file"] {
            font-size: 0.8rem;
            padding: 5px;
            border: none;
        }

        .view-old {
            font-size: 0.75rem;
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .view-old:hover {
            text-decoration: underline;
        }

        .no-file {
            font-size: 0.75rem;
            color: #e74c3c;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }

        trix-editor {
            min-height: 250px;
            background: #fff;
            border: 1.5px solid #dcdfe6 !important;
            border-radius: 6px;
        }

        .img-preview-box {
            margin-top: 10px;
            width: 100%;
            max-width: 400px;
            min-height: 200px;
            border: 2px dashed #dcdfe6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f9f9f9;
        }

        #imgPreview {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        #placeholderText {
            color: #999;
            font-size: 0.9rem;
        }

        trix-toolbar .trix-button-group--file-tools {
            display: none !important;
        }
    </style>
@endsection
