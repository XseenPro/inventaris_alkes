<?php $__env->startComponent('mail::message'); ?>
# 📢 Pengingat Pengembalian Barang

Halo **<?php echo new \Illuminate\Support\EncodedHtmlString($peminjaman->pihak_kedua_nama ?? '-'); ?>**,  
Batas waktu pengembalian perangkat tinggal **3 hari lagi**.

### 🔧 Detail Peminjaman
- **Barang:** <?php echo new \Illuminate\Support\EncodedHtmlString($peminjaman->nama_barang ?? '-'); ?>

- **Nomor Inventaris:** <?php echo new \Illuminate\Support\EncodedHtmlString($peminjaman->nomor_inventaris ?? '-'); ?>

- **Batas Pengembalian:** <?php echo new \Illuminate\Support\EncodedHtmlString(optional($peminjaman->tanggal_selesai)->format('d F Y')); ?> (**3 Hari Lagi**)

<?php $__env->startComponent('mail::panel'); ?>
Pastikan barang dikembalikan tepat waktu. Terima kasih!
<?php echo $__env->renderComponent(); ?>

Salam,  
**Tim SIRS**
<?php echo $__env->renderComponent(); ?>
<?php /**PATH E:\Magang\Inventaris AlKes\inventory-alkes\resources\views/emails/peminjaman/due_soon.blade.php ENDPATH**/ ?>