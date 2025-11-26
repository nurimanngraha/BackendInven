<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bukti Barang Masuk</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 0px;
            /* FULL BLEED */
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            margin: 10px 25px;
            line-height: 1.4;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 4px;
            margin-bottom: 5px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo-cell {
            width: 120px;
            padding-top: 2px;
        }

        .logo-img {
            width: 110px;
        }

        .gov-text {
            text-align: center;
            font-size: 12px;
            line-height: 1.1;
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

        .doc-number {
            text-align: center;
            margin-bottom: 20px;
        }

        table.info {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.info th,
        table.info td {
            border: 1px solid #000;
            padding: 8px;
        }

        table.sign {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <?php ob_start(); ?>
    <!-- ========================= PAGE 1 START ========================= -->

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
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
    ];

    $hari = $days[date('l')];
    $tanggal = date('d');
    $bulan = $months[date('F')];
    $tahun = date('Y');
    ?>

    <table class="header-table" style="width:100%; border-bottom:2px solid #000; padding-bottom:5px; margin-bottom:15px;">
        <tr>
            <td class="logo-cell">
                <img src="<?php echo e(public_path('logojawabarat.png')); ?>" class="logo-img">
            </td>

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
        NO :0<?php echo e($tanggal); ?>/020/PAMPMD/<?php echo e(date('Y')); ?>

    </div>

    <p>Pada hari ini <?php echo e($hari); ?> tanggal <?php echo e($tanggal); ?> bulan <?php echo e($bulan); ?> tahun <?php echo e($tahun); ?>.<br>
        Telah diterima sebagai berikut:</p>

    <table class="info">
        <tr>
            <th>No Transaksi</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Masuk</th>
        </tr>
        <tr>
            <td><?php echo e($record->no_transaksi); ?></td>
            <td><?php echo e($record->barang->nama_barang); ?></td>
            <td><?php echo e(number_format($record->jumlah, 0, ',', '.')); ?> Unit</td>
            <td><?php echo e($record->tanggal); ?></td>
        </tr>
    </table>

    <p>
        Barang tersebut digunakan untuk : <?php echo e($keterangan); ?><br>
        <?php echo e($deskripsi); ?><br>
        Sebagai Barang Inventaris Milik Pemda Provinsi Jawa Barat.
    </p>


    <table class="sign" style="width:100%;">
        <tr>
            <td style="width:60%;"></td>
            <td style="text-align:center;">Yang Menerima:</td>
        </tr>
        <tr>
            <td height="80"></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(<?php echo e($record->user->name); ?>)</td>
        </tr>
    </table>

    <!-- ========================= PAGE 1 END ========================= -->
    <?php $page1 = ob_get_clean(); ?>



    <?php ob_start(); ?>
    <!-- ========================= PAGE 2 START ========================= -->

    <h3>Berikut kegiatannya Lampirannya :</h3>

    <table style="width:100%; border-collapse:collapse; margin-top:5px;">

        <!-- BARIS 1: Sebelum - Sesudah -->
        <!-- BARIS 1 -->
        <tr>
            <td style="border:1px solid #000; padding:5px;">
                <strong></strong><br>
                <?php if($foto_sebelum): ?>
                <img src="file://<?php echo e($foto_sebelum); ?>" style="width:100%; height:180px; object-fit:cover;">
                <?php endif; ?>
            </td>

            <td style="border:1px solid #000; padding:5px;">
                <strong></strong><br>
                <?php if($foto_sesudah): ?>
                <img src="file://<?php echo e($foto_sesudah); ?>" style="width:100%; height:180px; object-fit:cover;">
                <?php endif; ?>
            </td>
        </tr>


        <!-- BARIS 2: Sebelum - Sesudah -->
        <tr>
            <td style="border:1px solid #000; height:200px; padding:5px;">
                <strong></strong><br>

                <?php if($foto_sebelum_2): ?>
                <img src="file://<?php echo e($foto_sebelum_2); ?>" style="width:100%; height:180px; object-fit:cover;">
                <?php endif; ?>
            </td>

            <td style="border:1px solid #000; height:200px; padding:5px;">
                <strong></strong><br>

                <?php if($foto_sesudah_2): ?>
                <img src="file://<?php echo e($foto_sesudah_2); ?>" style="width:100%; height:180px; object-fit:cover;">
                <?php endif; ?>
            </td>
        </tr>

    </table>


    <!-- ========================= PAGE 2 END ========================= -->
    <?php $page2 = ob_get_clean(); ?>



    <!-- ========================= MERGE 2 HALAMAN MENJADI 1 LANDSCAPE ========================= -->

    <table style="width:100%; border-collapse:collapse; margin-top:10px;">
        <tr>
            <!-- Page 1 lebih lebar: 55% -->
            <td style="width:60%; vertical-align:top; padding-right:15px;">
                <?php echo $page1; ?>

            </td>

            <!-- Page 2 sedikit lebih kecil: 45% -->
            <td style="width:40%; vertical-align:top; padding-left:15px; padding-top:100px;">
                <?php echo $page2; ?>

            </td>
        </tr>
    </table>



</body>

</html><?php /**PATH C:\xampp\htdocs\BackendInven\resources\views/pdf/barang-masuk-single.blade.php ENDPATH**/ ?>