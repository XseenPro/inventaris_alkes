<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPerangkatController;
use App\Http\Controllers\PublicMaintenanceController;

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
