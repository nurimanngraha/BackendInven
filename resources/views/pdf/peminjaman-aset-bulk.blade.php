<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Peminjaman Aset</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif; 
            font-size: 10px;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row {
            font-weight: bold;
            background-color: #e9ecef;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
        .company-info {
            margin-bottom: 15px;
            text-align: center;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-dipinjam { background-color: #fff3cd; color: #856404; }
        .status-dikembalikan { background-color: #d1edff; color: #0c5460; }
    </style>
</head>
<body>
    <div class="company-info">
        <h2>INVENTORY SYSTEM</h2>
        <p>Laporan Peminjaman Aset</p>
    </div>
    
    <div class="header">
        <h3>LAPORAN PEMINJAMAN ASET</h3>
        <p>Periode: {{ $tanggal }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Peminjam</th>
                <th>Bagian</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $index => $record)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $record->aset->nama_aset }}</td>
                <td>{{ $record->peminjam }}</td>
                <td>{{ $record->bagian ?? '-' }}</td>
                <td class="text-right">{{ number_format($record->jumlah, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($record->tanggal_pinjam)->format('d/m/Y') }}</td>
                <td>
                    @if($record->tanggal_kembali)
                        {{ \Carbon\Carbon::parse($record->tanggal_kembali)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="status-badge status-{{ strtolower($record->status) }}">
                        {{ $record->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL:</td>
                <td class="text-right">{{ number_format($records->sum('jumlah'), 0, ',', '.') }}</td>
                <td colspan="3">{{ $records->count() }} transaksi</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }} | Total Data: {{ $records->count() }} records</p>
    </div>
</body>
</html>