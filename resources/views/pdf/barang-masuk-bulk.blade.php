<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Masuk</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 30px; color: #333; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #555; padding: 8px; font-size: 13px; }
        th { background: #f2f2f2; }
        .footer { text-align: right; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Laporan Barang Masuk</h2>
    <table>
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $item)
                <tr>
                    <td>{{ $item->no_transaksi }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->kategori ?? '-' }}</td>
                    <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y H:i') }}
    </div>
</body>
</html>
