<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
  protected $table = 'distributor';
  protected $fillable = [
    'nama_distributor',
    'keterangan'
  ];
}