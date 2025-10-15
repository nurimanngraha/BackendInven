<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Barang Terpilih</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .title { font-size: 24px; font-weight: bold; }
        .subtitle { font-size: 16px; color: #666; }
        .data-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .data-table th, .data-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .data-table th { background-color: #f5f5f5; font-weight: bold; }
        .data-table tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 50px; text-align: right; font-size: 12px; color: #666; }
        .summary { margin: 20px 0; padding: 15px; background-color: #f5f5f5; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">DATA BARANG TERPILIH</div>
        <div class="subtitle">Sistem Manajemen Inventori</div>
    </div>

    <div class="summary">
        <strong>Total Data: {{ count($barang) }} barang</strong>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Stok</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->jenis_barang }}</td>
                <td>{{ $item->stok }}</td>
                <td>{{ $item->satuan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>