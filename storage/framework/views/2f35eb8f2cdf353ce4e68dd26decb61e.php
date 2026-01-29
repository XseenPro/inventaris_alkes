<div class="space-y-2">
    <?php
        $dupeCount = count($this->dupes ?? []);
    ?>
    <div class="text-sm">
        <div><strong>Total baris di file:</strong> <?php echo e($this->totalRows); ?></div>
        <div><strong>Jumlah duplikat ditemukan:</strong> <?php echo e($dupeCount); ?></div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dupeCount > 0): ?>
        <div class="text-sm font-medium mt-2">Daftar duplikat (maks. 100 pertama):</div>
        <div class="max-h-56 overflow-auto border rounded p-2 text-xs">
            <ul class="list-disc pl-5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice($this->dupes, 0, 100); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($n); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </div>
    <?php else: ?>
        <div class="text-sm text-green-700">Tidak ada duplikat. Semua baris akan diperlakukan sebagai data baru (insert).</div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH E:\Magang\Inventaris AlKes\inventory-alkes\resources\views/filament/import/preview-summary.blade.php ENDPATH**/ ?>