<div>
  <?php
  /** @var \App\Filament\Pages\ImportPerangkat $this */
  $headers = $this->headers ?? [];
  $rows = $this->previewRows ?? [];
  $limit = $this->previewLimit ?? 50;
  $total = $this->totalRows ?? 0;
  ?>

  <div class="filament-tables-container overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr>
          <th class="px-3 py-2 text-left text-gray-600">#</th>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <th class="px-3 py-2 text-left text-gray-600"><?php echo e(\Illuminate\Support\Str::headline($h)); ?></th>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr class="border-t">
          <td class="px-3 py-2 text-gray-500"><?php echo e($i + 1); ?></td>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
          $v = $r[$h] ?? '';
          if (!is_scalar($v)) {
          $v = json_encode($v);
          }
          $s = trim((string) $v);
          ?>
          <td class="px-3 py-2 whitespace-nowrap">
            <?php echo e(\Illuminate\Support\Str::limit($s, 120)); ?>

          </td>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="<?php echo e(count($headers) + 1); ?>" class="px-3 py-4 text-center text-gray-500">
            Tidak ada data terbaca dari file.
          </td>
        </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </tbody>

    </table>
  </div>

  <div class="mt-2 text-xs text-gray-500">
    Menampilkan maksimal <?php echo e($limit); ?> baris dari total <?php echo e($total); ?> baris.
    Kolom sudah dinormalisasi (mis. <code>no inventaris</code> → <code>nomor_inventaris</code>, <code>tahun</code> → <code>tahun_pengadaan</code>, dst).
  </div>
</div><?php /**PATH E:\Magang\Inventaris AlKes\inventory-alkes\resources\views/filament/import/preview-table.blade.php ENDPATH**/ ?>