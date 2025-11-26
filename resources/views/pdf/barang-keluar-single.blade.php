<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Barang Keluar</title>

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
            /* dari 25px → 10px   (TINGGI HALAMAN NAIK 30px) */
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
            /* BIAR NGGAK TERBANG LAGI */
        }

        .logo-cell {
            width: 120px;
            padding-top: 2px;
            /* TURUNKAN LOGO */
        }

        .logo-img {
            width: 110px;
            /* PERKECIL DIKIT BIAR MIRIP WORD */
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

    @php ob_start(); @endphp
    <!-- ========================= PAGE 1 START ========================= -->

    @php
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
    @endphp


    <table class="header-table" style="width:100%; border-bottom:2px solid #000; padding-bottom:5px; margin-bottom:15px;">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('logojawabarat.png') }}" class="logo-img">
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


    <div class="title">DATA BARANG KELUAR</div>

    <div class="doc-number">
        NO :0{{ $tanggal }}/020/PAMPMD/{{ date('Y') }}
    </div>

    <p>Pada hari ini {{ $hari }} tanggal {{ $tanggal }} bulan {{ $bulan }} tahun {{ $tahun }}.<br>
        Telah diserahkan sebagai berikut:</p>

    <table class="info">
        <tr>
            <th>No Transaksi</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Keluar</th>
        </tr>
        <tr>
            <td>{{ $no_transaksi}}</td>
            <td>{{ $nama_barang}}</td>
            <td>{{ $jumlah }}</td>
            <td>{{ $tanggal_keluar }}</td>
        </tr>
    </table>

    <p>
        Barang tersebut digunakan untuk : {{ $keterangan }}<br>
        {{ $deskripsi }}<br>
        Sebagai Barang Inventaris Milik Pemda Provinsi Jawa Barat.
    </p>

    <table class="sign">
        <tr>
            <td>Yang Menerima:</td>
            <td>Yang Menyerahkan:</td>
        </tr>
        <tr>
            <td height="80"></td>
            <td></td>
        </tr>
        <tr>
            <td>( {{ $penerima}} )</td>
            <td>( {{ $petugas }} )</td>
        </tr>
    </table>


    <!-- ========================= PAGE 1 END ========================= -->
    @php $page1 = ob_get_clean(); @endphp



    @php ob_start(); @endphp
    <!-- ========================= PAGE 2 START ========================= -->

    <h3>Berikut kegiatannya Lampirannya :</h3>

    <table style="width:100%; border-collapse:collapse; margin-top:5px;">

        <!-- BARIS 1: Sebelum - Sesudah -->
        <tr>
            <td style="width:50%; border:1px solid #000; height:200px; vertical-align:top; padding:5px;">
                <strong>Sebelum :</strong><br>

                @if($foto_sebelum)
                <img src="file://{{ $foto_sebelum }}" style="width:100%; height:180px; object-fit:cover;">
                @endif
            </td>

            <td style="width:50%; border:1px solid #000; height:200px; vertical-align:top; padding:5px;">
                <strong>Sesudah :</strong><br>

                @if($foto_sesudah)
                <img src="file://{{ $foto_sesudah }}" style="width:100%; height:180px; object-fit:cover;">
                @endif
            </td>
        </tr>

        <!-- BARIS 2: Sebelum - Sesudah -->
        <tr>
            <td style="border:1px solid #000; height:200px; padding:5px;">
                <strong>Sebelum :</strong><br>

                @if($foto_sebelum_2)
                <img src="file://{{$foto_sebelum_2}}" style="width:100%; height:180px; object-fit:cover;">
                @endif
            </td>

            <td style="border:1px solid #000; height:200px; padding:5px;">
                <strong>Sesudah :</strong><br>

                @if($foto_sesudah_2)
                <img src="file://{{$foto_sesudah_2}}" style="width:100%; height:180px; object-fit:cover;">
                @endif
            </td>
        </tr>
    </table>

    <!-- ========================= PAGE 2 END ========================= -->
    @php $page2 = ob_get_clean(); @endphp



    <!-- ========================= MERGE 2 HALAMAN MENJADI 1 LANDSCAPE ========================= -->

    <table style="width:100%; border-collapse:collapse; margin-top:10px;">
        <tr>
            <!-- Page 1 lebih lebar: 55% -->
            <td style="width:60%; vertical-align:top; padding-right:15px;">
                {!! $page1 !!}
            </td>

            <!-- Page 2 sedikit lebih kecil: 45% -->
            <td style="width:40%; vertical-align:top; padding-left:15px; padding-top:100px;">
                {!! $page2 !!}
            </td>
        </tr>
    </table>



</body>

</html>