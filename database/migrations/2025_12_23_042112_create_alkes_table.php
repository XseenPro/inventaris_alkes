<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perangkats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_id')->constrained('lokasis')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('jenis_id')->nullable()->constrained('jenis_perangkats')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('kondisi_id')->nullable()->constrained('kondisis')->cascadeOnUpdate()->nullOnDelete();

            // $table->string('bulan', 20)->nullable();
            $table->date('tanggal_entry')->nullable();
            $table->string('nomor_inventaris')->nullable();

            // identitas alat
            $table->string('nama_perangkat');
            $table->string('merek_alat')->nullable();
            // $table->unsignedInteger('jumlah_alat')->default(1);
            $table->string('tipe')->nullable();
            $table->string('nomor_seri')->nullable();

            $table->foreignId('distributor_id')->nullable()->constrained('distributor')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('supplier')->cascadeOnUpdate()->nullOnDelete();
            $table->string('no_akl_akd')->nullable();
            $table->string('produk')->nullable();

            $table->date('tanggal_pembelian')->nullable();
            // $table->unsignedSmallInteger('tahun_pembelian')->nullable();
            $table->string('sumber_pendanaan')->nullable();

            $table->unsignedBigInteger('harga_beli_ppn')->nullable();
            $table->unsignedBigInteger('harga_beli_non_ppn')->nullable();

            $table->text('keterangan')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['lokasi_id', 'nama_perangkat']);
            $table->unique(['nomor_seri'], 'perangkat_nomor_seri_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alkes');
    }
};
