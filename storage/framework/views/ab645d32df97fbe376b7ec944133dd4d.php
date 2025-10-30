<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Preview Cetak Aset <?php echo e($payload); ?></title>

    <style>
        body {
            font-family: sans-serif;
            background-color: #f9fafb;
            color: #111827;
            padding: 24px;
            display: flex;
            justify-content: center;
        }

        .wrapper {
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,.07);
        }

        .header {
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            margin-bottom: 12px;
        }

        .qr-preview-area {
            text-align: center;
            margin-bottom: 16px;
        }

        .qr-box {
            display: inline-block;
            border: 1px solid #000;
            padding: 12px;
            border-radius: 4px;
            background-color: #fff;
        }

        .kode {
            font-size: 14px;
            font-weight: 600;
            margin-top: 8px;
            letter-spacing: .05em;
        }

        .aset-meta {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.4;
            margin-top: 4px;
        }

        .controls {
            font-size: 14px;
            color: #111827;
            margin-bottom: 16px;
        }

        .form-row {
            margin-bottom: 8px;
        }

        label {
            display: block;
            font-size: 13px;
            margin-bottom: 4px;
            color: #374151;
        }

        select,
        input[type="number"] {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 6px 8px;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 16px;
        }

        .btn {
            border: 0;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
            padding: 8px 12px;
            cursor: pointer;
        }

        .btn-print {
            background-color: #10b981;
            color: #fff;
        }

        .btn-print:hover {
            background-color: #059669;
        }

        .btn-close {
            background-color: #e5e7eb;
            color: #111827;
        }

        .note {
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            margin-top: 12px;
            line-height: 1.4;
        }

        /* HALAMAN CETAK */
        @media print {
            body {
                background: #fff;
                padding: 0;
                margin: 0;
                display: block;
            }

            .wrapper {
                box-shadow: none;
                border: 0;
                border-radius: 0;
                max-width: none;
                width: auto;
                padding: 0;
            }

            .controls,
            .actions,
            .note,
            .header {
                display: none;
            }

            .qr-box {
                border: 1px solid #000;
                border-radius: 4px;
                padding: 12px;
                display: inline-block;
                text-align: center;
            }

            .aset-meta {
                margin-top: 4px;
            }
        }
    </style>
</head>
<body>

    <div class="wrapper">

        <div class="header">
            Preview Label Aset
        </div>

        <div class="qr-preview-area">
            <div class="qr-box" id="qrBox">
                
                <div id="qrSvg"><?php echo $svg; ?></div>

                <div class="kode" id="qrCodeText"><?php echo e($payload); ?></div>

                <div class="aset-meta">
                    <?php echo e($aset->nama_aset ?? $aset->nama ?? 'Aset'); ?><br>
                    <?php echo e($aset->merk_kode ?? $aset->merk ?? ''); ?>

                </div>
            </div>
        </div>

        <div class="controls">
            <div class="form-row">
                <label for="presetSize">Ukuran QR</label>
                <select id="presetSize">
                    <option value="100">Kecil (100px)</option>
                    <option value="200" selected>Sedang (200px)</option>
                    <option value="300">Besar (300px)</option>
                    <option value="custom">Custom (px)</option>
                </select>
            </div>

            <div class="form-row" id="customSizeRow" style="display:none;">
                <label for="customSizeInput">Custom size (px)</label>
                <input type="number" id="customSizeInput" min="50" max="1000" step="10" value="200" />
            </div>
        </div>

        <div class="actions">
            <button class="btn btn-print" onclick="triggerPrint()">
                Cetak Sekarang
            </button>
            <button class="btn btn-close" onclick="window.close()">
                Tutup Tab
            </button>
        </div>

        <div class="note">
            Pilih ukuran QR dulu, lalu klik Cetak Sekarang.<br>
            Di mode cetak, hanya kotak label yang akan tercetak.
        </div>
    </div>

    <script>
        // payload untuk QR (kode aset)
        const qrPayload = <?php echo json_encode($payload, 15, 512) ?>;

        // endpoint kecil untuk regenerate barcode di browser pake SVG scaling?
        // Kita gak regenerasi QR lewat server setiap kali (biar ringan).
        // Kita lakukan trik: kita scale SVG secara proporsional pakai width/height.

        const presetSelect = document.getElementById('presetSize');
        const customRow   = document.getElementById('customSizeRow');
        const customInput = document.getElementById('customSizeInput');
        const qrSvgWrap   = document.getElementById('qrSvg');

        function updateSize() {
            let sizeChoice = presetSelect.value;
            let px;

            if (sizeChoice === 'custom') {
                customRow.style.display = 'block';
                px = parseInt(customInput.value || '200', 10);
            } else {
                customRow.style.display = 'none';
                px = parseInt(sizeChoice, 10);
            }

            // Ambil SVG yang sudah dirender server
            const svgEl = qrSvgWrap.querySelector('svg');
            if (svgEl) {
                // Set ulang atribut width/height agar besar kecil
                svgEl.setAttribute('width', px.toString());
                svgEl.setAttribute('height', px.toString());
                // (bacon-qr-code SVG biasanya pakai viewBox, jadi scaling ini aman)
            }
        }

        function triggerPrint() {
            // sebelum print, pastikan ukuran terbaru dipakai
            updateSize();
            window.print();
        }

        // kalau user ganti preset
        presetSelect.addEventListener('change', () => {
            updateSize();
        });

        // kalau user lagi custom
        customInput.addEventListener('input', () => {
            updateSize();
        });

        // inisialisasi awal
        updateSize();
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\BackendInven\resources\views/print/preview.blade.php ENDPATH**/ ?>