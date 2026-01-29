<?php

namespace App\Filament\Exports;

use App\Models\Kalibrasi;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;

class KalibrasiAllExport implements
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
        return Kalibrasi::query()
            ->with(['perangkats', 'lokasi', 'perangkats.jenis', 'perangkats.kondisi', 'perangkats.kategori'])
            ->orderBy('id', 'asc');
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Sertifikat',
            'Nomor Inventaris',
            'Nama Alat',
            'Jenis Alat',
            'Merek Alat',
            'Tipe Alat',
            'Nomor Seri',
            'Lokasi Ruangan',
            'Tanggal Pelaksanaan',
            'Tanggal Kalibrasi',
            'Tanggal Kalibrasi Ulang',
            'Hasil Kalibrasi',
            'Keterangan',
            'Sertifikat'
        ];
    }

    public function map($row): array
    {
        $this->no++;

        $sertifikatValue = 'Tidak Ada';
        if ($row->sertifikat_kalibrasi) {
            $sertifikatValue = URL::temporarySignedRoute(
                'kalibrasi.sertifikat.download',
                now()->addDays(30),
                ['kalibrasi' => $row->id]
            );
        }

        return [
            $this->no,
            $row->nomor_sertifikat,
            $row->perangkats?->nomor_inventaris,
            $row->perangkats?->nama_perangkat,
            $row->perangkats?->jenis?->nama_jenis,
            $row->perangkats?->merek_alat,
            $row->perangkats?->tipe,
            $row->perangkats?->nomor_seri,
            $row->lokasi?->nama_lokasi,
            optional($row->tanggal_pelaksanaan)->format('d-m-Y'),
            optional($row->tanggal_kalibrasi)->format('d-m-Y'),
            optional($row->tanggal_kalibrasi_ulang)->format('d-m-Y'),
            $row->hasil_kalibrasi,
            $row->keterangan,
            $sertifikatValue,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $sheet->insertNewRowBefore(1, 1);

                $title = 'DATA KALIBRASI ALAT KESEHATAN';
                $titleCell = 'A1';
                $titleRange = 'A1:' . $highestColumn . '1';

                $sheet->mergeCells($titleRange);
                $sheet->setCellValue($titleCell, $title);

                $titleStyle = $sheet->getStyle($titleRange);
                $titleStyle->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFFFFF00');
                $titleStyle->getFont()
                    ->setBold(true)
                    ->setSize(13);
                $titleStyle->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension('1')->setRowHeight(22);

                $headerRange = 'A2:' . $highestColumn . '2';
                $headerStyle = $sheet->getStyle($headerRange);

                $headerStyle->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF1F4E78');
                $headerStyle->getFont()
                    ->setBold(true)
                    ->setSize(11)
                    ->getColor()
                    ->setARGB('FFFFFFFF');
                $headerStyle->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()
                    ->setARGB('FF000000');
                $headerStyle->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);
                $sheet->getRowDimension('2')->setRowHeight(25);

                $newHighestRow = $sheet->getHighestRow();
                $lightGrayFill = 'FFF2F2F2';

                for ($row = 3; $row <= $newHighestRow; $row++) {
                    if ($row % 2 == 1) {
                        $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB($lightGrayFill);
                    }

                    $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)
                        ->getBorders()->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->getColor()
                        ->setARGB('FFD3D3D3');

                    $cellValue = $sheet->getCell('O' . $row)->getValue();
                    if ($cellValue && $cellValue !== 'Tidak Ada' && filter_var($cellValue, FILTER_VALIDATE_URL)) {
                        $sheet->getCell('O' . $row)->setValue('Download Sertifikat');
                        $sheet->getCell('O' . $row)->getHyperlink()->setUrl($cellValue);
                        
                        $sheet->getStyle('O' . $row)
                            ->getFont()
                            ->setUnderline(true)
                            ->getColor()
                            ->setARGB('FF0563C1');
                    }
                }

                $sheet->getStyle('A3:A' . $newHighestRow)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('J3:L' . $newHighestRow)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(PageSetup::PAPERSIZE_A4)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0);

                $sheet->getPageMargins()
                    ->setLeft(0.5)
                    ->setRight(0.5)
                    ->setTop(0.75)
                    ->setBottom(0.75);

                $sheet->freezePane('A3');
                $sheet->setAutoFilter('A2:' . $highestColumn . '2');

                if ($this->password) {
                    $sheet->getProtection()->setPassword($this->password);
                    $sheet->getProtection()->setSheet(true);
                    $sheet->getProtection()->setObjects(true);
                    $sheet->getProtection()->setScenarios(true);
                }
            },
        ];
    }
}
