<?php
    $record = $getRecord();
?>

<div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
    
    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-gray-800 dark:bg-gray-800/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <?php echo e($record->perangkat->nama_perangkat ?? $record->nama_perangkat ?? 'Nama Perangkat Tidak Ada'); ?>

            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Inventaris: <span class="font-mono font-semibold text-primary-600 dark:text-primary-400"><?php echo e($record->nomor_inventaris ?? '-'); ?></span>
                &bull; Tipe: <?php echo e($record->tipe ?? '-'); ?>

            </p>
        </div>
        
        <div class="px-3 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-700 dark:bg-primary-900/50 dark:text-primary-400 border border-primary-200 dark:border-primary-700">
            <?php echo e($record->kondisi->nama_kondisi ?? 'Kondisi: -'); ?>

        </div>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 relative">
            
            <div class="flex-1 w-full text-center md:text-left bg-red-50 dark:bg-red-900/10 p-4 rounded-lg border border-red-100 dark:border-red-900/30">
                <p class="text-xs font-medium uppercase tracking-wider text-red-600 dark:text-red-400 mb-1">
                    Lokasi Asal
                </p>
                <div class="flex items-center justify-center md:justify-start gap-2">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-building-office-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-red-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    <span class="text-lg font-bold text-gray-800 dark:text-gray-200">
                        <?php echo e($record->lokasiAsal->nama_lokasi ?? '-'); ?>

                    </span>
                </div>
            </div>

            <div class="hidden md:flex flex-col items-center justify-center text-gray-400 dark:text-gray-600 z-10">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                <span class="text-[10px] font-medium uppercase mt-1">Dipindahkan</span>
            </div>
            <div class="md:hidden text-gray-400 dark:text-gray-600 rotate-90 my-[-10px]">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-arrow-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            </div>

            <div class="flex-1 w-full text-center md:text-right bg-green-50 dark:bg-green-900/10 p-4 rounded-lg border border-green-100 dark:border-green-900/30">
                <p class="text-xs font-medium uppercase tracking-wider text-green-600 dark:text-green-400 mb-1">
                    Lokasi Tujuan
                </p>
                <div class="flex items-center justify-center md:justify-end gap-2">
                    <span class="text-lg font-bold text-gray-800 dark:text-gray-200">
                        <?php echo e($record->lokasiMutasi->nama_lokasi ?? '-'); ?>

                    </span>
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-map-pin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-green-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-white border-b pb-2 border-gray-100 dark:border-gray-800">Timeline Mutasi</h4>
                <div class="relative pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-4">
                    <div class="relative">
                        <div class="absolute -left-[21px] bg-white dark:bg-gray-900 p-0.5">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                        </div>
                        <p class="text-xs text-gray-500">Tanggal Mutasi</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            <?php echo e($record->tanggal_mutasi ? \Carbon\Carbon::parse($record->tanggal_mutasi)->isoFormat('dddd, D MMMM Y') : '-'); ?>

                        </p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[21px] bg-white dark:bg-gray-900 p-0.5">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        </div>
                        <p class="text-xs text-gray-500">Tanggal Diterima</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            <?php echo e($record->tanggal_diterima ? \Carbon\Carbon::parse($record->tanggal_diterima)->isoFormat('dddd, D MMMM Y') : 'Belum Diterima'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-white border-b pb-2 border-gray-100 dark:border-gray-800">Keterangan</h4>
                
                <div class="bg-gray-50 dark:bg-gray-800/50 p-3 rounded-md text-sm text-gray-600 dark:text-gray-300 italic border border-gray-100 dark:border-gray-800">
                    "<?php echo e($record->alasan_mutasi ?? 'Tidak ada keterangan khusus.'); ?>"
                </div>

                <div class="flex items-center gap-2 mt-4 pt-2">
                    <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-500">
                        <?php echo e(substr($record->user->name ?? '?', 0, 1)); ?>

                    </div>
                    <div class="text-xs text-gray-500">
                        <p>Dibuat oleh: <span class="font-medium text-gray-700 dark:text-gray-300"><?php echo e($record->user->name ?? '-'); ?></span></p>
                        <p><?php echo e($record->created_at->diffForHumans()); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH E:\Magang\Inventaris AlKes\inventory-alkes\resources\views/infolists/mutasi.blade.php ENDPATH**/ ?>