<?php

namespace App\Filament\Exports;

use App\Models\Perangkat;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class PerangkatAllExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithColumnFormatting,
    WithEvents
{
    private int $no = 0;
    private ?string $password;

    public function __construct(?string $password = null)
    {
        $this->password = $password;
    }

    public function query(): Builder
    {
        return Perangkat::query()
            ->with(['lokasi', 'jenis', 'status', 'kondisi', 'kategori'])
            ->orderBy('id', 'asc');
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Perangkat',
            'Tipe',
            'Spesifikasi',
            'Deskripsi',
            'Lokasi',
            'Perolehan',
            'Tahun Pengadaan',
            'Status',
            'Kondisi',
            'Jenis',
            'Nomor Inventaris',
            'Harga',
            'Catatan',
            'Mutasi',
            'Upgrade',
            'Tanggal Distribusi',
            'Kategori',
            'Kode Kategori',
            'Kode',
        ];
    }

    public function map($row): array
    {
        $this->no++;

        return [
            $this->no,
            $row->nama_perangkat,
            $row->tipe,
            $row->spesifikasi,
            $row->deskripsi,
            $row->lokasi?->nama_lokasi,
            $row->perolehan,
            $row->tahun_pengadaan,
            $row->status?->nama_status,
            $row->kondisi?->nama_kondisi,
            $row->jenis?->nama_jenis,
            $row->nomor_inventaris,
            (int) $row->harga,
            $row->catatan,
            $row->mutasi,
            $row->upgrade,
            optional($row->tanggal_distribusi)->format('Y-m-d'),
            $row->kategori?->nama_kategori,
            $row->kategori?->kode_kategori,
            $row->kode,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'M' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0);

                if ($this->password) {
                    $sheet->getProtection()->setPassword($this->password);
                    $sheet->getProtection()->setSheet(true);
                }
            },
        ];
    }
}
