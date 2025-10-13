<!DOCTYPE html>
<html>
<head>
    <title>Barang Keluar - {{ $no_transaksi }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 12px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>DATA BARANG KELUAR</h2>
    </div>
    
    <table>
        <tr>
            <th width="30%">No Transaksi</th>
            <td>{{ $no_transaksi }}</td>
        </tr>
        <tr>
            <th>Tgl Keluar</th>
            <td>{{ $tanggal_keluar }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $nama_barang }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $jumlah }}</td>
        </tr>
        <tr>
            <th>Bagian</th>
            <td>{{ $bagian }}</td>
        </tr>
        <tr>
            <th>Petugas</th>
            <td>{{ $petugas }}</td>
        </tr>
    </table>
</body>
</html>