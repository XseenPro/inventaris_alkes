<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Perangkat extends Model
{
  protected $table = 'perangkats';

  protected $fillable = [
    'lokasi_id',
    'kategori_id',
    'jenis_id',
    'kondisi_id',
    // 'bulan',
    'tanggal_entry',
    'nomor_inventaris',
    'nama_perangkat',
    'merek_alat',
    // 'jumlah_alat',
    'tipe',
    'nomor_seri',
    'distributor_id',
    'supplier_id',
    'no_akl_akd',
    'produk',
    'tanggal_pembelian',
    // 'tahun_pembelian',
    'sumber_pendanaan',
    'harga_beli_ppn',
    'harga_beli_non_ppn',
    'keterangan',
    'created_by',
    'updated_by',
  ];

  protected $casts = [
    'tanggal_entry' => 'date',
    'tanggal_pembelian' => 'date',
  ];

  public function lokasi(): BelongsTo
  {
    return $this->belongsTo(Lokasi::class);
  }
  public function kategori(): BelongsTo
  {
    return $this->belongsTo(Kategori::class);
  }
  public function jenis(): BelongsTo
  {
    return $this->belongsTo(Jenis::class, 'jenis_id');
  }
  public function kondisi(): BelongsTo
  {
    return $this->belongsTo(Kondisi::class);
  }
  public function distributor(): BelongsTo
  {
    return $this->belongsTo(Distributor::class);
  }
  public function supplier():BelongsTo
  {
    return $this->belongsTo(Supplier::class);
  }
  public function riwayatMaintenances(): HasMany
    {
        return $this->hasMany(RiwayatMaintenance::class);
    }
    public function maintenanceTerakhir(): HasOne
    {
        return $this->hasOne(RiwayatMaintenance::class)->latestOfMany();
    }
    public function scopeAktif(Builder $q): Builder
    {
        return $q->whereHas('kondisi', fn($qq) => $qq->where('nama_kondisi', 'Aktif'));
    }
    public function scopePerbaikan(Builder $q): Builder
    {
        return $q->whereHas('kondisi', fn($qq) => $qq->where('nama_kondisi', 'Perbaikan'));
    }
    public function peminjamans()
    {
        return $this->hasMany(\App\Models\Peminjaman::class);
    }
}
