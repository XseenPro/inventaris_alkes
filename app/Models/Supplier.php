<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends model 
{
  protected $table = 'supplier';
  protected $fillable = [
    'nama_supplier',
    'keterangan'
  ];
}