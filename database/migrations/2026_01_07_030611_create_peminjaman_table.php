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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perangkat_id')->nullable()->constrained('perangkats')->nullOnDelete();
            $table->string('pihak_kedua_nama');
            $table->string('nomor_inventaris')->nullable()->index();
            $table->string('nama_barang');
            $table->string('merk')->nullable();
            $table->string('kondisi_terakhir')->nullable();

            $table->text('alasan_pinjam')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->string('status')->default('Menunggu')->index();
            $table->text('catatan')->nullable();

            $table->timestamp('reminder_h3_sent_at')->nullable()->index();
            $table->string('peminjam_email')->nullable();

            $table->foreignId('requested_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->enum('status', ['Menunggu', 'Dipinjam', 'Dikembalikan', 'Terlambat', 'Ditolak'])
                  ->default('Menunggu')->change();

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
