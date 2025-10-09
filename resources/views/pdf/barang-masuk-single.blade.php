<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 40px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #555;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
        .footer {
            text-align: right;
            font-size: 12px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h2>Laporan Barang Masuk</h2>

    <div class="info">
        <p><strong>No Transaksi:</strong> {{ $record->no_transaksi }}</p>
        <p><strong>Tanggal Masuk:</strong> {{ \Carbon\Carbon::parse($record->tanggal)->format('d M Y') }}</p>
    </div>

    <table>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $record->barang->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $record->kategori ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ number_format($record->jumlah, 0, ',', '.') }} unit</td>
        </tr>
        <tr>
            <th>User</th>
            <td>{{ $record->user->name ?? '-' }}</td>
        </tr>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y H:i') }}
    </div>
</body>
</html>
