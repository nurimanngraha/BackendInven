<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bukti Peminjaman Aset</title>
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
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .company-info {
            margin-bottom: 20px;
            text-align: center;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-dipinjam { background-color: #fff3cd; color: #856404; }
        .status-dikembalikan { background-color: #d1edff; color: #0c5460; }
    </style>
</head>
<body>
    <div class="company-info">
        <h1>INVENTORY SYSTEM</h1>
        <p>Bukti Peminjaman Aset</p>
    </div>

    <div class="header">
        <h2>BUKTI PEMINJAMAN ASET</h2>
        <p>ID: <?php echo e($record->id); ?></p>
    </div>

    <table class="info-table">
        <tr>
            <th>Nama Aset</th>
            <td><?php echo e($record->aset->nama_aset); ?></td>
        </tr>
        <tr>
            <th>Peminjam</th>
            <td><?php echo e($record->peminjam); ?></td>
        </tr>
        <tr>
            <th>Bagian/Departemen</th>
            <td><?php echo e($record->bagian ?? '-'); ?></td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td><?php echo e(number_format($record->jumlah, 0, ',', '.')); ?> unit</td>
        </tr>
        <tr>
            <th>Tanggal Pinjam</th>
            <td><?php echo e(\Carbon\Carbon::parse($record->tanggal_pinjam)->format('d F Y')); ?></td>
        </tr>
        <tr>
            <th>Tanggal Kembali</th>
            <td>
                <?php if($record->tanggal_kembali): ?>
                    <?php echo e(\Carbon\Carbon::parse($record->tanggal_kembali)->format('d F Y')); ?>

                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="status-badge status-<?php echo e(strtolower($record->status)); ?>">
                    <?php echo e($record->status); ?>

                </span>
            </td>
        </tr>
        <tr>
            <th>Tanggal Input</th>
            <td><?php echo e($record->created_at->format('d F Y H:i')); ?></td>
        </tr>
    </table>

    <div class="footer">
        <p>Dicetak pada: <?php echo e(now()->format('d F Y H:i')); ?></p>
    </div>
</body>
</html><?php /**PATH C:\Users\Imron\BackendInven\resources\views/pdf/peminjaman-aset-single.blade.php ENDPATH**/ ?>