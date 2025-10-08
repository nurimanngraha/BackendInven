<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bukti Barang Masuk</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif; 
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 8px;
            border: 1px solid #dee2e6;
            width: 30%;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .mt-20 { margin-top: 20px; }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>BUKTI BARANG MASUK</h2>
        <p>No. Transaksi: {{ $record->no_transaksi }}</p>
    </div>

    <table class="info-table">
        <tr>
            <th>No. Transaksi</th>
            <td>{{ $record->no_transaksi }}</td>
        </tr>
        <tr>
            <th>Tanggal Masuk</th>
            <td>{{ \Carbon\Carbon::parse($record->tanggal)->format('d F Y') }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $record->barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $record->kategori }}</td>
        </tr>
        <tr>
            <th>Jumlah Masuk</th>
            <td>{{ number_format($record->jumlah, 0, ',', '.') }} unit</td>
        </tr>
        <tr>
            <th>Ditambahkan Oleh</th>
            <td>{{ $record->user->name }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>