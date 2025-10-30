{{-- resources/views/assets/label.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Assets {{ $aset->name ?? $aset->code ?? $aset->id }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root { color-scheme: light dark; }

    /* 1 halaman bersih saat print */
    @page { size: auto; margin: 10mm; } /* ubah margin sesuai label/kertasmu */

    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      margin: 0;
      text-align: center;
    }

    .wrap { margin: 24px auto; }

    /* Skala QR pakai milimeter supaya konsisten saat print */
    .wrap svg {
      width: {{ $sizeMm }}mm;   /* nilai awal dari query ?s= */
      height: auto;
      display: inline-block;
    }

    .code { margin-top: 6px; font-size: 12px; color: #666; }

    /* Toolbar pengaturan (disembunyikan saat print) */
    .toolbar {
      padding: 12px;
      display: flex; gap: 8px; align-items: center; justify-content: center;
      border-bottom: 1px solid #eee;
    }
    .toolbar input, .toolbar select, .toolbar button {
      padding: 6px 10px; border: 1px solid #ccc; border-radius: 8px;
    }
    @media print { .toolbar { display: none } }
  </style>
</head>
<body>
  {{-- Toolbar pengaturan ukuran sebelum preview --}}
  <div class="toolbar">
    <label>Ukuran QR</label>
    <select id="preset" onchange="applyPreset()">
      <option value="28">28 mm</option>
      <option value="34">34 mm</option>
      <option value="38" selected>38 mm</option>
      <option value="44">44 mm</option>
      <option value="50">50 mm</option>
    </select>

    <span>atau</span>

    <label>Custom (mm)</label>
    <input id="customMm" type="number" min="16" max="100" step="1" value="{{ $sizeMm }}" oninput="applyCustom()">

    <button onclick="previewPrint()">Print</button>
  </div>

  {{-- Area yang dicetak: hanya QR + ID --}}
  <div class="wrap" id="printArea">
    {!! $inlineSvg !!}   {{-- INLINE SVG (pasti tampil) --}}
    <div class="code">{{ $payload }}</div>
  </div>

  <script>
    // Simpan/ambil pilihan terakhir (biar enak saat cetak banyak)
    const key = 'qr_label_mm';
    function setWidth(mm){
      const svg = document.querySelector('#printArea svg');
      if (svg && mm > 0) svg.style.width = mm + 'mm';
      localStorage.setItem(key, String(mm));
      // sinkronkan input
      const custom = document.getElementById('customMm');
      if (custom) custom.value = mm;
    }
    function applyPreset(){
      const mm = parseInt(document.getElementById('preset').value, 10);
      setWidth(mm);
    }
    function applyCustom(){
      const mm = parseInt(document.getElementById('customMm').value || '{{ $sizeMm }}', 10);
      setWidth(mm);
    }
    function restoreLast(){
      const last = parseInt(localStorage.getItem(key) || '{{ $sizeMm }}', 10);
      // pilih preset jika ada yang sama
      const preset = document.getElementById('preset');
      if ([28,34,38,44,50].includes(last)) preset.value = String(last);
      setWidth(last);
    }
    function previewPrint(){
      // pastikan ukuran terbaru sudah terpasang, lalu buka preview
      applyCustom();
      window.print();
    }

    // Saat halaman siap, pulihkan ukuran terakhir (tidak auto-print)
    window.addEventListener('load', restoreLast);
  </script>
</body>
</html>
