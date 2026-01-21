<?php
namespace App\Http\Controllers;

use App\Models\Perangkat;
use Illuminate\Http\Request;

class PublicPerangkatController extends Controller
{
    public function show(Perangkat $perangkat)
    {
        $perangkat->load('riwayatMaintenances', 'lokasi', 'jenis',  'kondisi');
        return view('public.perangkat-detail', compact('perangkat'));
    }
    public function cetakSemuaStiker()
    {
        $records = Perangkat::all();
        return view('cetak-stiker-massal', compact('records'));
    }

    public function cetakSatu(Perangkat $perangkat)
    {
        $record = $perangkat; 
        return view('cetak-stiker', compact('record'));
    }
}