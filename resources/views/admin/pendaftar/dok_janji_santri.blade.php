<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Surat Pernyataan dan Janji Santri</title>

    <style>
        @page {
            margin: 2.5cm;
        }

        body {
            font-family: Times, serif;
            /* pengganti Times New Roman */
            /* font-size: 12px; */
            font-size: 11pt;
            line-height: 1.3;
        }

        .judul {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
        }

        .isi {
            text-align: justify;
        }

        table {
            width: 100%;
        }

        .ttd-atas td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-bawah {
            text-align: center;
            margin-top: 30px;
        }

        .nama {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- JUDUL -->
    <div class="judul">
        SURAT PERNYATAAN DAN JANJI SANTRI
    </div>

    <p style="text-align:center;"><i>Bismillahirrahmanirrahim</i></p>

    <div class="isi">
        <p>Yang bertanda tangan di bawah ini:</p>

        <table cellpadding="4">
            <tr>
                <td width="35%">Nama Santri</td>
                <td width="5%">:</td>
                <td>{{ $data->nama }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $data->tempat_lahir . ', ' . date('d F Y', strtotime($data->tanggal_lahir)) }}</td>
            </tr>
            <tr>
                <td>Nama Orang Tua/Wali</td>
                <td>:</td>
                <td>{{ $data->nama_ayah }}</td>
            </tr>
        </table>

        <p>Dengan ini menyatakan dan berjanji:</p>

        <ol>
            <li>Siap menaati seluruh peraturan dan tata tertib Pondok Pesantren Darussalam Al Hafidz.</li>
            <li>Siap mengikuti seluruh kegiatan belajar mengajar yang ditetapkan oleh pondok pesantren.</li>
            <li>Siap menerima sanksi apabila saya:
                <ol type="a">
                    <li>Dengan sengaja melanggar peraturan pondok pesantren.</li>
                    <li>Melanggar syariat Islam.</li>
                    <li>Tidak mengikuti kegiatan pondok pesantren.</li>
                </ol>
            </li>
            <li>Tahapan sanksi berupa:
                <ol type="a">
                    <li>Nasehat dan teguran.</li>
                    <li>Membuat surat perjanjian.</li>
                    <li>Apabila mengulangi kesalahan yang sama sebanyak tiga kali, siap dikeluarkan dari pondok
                        pesantren.</li>
                </ol>
            </li>
            <li>Tidak akan mengajukan pindah atau mengundurkan diri sampai menamatkan pendidikan di pondok
                pesantren.</li>
            <li>Bagi santri kelas III Aliyah dianjurkan untuk mengabdi selama satu tahun.</li>
            <li>Apabila santri mengundurkan diri, maka ijazah dan administrasi tidak akan diproses.</li>
            <li>Jika santri pindah setelah lulus kelas III MTs, maka bersedia membayar uang maslahat sebesar
                Rp3.000.000,-.</li>
        </ol>

        <p>Demikian surat pernyataan ini dibuat dengan sebenar-benarnya.</p>
    </div>

    <!-- TTD ATAS -->
    <table class="ttd-atas">
        <tr>
            <td>
                <br>
                Santri
                <div class="nama">{{ $data->nama }}</div>
            </td>
            <td>
                Jambi, {{ date('d F Y') }}<br>
                Orang Tua / Wali
                <div class="nama">{{ $data->nama_ayah }}</div>
            </td>
        </tr>
    </table>

    <!-- TTD BAWAH (MENGETAHUI - TENGAH) -->
    <div class="ttd-bawah">
        Mengetahui,<br>
        Mudhir Ma’had
        <div class="nama">ABUYA ZULKIFLI, S.Pd.I</div>
    </div>

</body>

</html>
