<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPerangkatController;
use App\Http\Controllers\PublicMaintenanceController;
use App\Http\Controllers\KalibrasiSertifikatController;
use App\Http\Controllers\ExportController;
use App\Models\Perangkat;

Route::get('/', function () {
  return redirect('/admin');
});

Route::get('/perangkat/{perangkat}', [PublicPerangkatController::class, 'show'])
  ->name('public.perangkat.show');
Route::get('/maintenance/{riwayat}', [PublicMaintenanceController::class, 'show'])
  ->name('public.maintenance.show');

Route::get('/cetak-semua-stiker', [PublicPerangkatController::class, 'cetakSemuaStiker'])
  ->name('cetak.semua.stiker');

Route::get('/cetak/stiker/{perangkat}', [PublicPerangkatController::class, 'cetakSatu'])
  ->name('cetak.satu.stiker');

Route::get('/export/perangkat-all', [ExportController::class, 'exportPerangkatAllExcel'])
  ->name('export.perangkat.all.excel');
Route::get('/export/kalibrasi-all', [ExportController::class, 'exportKalibrasiAllExcel'])
  ->name('export.kalibrasi.all.excel');
Route::get('/export/mutasi/resume-pdf', [ExportController::class, 'exportMutasiResumePdf'])
  ->name('mutasi.resume.pdf')
  ->middleware('auth');

Route::get('/kalibrasi/sertifikat/{kalibrasi}/download', [KalibrasiSertifikatController::class, 'download'])
  ->name('kalibrasi.sertifikat.download');

Route::post('/kalibrasi/sertifikat/{kalibrasi}/verify-password', [KalibrasiSertifikatController::class, 'verifyPassword'])
  ->name('kalibrasi.sertifikat.verify-password');

Route::model('perangkat', Perangkat::class);
