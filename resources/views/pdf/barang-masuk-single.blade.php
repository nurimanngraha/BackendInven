<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang Masuk - {{ \->no_transaksi }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 30px; color: #333; }
        h2 { text-align: center; margin-bottom: 20px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px; border-bottom: 1px solid #ddd; }
        .info-table td:first-child { font-weight: bold; width: 30%; }
        .footer { text-align: center; font-size: 12px; margin-top: 30px; }
    </style>
</head>
<body>
    <h2>DATA BARANG MASUK</h2>
    
    <table class="info-table">
        <tr>
            <td>No Transaksi</td>
            <td>{{ \->no_transaksi }}</td>
        </tr>
        <tr>
            <td>Tanggal Masuk</td>
            <td>{{ \Carbon\Carbon::parse(\->tanggal)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>{{ \->barang->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kategori</td>
            <td>{{ \->kategori->nama_kategori ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jumlah Masuk</td>
            <td>{{ number_format(\->jumlah, 0, ',', '.') }} unit</td>
        </tr>
        <tr>
            <td>User</td>
            <td>{{ \->user->name ?? '-' }}</td>
        </tr>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y H:i') }}
    </div>
</body>
</html>
