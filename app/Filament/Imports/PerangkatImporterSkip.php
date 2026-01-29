<?php

namespace App\Filament\Imports;

use App\Models\Perangkat;
use App\Filament\Imports\Traits\MapsMaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use App\Support\NomorInventarisGenerator;

class PerangkatImporterSkip implements
  ToModel,
  WithHeadingRow,
  WithBatchInserts,
  WithChunkReading,
  WithValidation,
  SkipsOnFailure
{
  use \Maatwebsite\Excel\Concerns\Importable;
  use MapsMaster;

  public function headingRow(): int
  {
    return 2;
  }

  public function __construct()
  {
    $this->bootMasterMaps();
  }

  public function rules(): array
  {
    return [
      'nomor_inventaris' => 'nullable|unique:perangkats,nomor_inventaris',
    ];
  }

  public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures) {}

  public function model(array $row)
  {
    $row = $this->normalizeRowKeys($row);

    $namaPerangkat = trim((string)($row['nama_perangkat'] ?? ''));
    if ($namaPerangkat === '') return null;

    $nomor = $this->normalizeNomor($row['nomor_inventaris'] ?? null);

    $lokasi_id  = $this->getOrCreateId($this->lokasiMap,  \App\Models\Lokasi::class,  'nama_lokasi',  $row['lokasi'] ?? null);
    $kondisi_id = $this->getOrCreateId($this->kondisiMap, \App\Models\Kondisi::class, 'nama_kondisi', $row['kondisi'] ?? null);

    // harga dari file Alkes
    $hargaNonPpn = !empty($row['harga_beli_non_ppn'])
      ? (int) preg_replace('/\D+/', '', (string) $row['harga_beli_non_ppn'])
      : null;

    $hargaPpn = !empty($row['harga_beli_ppn'])
      ? (int) preg_replace('/\D+/', '', (string) $row['harga_beli_ppn'])
      : null;

    $tanggalEntry      = $this->parseTanggal($row['tanggal_entry'] ?? null);
    $tanggalPembelian  = $this->parseTanggal($row['tanggal_pembelian'] ?? null);

    $tahun        = (int) now()->year;
    $jenis_id     = null;
    $kategori_id  = null;

    if ($nomor && ($parts = $this->parseNomorInventaris($nomor))) {
      $jenis_id    = $this->resolveOrUpsertJenisFromNI($parts['prefix'], $parts['kode_jenis']);
      $kategori_id = $this->resolveOrCreateKategoriByKode($parts['kode_kat'], $namaPerangkat);
      $tahun       = $parts['tahun'];
    } else {
      $jenis_model = $this->resolveOrCreateJenisByName($row['jenis'] ?? 'Hardware');
      $kategori    = $this->resolveKategoriByNamaPerangkat($namaPerangkat);
      $tahun       = !empty($row['tahun_pengadaan']) ? (int)$row['tahun_pengadaan'] : (int) now()->year;

      if (!$jenis_model || !$kategori) return null;

      $jenis_id    = (int) $jenis_model->id;
      $kategori_id = (int) $kategori->id;

      $nomor = NomorInventarisGenerator::generate($jenis_id, $kategori_id, $tahun);
    }

    $kode = isset($row['kode']) ? (trim((string)$row['kode']) ?: null) : null;

    return new Perangkat([
      'lokasi_id'          => $lokasi_id,
      'kategori_id'        => $kategori_id,
      'jenis_id'           => $jenis_id,
      'kondisi_id'         => $kondisi_id,

      'tanggal_entry'      => $tanggalEntry,
      'nomor_inventaris'   => $nomor,

      'nama_perangkat'     => $namaPerangkat,
      'merek_alat'         => $row['merek_alat'] ?? null,
      'tipe'               => $row['tipe'] ?? null,
      'nomor_seri'         => $row['nomor_seri'] ?? null,

      'no_akl_akd'         => $row['no_akl_akd'] ?? null,
      'produk'             => $row['produk'] ?? null,

      'tanggal_pembelian'  => $tanggalPembelian,
      'sumber_pendanaan'   => $row['sumber_pendanaan'] ?? null,

      'harga_beli_ppn'     => $hargaPpn,
      'harga_beli_non_ppn' => $hargaNonPpn,

      'keterangan'         => $row['keterangan'] ?? null,

      'tahun_pengadaan'    => $tahun,
    ]);
  }


  public function batchSize(): int
  {
    return 1000;
  }
  public function chunkSize(): int
  {
    return 1000;
  }
}
