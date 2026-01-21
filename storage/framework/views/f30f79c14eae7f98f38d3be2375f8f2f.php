<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">

  <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/10 blur-xl"></div>
    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-white/10 blur-lg"></div>

    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
      <div>
        <h2 class="text-2xl font-bold tracking-tight text-white">
          <?php echo e($record->nama_perangkat ?? 'Nama Tidak Diketahui'); ?>

        </h2>
        <div class="flex items-center gap-3 mt-2 text-blue-100 text-sm font-medium">
          <span class="bg-white/20 px-2 py-1 rounded text-xs backdrop-blur-sm border border-white/20">
            INV: <?php echo e($record->nomor_inventaris ?? '-'); ?>

          </span>
          <span class="flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <?php echo e($record->kategori->nama_kategori ?? '-'); ?>

          </span>
        </div>
      </div>

      <div class="flex flex-row gap-2">
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-lg px-4 py-2 text-center shadow-sm min-w-[100px]">
          <span class="block text-[10px] text-blue-100 uppercase tracking-wider">Kondisi</span>
          <span class="text-sm font-bold text-white flex items-center justify-center gap-2" style="text-transform: capitalize !important;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(strtolower($record->kondisi->nama_kondisi ?? '') == 'baik'): ?>
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
            <?php else: ?>
            <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php echo e($record->kondisi->nama_kondisi ?? '-'); ?>

          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-0 border-b border-gray-100 dark:border-gray-700">
    <div class="p-6 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
      <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        Lokasi Penempatan
      </span>
      <p class="mt-2 text-lg font-medium text-gray-900 dark:text-gray-100">
        <?php echo e($record->lokasi->nama_lokasi ?? '-'); ?>

      </p>
    </div>
    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
      <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
        </svg>
        Jenis Perangkat
      </span>
      <p class="mt-2 text-lg font-medium text-gray-900 dark:text-gray-100">
        <?php echo e($record->jenis->nama_jenis ?? '-'); ?>

      </p>
    </div>
  </div>

  <div class="p-6">
    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
      Spesifikasi & Pembelian
    </h3>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-y-6 gap-x-4">
      <div>
        <p class="text-xs text-gray-500 mb-1">Merek</p>
        <p class="font-medium text-gray-900 dark:text-gray-200 text-sm"><?php echo e($record->merek_alat ?? '-'); ?></p>
      </div>
      <div>
        <p class="text-xs text-gray-500 mb-1">Tipe / Model</p>
        <p class="font-medium text-gray-900 dark:text-gray-200 text-sm"><?php echo e($record->tipe ?? '-'); ?></p>
      </div>
      <div>
        <p class="text-xs text-gray-500 mb-1">Nomor Seri (SN)</p>
        <p class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs inline-block text-gray-800 dark:text-gray-200">
          <?php echo e($record->nomor_seri ?? '-'); ?>

        </p>
      </div>
      <?php
      $tanggal = $record->tanggal_pembelian
      ? $record->tanggal_pembelian->translatedFormat('d F Y')
      : '-';
      ?>

      <div>
        <p class="text-xs text-gray-500 mb-1">Tanggal Pembelian</p>
        <p class="font-medium text-gray-900 dark:text-gray-200 text-sm">
          <?php echo e($tanggal); ?>

        </p>
      </div>

      <div>
        <p class="text-xs text-gray-500 mb-1">Distributor</p>
        <p class="font-medium text-gray-900 dark:text-gray-200 text-sm truncate" title="<?php echo e($record->distributor); ?>">
          <?php echo e($record->distributor->nama_distributor ?? '-'); ?>

        </p>
      </div>
      <div>
        <p class="text-xs text-gray-500 mb-1">Supplier</p>
        <p class="font-medium text-gray-900 dark:text-gray-200 text-sm truncate" title="<?php echo e($record->supplier); ?>">
          <?php echo e($record->supplier->nama_supplier ?? '-'); ?>

        </p>
      </div>
      <div class="col-span-2 md:col-span-2">
        <p class="text-xs text-gray-500 mb-1">Harga Beli (Termasuk PPN)</p>
        <p class="font-bold text-green-600 dark:text-green-400 text-base">
          Rp <?php echo e(number_format($record->harga_beli_ppn, 0, ',', '.')); ?>

        </p>
      </div>
    </div>
  </div>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($record->keterangan): ?>
  <div class="px-6 pb-6">
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
      <h4 class="text-xs font-bold text-yellow-800 dark:text-yellow-500 uppercase mb-2 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Catatan Tambahan
      </h4>
      <p class="text-sm text-gray-700 dark:text-gray-300 italic">
        "<?php echo e($record->keterangan); ?>"
      </p>
    </div>
  </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <div class="bg-gray-50 dark:bg-gray-900 px-6 py-3 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center text-xs text-gray-400">
    <div>
      Dibuat: <span class="font-medium"><?php echo e($record->created_at?->format('d M Y H:i')); ?></span>
    </div>
    <div>
      Update: <span class="font-medium"><?php echo e($record->updated_at?->format('d M Y H:i')); ?></span>
    </div>
  </div>
</div><?php /**PATH E:\Magang\Inventaris AlKes\inventory-alkes\resources\views/infolists/alat-kesehatan-detail.blade.php ENDPATH**/ ?>