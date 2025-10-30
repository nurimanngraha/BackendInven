<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Label Aset {{ $payload }}</title>

    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding: 24px;
        }
        .label-card {
            display: inline-block;
            border: 1px solid #000;
            padding: 16px 24px;
            border-radius: 6px;
        }
        .qr {
            width: 300px;
            height: auto;
            margin: 0 auto 12px auto;
        }
        .code {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: .05em;
        }
        .meta {
            font-size: 12px;
            color: #555;
            margin-top: 4px;
        }
        @media print {
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="label-card">
        <div class="qr">{!! $svg !!}</div>
        <div class="code">{{ $payload }}</div>
        <div class="meta">{{ $aset->nama_aset ?? $aset->nama ?? 'Aset' }}</div>
        <div class="meta">{{ $aset->merk_kode ?? $aset->merk ?? '' }}</div>
    </div>
</body>
</html>
