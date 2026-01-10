<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        /* body {
                font-family: "Times-Roman";
                font-size: 11px;
                line-height: 1.2;
            } */
        /* @page {
                margin-left: 2cm;
                margin-right: 2cm;
                margin-top: 2.5cm;
                margin-bottom: 2.5cm;
            } */
        @page {
            margin-left: 2cm;
            margin-right: 2cm;
            margin-top: 2.3cm;
            margin-bottom: 2.3cm;
        }

        body {
            font-family: serif;
            /* default DomPDF */
            font-size: 11pt;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        td {
            padding: 2px 4px;
            vertical-align: top;
        }

        tr {
            page-break-inside: avoid;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .kop-title {
            font-size: 16px;
            /* DIBESARKAN */
            font-weight: bold;
        }

        .kop-sub {
            font-size: 14px;
            /* DIBESARKAN */
            font-weight: bold;
        }

        .kop-address {
            font-size: 10px;
        }

        .title {
            font-size: 13px;
            margin: 6px 0;
            font-weight: bold;
        }

        .label {
            width: 35%;
        }

        .section {
            margin-top: 6px;
            font-weight: bold;
        }

        hr {
            border: 1px solid #000;
            margin: 6px 0;
        }
    </style>

</head>

<body>

    {{-- KOP SURAT --}}
    <table>
        <tr>
            <td style="width:80px">
                <img src="{{ public_path('logo-pesantren.png') }}" width="75">
            </td>
            <td class="center">
                <div class="kop-title">YAYASAN AL-HAFIDZ</div>
                <div class="kop-title">PONDOK PESANTREN DARUSSALAM AL HAFIDZ</div>
                <div class="kop-title">KOTA JAMBI</div>
                <div class="kop-address">
                    Jl. Kopral Umar RT.21 Kel. Kenali Asam Atas<br>
                    Kec. Kota Baru – Kota Jambi
                </div>
            </td>
        </tr>
    </table>

    <hr>

    {{-- JUDUL --}}
    <div class="center title bold">
        FORMULIR PENDAFTARAN SANTRI BARU (FORMAL)
    </div>

    <p><b>Jenjang yang Dipilih :</b> {{ $data->jenjang }}</p>

    {{-- A. IDENTITAS SANTRI --}}
    <div class="section">A. IDENTITAS CALON SANTRI (WAJIB DIISI)</div>

    <table>
        <tr>
            <td class="label">1. Nama Lengkap</td>
            <td>: {{ $data->nama }}</td>
        </tr>
        <tr>
            <td>2. NISN</td>
            <td>: {{ $data->nisn }}</td>
        </tr>
        <tr>
            <td>3. Jenis Kelamin</td>
            <td>: {{ $data->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td>4. Tempat, Tanggal Lahir</td>
            <td>: {{ $data->tempat_lahir }}, {{ date('d F Y', strtotime($data->tanggal_lahir)) }} </td>
        </tr>
        <tr>
            <td>5. NIK</td>
            <td>: {{ $data->nik }}</td>
        </tr>
        <tr>
            <td>6. Anak Ke</td>
            <td>: {{ $data->anak_ke }}</td>
        </tr>
        <tr>
            <td>7. Jumlah Saudara</td>
            <td>: {{ $data->jumlah_saudara }}</td>
        </tr>
        <tr>
            <td>8. Asal Sekolah</td>
            <td>: {{ $data->asal_sekolah }}</td>
        </tr>
    </table>

    {{-- B. ORANG TUA --}}
    <div class="section">B. IDENTITAS ORANG TUA / WALI (WAJIB DIISI)</div>

    <div class="bold">1. BAPAK</div>
    <table>
        <tr>
            <td class="label">Nama Ayah</td>
            <td>: {{ $data->nama_ayah }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_ayah }}</td>
        </tr>
        <tr>
            <td>Umur, Tempat, Tgl Lahir</td>
            <td>: {{ $data->umur_ayah . ', ' . $data->tempat_lahir_ayah }},
                {{ date('d F Y', strtotime($data->tanggal_lahir_ayah)) }}</td>
        </tr>
        <tr>
            <td>Pendidikan Terakhir</td>
            <td>: {{ $data->pendidikan_terakhir_ayah }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan_ayah }}</td>
        </tr>
        <tr>
            <td>Alamat Lengkap</td>
            <td>: {{ $data->alamat_lengkap_ayah }}</td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td>: {{ $data->no_hp_ayah }}</td>
        </tr>
    </table>

    <br>

    <div class="bold">2. IBU</div>
    <table>
        <tr>
            <td class="label">Nama Ibu</td>
            <td>: {{ $data->nama_ibu }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_ibu }}</td>
        </tr>
        <tr>
            <td>Umur, Tempat, Tgl Lahir</td>
            <td>: {{ $data->umur_ibu . ', ' . $data->tempat_lahir_ibu }},
                {{ date('d F Y', strtotime($data->tanggal_lahir_ibu)) }}
            </td>
        </tr>
        <tr>
            <td>Pendidikan Terakhir</td>
            <td>: {{ $data->pendidikan_terakhir_ibu }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan_ibu }}</td>
        </tr>
        <tr>
            <td>Alamat Lengkap</td>
            <td>: {{ $data->alamat_lengkap_ibu }}</td>
        </tr>
        <tr>
            <td>No HP</td>
            <td>: {{ $data->no_hp_ibu }}</td>
        </tr>
    </table>

    <br><br>

    {{-- TANDA TANGAN --}}
    <table style="margin-top:10px">
        <tr>
            <td style="width:60%"></td>
            <td class="center">
                Jambi, {{ date('d F Y') }}<br>
                Orang Tua/Wali Calon Santri<br><br><br><br><br><br>
                <u>{{ $data->nama_ayah }}</u>
            </td>
        </tr>
    </table>

</body>

</html>
