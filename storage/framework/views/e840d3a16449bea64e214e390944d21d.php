<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['url']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['url']); ?>
<?php foreach (array_filter((['url']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<tr>
  <td class="header" align="center">
    <?php if(trim($slot) === 'Laravel'): ?>
        <?php
            $logoUrl = 'https://i.ibb.co.com/k221trdy/sanditel-logo.png';                        
        ?>
        <img src="<?php echo e($logoUrl); ?>" alt="Sanditel Logo" style="height:60px;">
    <?php else: ?>
        <?php echo e($slot); ?>

    <?php endif; ?>
  </td>
</tr>
<?php /**PATH C:\xampp\htdocs\BackendInven\resources\views/vendor/mail/html/header.blade.php ENDPATH**/ ?>