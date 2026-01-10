<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <style>
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

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        td {
            padding: 2px 3px;
            vertical-align: top;
        }

        .label {
            width: 30%;
        }

        .title {
            font-size: 13pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 6px;
        }

        ol {
            padding-left: 18px;
        }

        li {
            margin-bottom: 4px;
            text-align: justify;
        }
    </style>
</head>

<body>

    {{-- JUDUL --}}
    <div class="title">
        SURAT PERNYATAAN WALI SANTRI
    </div>

    <p class="center"><i>Bismillahirrahmanirrahim</i></p>

    <p>Yang bertanda tangan di bawah ini:</p>

    {{-- IDENTITAS WALI --}}
    <table>
        <tr>
            <td class="label">Nama</td>
            <td>: {{ $data->nama_ayah }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>: {{ $data->tempat_lahir_ayah . ', ' . date('d F Y', strtotime($data->tanggal_lahir_ayah)) }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_lengkap_ayah }}</td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td>: {{ $data->no_hp_ayah }}</td>
        </tr>
        <tr>
            <td>Wali Santri dari</td>
            <td>: {{ $data->nama }}</td>
        </tr>
    </table>

    <br>

    <p>Menyatakan bahwa:</p>

    {{-- ISI PERNYATAAN --}}
    <ol>
        <li>
            Menyerahkan anak kami sepenuhnya kepada pengasuh dan pengurus Pondok
            Pesantren Darussalam Al Hafidz untuk mendidik dan mengawasi menurut ajaran
            agama Islam Ahlus Sunnah Wal Jama’ah dan hukum Negara Republik Indonesia.
        </li>
        <li>
            Ridho dan ikhlas tidak akan menuntut kembali pengembalian dana yang sudah
            disetorkan kepada Panitia Penerimaan Santri Pondok Pesantren Darussalam Al
            Hafidz (apabila anak yang bersangkutan batal masuk ke lembaga ini).
        </li>
        <li>
            Ridho atas segala sanksi yang diberikan oleh pengasuh, pengurus, kepala atau
            ketua lembaga kepada anak kami, jika anak kami melakukan pelanggaran terhadap
            peraturan pondok pesantren.
        </li>
        <li>
            Menerima dengan hati legawa atas pengembalian anak kami jika anak kami sudah
            tidak sanggup menaati peraturan atau melampaui poin pelanggaran yang telah
            ditetapkan pondok pesantren.
        </li>
        <li>
            Siap menghadap pada pengasuh, pengurus, kepala atau ketua lembaga jika kami
            dipanggil ke Pondok Pesantren yang berkaitan dengan anak kami.
        </li>
        <li>
            Bertanggung jawab atas biaya administrasi/mashlahat anak kami di Pondok
            Pesantren.
        </li>
        <li>
            Menyelesaikan secara kekeluargaan atas kemungkinan terjadinya konflik anak kami
            dengan keluarga besar pondok pesantren.
        </li>
        <li>
            Sanggup menjaga nama baik almamater pondok pesantren.
        </li>
        <li>
            Memintakan izin anak kami kepada pengasuh dan pengurus pondok pada saat
            pulang atau boyong.
        </li>
        <li>
            Ikut serta dalam mendidik dan mengawasi anak kami ketika berada di rumah.
        </li>
    </ol>

    <br>

    {{-- TANDA TANGAN --}}
    <table style="margin-top:10px">
        <tr>
            <td style="width:60%"></td>
            <td class="center">
                Jambi, {{ date('d F Y') }}<br>
                Orang Tua/Wali Santri<br><br><br><br><br>
                <u>{{ $data->nama_ayah }}</u>
            </td>
        </tr>
    </table>

</body>

</html>
