<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kalibrasi extends Model 
{
  protected $table = 'kalibrasi';

  protected $fillable = [
    'perangkat_id',
    'nomor_sertifikat',
    'lokasi_id',
    'tanggal_pelaksanaan',
    'tanggal_kalibrasi',
    'tanggal_kalibrasi_ulang',
    'hasil_kalibrasi',
    'keterangan',
    'sertifikat_kalibrasi'
  ];

  protected $casts = [
    'tanggal_kalibrasi' => 'date',
    'tanggal_kalibrasi_ulang' => 'date',
    'tanggal_pelaksanaan' => 'date',
  ];

  public function perangkats(): BelongsTo {
    return $this->belongsTo(Perangkat::class, 'perangkat_id');
  }

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function lokasi(): BelongsTo {
    return $this->belongsTo(Lokasi::class);
  }
}