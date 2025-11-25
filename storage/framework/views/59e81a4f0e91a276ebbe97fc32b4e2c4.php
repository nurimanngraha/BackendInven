<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Tanda Terima Barang Masuk</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            margin: 25px;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header-table td {
        vertical-align: middle; /* BIAR NGGAK TERBANG LAGI */
        }

        .logo-cell {
        width: 120px;
        padding-top: 2px;   /* TURUNKAN LOGO */
        }

        .logo-img {
        width: 110px; /* PERKECIL DIKIT BIAR MIRIP WORD */
        }

        .gov-text {
        text-align: center;
        font-size: 14px;
        line-height: 1.3;
        padding-bottom: 10px;
        padding-left: 20px;
        }

        .gov-text .title1 {
        font-size: 22px;
        font-weight: bold;
        }

        .gov-text .title2 {
        font-size: 28px;
        font-weight: bold;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            text-decoration: underline;
            margin-top: 10px;
        }

        .doc-number { text-align: center; margin-bottom: 20px; }

        table.info {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table.info th, table.info td {
            border: 1px solid #000;
            padding: 8px;
        }

        table.sign {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }

        .page-break { page-break-after: always; }
    </style>
</head>
<body>
<?php
    $days = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    $months = [
        'January'   => 'Januari',
        'February'  => 'Februari',
        'March'     => 'Maret',
        'April'     => 'April',
        'May'       => 'Mei',
        'June'      => 'Juni',
        'July'      => 'Juli',
        'August'    => 'Agustus',
        'September' => 'September',
        'October'   => 'Oktober',
        'November'  => 'November',
        'December'  => 'Desember'
    ];

    $hari = $days[date('l')];
    $tanggal = date('d');
    $bulan = $months[date('F')];
    $tahun = date('Y');
?>

    <!-- HEADER -->
<table class="header-table" style="width:100%; border-bottom:2px solid #000; padding-bottom:5px; margin-bottom:15px;">
    <tr>

        <!-- LOGO – Sejajar tinggi dengan teks -->
        <td class="logo-cell">
            <img src="<?php echo e(public_path('logojawabarat.png')); ?>" class="logo-img">
        </td>
        <!-- TEKS HEADER -->
        <td class="gov-text">
            <div class="title1">PEMERINTAH PROVINSI JAWA BARAT</div>
            <div class="title2">SEKRETARIAT DAERAH</div>
            Jalan Diponegoro No.22 Telepon (022) 4232448 – 4233347 – 4230963<br>
            Faksimili (022) 4203450 Web : www.jabarprov.go.id<br>
            Email : info@jabarprov.go.id
        </td>
    </tr>
</table>


    <div class="title">BUKTI BARANG MASUK</div>

    <div class="doc-number">
        NO : .................. /  /PAMPMD/<?php echo e(date('Y')); ?>

    </div>

    <p>Pada hari ini <?php echo e($hari); ?> tanggal <?php echo e($tanggal); ?> bulan <?php echo e($bulan); ?> tahun <?php echo e($tahun); ?>.<br>
    Telah diterima dari Bagian Rumah Tangga, Peralatan sebagai berikut:</p>

    <table class="info">
        <tr>
            <th width="5%">No</th>
            <th>Jenis Barang</th>
            <th>Merk</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
        <tr>
            <td>1</td>
            <td><?php echo e($record->barang->nama_barang); ?></td>
            <td>-</td>
            <td><?php echo e(number_format($record->jumlah, 0, ',', '.')); ?> Unit</td>
            <td>-</td>
        </tr>
    </table>

    <p>
        Barang tersebut digunakan untuk : Pemasangan / Pergantian<br>
        ......................................................................................................................................................<br>
        Sebagai Barang Inventaris Milik Pemda Provinsi Jawa Barat.
    </p>

    <table class="sign">
        <tr>
            <td>Yang Menyerahkan:</td>
            <td>Yang Menerima:</td>
        </tr>
        <tr><td height="80"></td><td></td></tr>
        <tr>
            <td>( <?php echo e($record->user->name); ?> )</td>
            <td>( ............................................. )</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <h3>Lampiran Kegiatan:</h3>
    <p><strong>Sebelum :</strong></p>
    <br><br><br><br><br>
    <p><strong>Sesudah :</strong></p>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\BackendInven\resources\views/pdf/barang-masuk-single.blade.php ENDPATH**/ ?>