

<dialog id="qrDialog" class="rounded-xl p-0" style="border:none; width: 320px;">
  <div style="padding:14px; text-align:center">
    <div id="qrSvg"></div>
    <div id="qrText" style="margin-top:6px; font-size:12px; color:#6b7280;"></div>
    <div style="margin-top:10px">
      <button type="button" onclick="printQR()" style="padding:6px 10px;border:1px solid #d1d5db;border-radius:8px">
        Print
      </button>
      <button type="button" onclick="document.getElementById('qrDialog').close()" style="padding:6px 10px;margin-left:8px;border:1px solid #d1d5db;border-radius:8px">
        Tutup
      </button>
    </div>
  </div>
</dialog>

<!-- iframe tersembunyi untuk cetak -->
<iframe id="qrPrintFrame" style="display:none"></iframe>

<script>
  // buka dialog dari Action
  window.addEventListener('open-qr', (e) => {
    const dlg = document.getElementById('qrDialog');
    document.getElementById('qrSvg').innerHTML = e.detail.svg;
    document.getElementById('qrText').textContent = e.detail.text || '';
    if (typeof dlg.showModal === 'function') dlg.showModal();
  });

  // cetak QR via iframe (stabil)
  function printQR() {
    const svg = document.getElementById('qrSvg').innerHTML;
    const text = document.getElementById('qrText').textContent;

    const doc = document.getElementById('qrPrintFrame').contentWindow.document;
    doc.open();
    doc.write(`
      <!doctype html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Print QR</title>
          <style>
            @page { margin: 8mm; }
            body { font-family: system-ui, sans-serif; text-align: center; }
            .wrap svg { width: 48mm; height: auto; }
            .text { margin-top: 4mm; font-size: 10pt; color: #555; }
          </style>
        </head>
        <body>
          <div class="wrap">
            ${svg}
            <div class="text">${text}</div>
          </div>
          <script>window.onload = () => { window.focus(); window.print(); };<\/script>
        </body>
      </html>
    `);
    doc.close();
  }
</script>
