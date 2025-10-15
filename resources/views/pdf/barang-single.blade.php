<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Barang - {{ $barang->kode_barang }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .title { font-size: 24px; font-weight: bold; }
        .subtitle { font-size: 16px; color: #666; }
        .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .info-table td { padding: 8px; border: 1px solid #ddd; }
        .info-table tr:nth-child(even) { background-color: #f9f9f9; }
        .label { font-weight: bold; width: 30%; }
        .footer { margin-top: 50px; text-align: right; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">DETAIL DATA BARANG</div>
        <div class="subtitle">Sistem Manajemen Inventori</div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Kode Barang</td>
            <td>{{ $barang->kode_barang }}</td>
        </tr>
        <tr>
            <td class="label">Nama Barang</td>
            <td>{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Barang</td>
            <td>{{ $barang->jenis_barang }}</td>
        </tr>
        <tr>
            <td class="label">Stok</td>
            <td>{{ $barang->stok }} {{ $barang->satuan }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Input</td>
            <td>{{ $barang->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>