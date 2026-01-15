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
    Schema::create('kalibrasi', function (Blueprint $table) {
      $table->id();
      $table->foreignId('perangkat_id')->constrained('perangkats')->onDelete('cascade');
      $table->string('nomor_sertifikat')->nullable();
      $table->foreignId('lokasi_id')->nullable()->constrained('lokasis')->nullOnDelete();
      $table->date('tanggal_pelaksanaan')->nullable()->index('tanggal_pelaksanaan');
      $table->date('tanggal_kalibrasi')->nullable()->index('tanggal_kalibrasi');
      $table->date('tanggal_kalibrasi_ulang')->nullable()->index('tanggal_kalibrasi_ulang');
      $table->timestamp('reminder_h7_sent_at')->nullable()->index();
      $table->string('hasil_kalibrasi')->nullable();
      $table->string('keterangan')->nullable();
      $table->string('sertifikat_kalibrasi')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('kalibrasi');
  }
};
