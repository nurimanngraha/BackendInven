<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang Keluar</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .info {
            margin-bottom: 20px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN BARANG KELUAR</h2>
    </div>
    
    <div class="info">
        <p><strong>Dicetak:</strong> {{ $tanggal_cetak }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Tgl Keluar</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Bagian</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record['no_transaksi'] }}</td>
                <td>{{ $record['tanggal_keluar'] }}</td>
                <td>{{ $record['nama_barang'] }}</td>
                <td>{{ $record['jumlah'] }}</td>
                <td>{{ $record['bagian'] }}</td>
                <td>{{ $record['petugas'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="summary">
        Total Keluar: {{ $total_keluar }}
    </div>
</body>
</html>