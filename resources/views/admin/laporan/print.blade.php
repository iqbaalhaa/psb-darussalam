<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan PSB Darussalam</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .meta-info {
            margin-bottom: 15px;
        }
        .meta-info table {
            width: 100%;
            border: none;
        }
        .meta-info td {
            padding: 2px 0;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th, table.data td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }
        table.data th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Penerimaan Santri Baru</h1>
        <p>Pondok Pesantren Darussalam Al-Hafidz</p>
        <p>Jl. Contoh No. 123, Kota, Provinsi</p>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td width="15%"><strong>Tahun Ajaran</strong></td>
                <td>: {{ $filters['tahun_ajaran'] ?? 'Semua' }}</td>
                <td width="15%"><strong>Dicetak Pada</strong></td>
                <td>: {{ date('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Jenjang</strong></td>
                <td>: {{ $filters['jenjang'] ?? 'Semua' }}</td>
                <td><strong>Oleh</strong></td>
                <td>: {{ auth()->user()->name ?? 'Admin' }}</td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>: {{ !empty($filters['status']) ? ucfirst($filters['status']) : 'Semua' }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tgl Daftar</th>
                <th width="25%">Nama Lengkap</th>
                <th width="10%">Jenjang</th>
                <th width="20%">Asal Sekolah</th>
                <th width="15%">No. WA</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $item)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenjang }}</td>
                <td>{{ $item->asal_sekolah ?? '-' }}</td>
                <td>{{ $item->wa }}</td>
                <td>{{ ucfirst($item->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 10px;">Tidak ada data ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br><br>
        <p>Panitia PSB</p>
    </div>

</body>
</html>
