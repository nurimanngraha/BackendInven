<?php if (isset($component)) { $__componentOriginalbe23554f7bded3778895289146189db7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe23554f7bded3778895289146189db7 = $attributes; } ?>
<?php $component = Filament\View\LegacyComponents\Page::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Filament\View\LegacyComponents\Page::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="max-w-5xl mx-auto w-full">

        
        <div class="bg-white border border-gray-300 rounded-md shadow-sm">
            
            <div class="px-4 py-6 border-b border-gray-200 text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                    Stock Opname
                </h1>
                <p class="text-sm text-gray-500 mt-2">
                    Silakan scan barcode atau unggah QR code untuk melanjutkan
                </p>
            </div>

            
            <div class="px-4 py-4 space-y-4">
                <div class="flex flex-col md:flex-row md:items-start md:gap-3">
                    
                    <div class="flex-1">
                        <input
                            type="text"
                            wire:model.defer="kodeAset"
                            class="block w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Tempel / scan kode aset di sini"
                        >
                    </div>

                    
                    <div class="mt-3 md:mt-0 flex-shrink-0 flex gap-2">
                        
                        <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['wire:click' => 'cariAset','color' => 'primary','icon' => 'heroicon-o-qr-code']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'cariAset','color' => 'primary','icon' => 'heroicon-o-qr-code']); ?>
                            Check QR Code
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>

                        
                        <div x-data>
                            
                            <input
                                x-ref="qrInput"
                                id="qrUpload"
                                type="file"
                                accept="image/*,application/pdf"
                                class="hidden"
                                wire:model="qrFile"
                            />

                            
                            <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'success','icon' => 'heroicon-o-arrow-up-tray','xOn:click' => '$refs.qrInput.click()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'success','icon' => 'heroicon-o-arrow-up-tray','x-on:click' => '$refs.qrInput.click()']); ?>
                                Unggah QR Code
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>

                

                
                <div class="flex justify-center">
                    
                    <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'gray','icon' => 'heroicon-o-arrow-path','wire:click' => 'refreshOpname']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon' => 'heroicon-o-arrow-path','wire:click' => 'refreshOpname']); ?>
                        Refresh
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                </div>
            </div>

            
            <div class="px-4 pb-4">
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    
                    <div class="px-4 py-2 border-b border-gray-200 bg-gray-50 text-center text-sm font-semibold text-gray-700">
                        Hasil Scan:
                    </div>

                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-800">
                            <thead class="bg-gray-100 border-b border-gray-200 text-xs text-gray-600 uppercase">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium">Nama Aset</th>
                                    <th class="px-4 py-2 text-left font-medium">Merk</th>
                                    <th class="px-4 py-2 text-left font-medium">Status</th>
                                    <th class="px-4 py-2 text-left font-medium">Qty</th>
                                    <th class="px-4 py-2 text-left font-medium">Barcode</th>
                                    <th class="px-4 py-2 text-left font-medium">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if($foundAset): ?>
                                    <tr class="border-b border-gray-200">
                                        
                                        <td class="px-4 py-3 align-top">
                                            <div class="text-gray-900">
                                                <?php echo e($foundAset['nama_aset'] ?? '-'); ?>

                                            </div>
                                        </td>

                                        
                                        <td class="px-4 py-3 align-top">
                                            <div class="text-gray-700">
                                                <?php echo e($foundAset['merk'] ?? '-'); ?>

                                            </div>
                                        </td>

                                        
                                        <td class="px-4 py-3 align-top">
                                            <div class="flex flex-col gap-2 w-[110px]">

                                                
                                                <select
                                                    wire:model.defer="statusBaru"
                                                    class="block w-full rounded border border-gray-300 text-sm px-2 py-1.5 focus:border-primary-500 focus:ring-primary-500"
                                                >
                                                    <option value="OK">OK</option>
                                                    <option value="Rusak">Rusak</option>
                                                    <option value="Hilang">Hilang</option>
                                                    <option value="Dipinjam">Dipinjam</option>
                                                </select>

                                                
                                                <div class="text-[11px] text-gray-500 leading-tight">
                                                    Kondisi lama:
                                                    <span class="font-medium text-gray-700">
                                                        <?php echo e($foundAset['status_now'] ?? '-'); ?>

                                                    </span>
                                                </div>

                                                
                                                
                                            </div>
                                        </td>

                                        
                                        <td class="px-4 py-3 align-top text-gray-700">
                                            <?php echo e($foundAset['qty'] ?? 1); ?>

                                        </td>

                                        
                                        <td class="px-4 py-3 align-top text-gray-700 font-mono text-xs select-all">
                                            <?php echo e($foundAset['barcode'] ?? '-'); ?>

                                        </td>

                                        
                                        <td class="px-4 py-3 align-top">
                                            <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['wire:click' => 'simpanOpname','color' => 'warning','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'simpanOpname','color' => 'warning','size' => 'sm']); ?>
                                                Update Status
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-400 text-sm">
                                            Belum ada hasil scan.
                                            Silakan scan / cari barcode aset.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div> 
        </div> 
    </div> 

    
    <div
        x-data="qrScannerComponent()"
        x-show="<?php echo \Illuminate\Support\Js::from($showCameraModal)->toHtml() ?>"
        x-cloak
        class="fixed inset-0 z-[2000] flex items-center justify-center bg-black/60"
        x-init="
            $watch(
                () => <?php echo \Illuminate\Support\Js::from($showCameraModal)->toHtml() ?>,
                value => {
                    if (value) {
                        startCamera();
                    } else {
                        stopCamera();
                    }
                }
            );
        "
    >
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-4 relative">

            
            <button
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xs border border-gray-300 rounded px-2 py-1"
                wire:click="tutupKamera"
                x-on:click="stopCamera()"
            >
                Tutup
            </button>

            <h2 class="text-sm font-semibold text-gray-800 mb-3">
                Arahkan QR Aset ke Kamera
            </h2>

            <div class="w-full bg-black rounded overflow-hidden flex items-center justify-center">
                <video
                    x-ref="videoEl"
                    class="w-full h-auto"
                    playsinline
                    muted
                ></video>
            </div>

            <p class="text-[11px] text-gray-500 mt-2 leading-tight">
                Kami akan mencoba membaca QR secara otomatis.
            </p>

        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

    <script>
        function qrScannerComponent() {
            return {
                videoStream: null,
                scanning: false,
                videoEl: null,
                canvasEl: null,
                ctx: null,

                startCamera() {
                    if (this.scanning) return;

                    this.videoEl = this.$refs.videoEl;

                    // siapkan canvas off-screen untuk baca frame
                    this.canvasEl = document.createElement('canvas');
                    this.ctx = this.canvasEl.getContext('2d');

                    navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'environment' }
                    })
                    .then(stream => {
                        this.videoStream = stream;
                        this.videoEl.srcObject = stream;
                        this.videoEl.play();
                        this.scanning = true;
                        this.tick(); // mulai loop scan
                    })
                    .catch(err => {
                        console.error('Gagal akses kamera', err);
                        this.scanning = false;
                        // fallback: berhentiin modal
                        Livewire.dispatch('tutupKamera'); // panggil method tutupKamera()
                    });
                },

                stopCamera() {
                    this.scanning = false;
                    if (this.videoStream) {
                        this.videoStream.getTracks().forEach(t => t.stop());
                        this.videoStream = null;
                    }
                },

                tick() {
                    if (!this.scanning) return;

                    if (this.videoEl.readyState === this.videoEl.HAVE_ENOUGH_DATA) {
                        // set ukuran canvas == frame video
                        this.canvasEl.width  = this.videoEl.videoWidth;
                        this.canvasEl.height = this.videoEl.videoHeight;
                        this.ctx.drawImage(
                            this.videoEl,
                            0,
                            0,
                            this.canvasEl.width,
                            this.canvasEl.height
                        );

                        const imageData = this.ctx.getImageData(
                            0,
                            0,
                            this.canvasEl.width,
                            this.canvasEl.height
                        );

                        const qrResult = jsQR(imageData.data,
                            imageData.width,
                            imageData.height,
                            { inversionAttempts: "dontInvert" }
                        );

                        if (qrResult && qrResult.data) {
                            // QR ketemu!
                            const kode = qrResult.data.trim();

                            // stop kamera
                            this.stopCamera();

                            // kirim hasil QR ke Livewire
                            Livewire.dispatch('kode-dari-kamera', {0: kode});

                            return; // jangan lanjut loop
                        }
                    }

                    // lanjut loop tiap ~150ms
                    setTimeout(() => this.tick(), 150);
                },
            }
        }
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $attributes = $__attributesOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__attributesOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $component = $__componentOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__componentOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\BackendInven\resources\views/filament/pages/stock-opname-page.blade.php ENDPATH**/ ?>