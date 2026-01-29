<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;

class TestExcelRead extends Command
{
    protected $signature = 'test:excel {file}';
    protected $description = 'Test read Excel file';

    public function handle()
    {
        $file = $this->argument('file');
        $fullPath = Storage::disk('public')->path($file);

        if (!file_exists($fullPath)) {
            $this->error('File not found: ' . $fullPath);
            return 1;
        }

        $this->info('Reading file: ' . $fullPath);
        
        // Test 1: Tanpa WithHeadingRow
        $this->info("\n=== Test 1: Tanpa WithHeadingRow ===");
        $data1 = Excel::toArray(new class {}, $fullPath);
        $this->info('Total rows (with header): ' . count($data1[0]));
        $this->info('First row (headers): ' . json_encode($data1[0][0], JSON_PRETTY_PRINT));
        if (isset($data1[0][1])) {
            $this->info('Second row (data): ' . json_encode($data1[0][1], JSON_PRETTY_PRINT));
        }

        // Test 2: Dengan WithHeadingRow
        $this->info("\n=== Test 2: Dengan WithHeadingRow ===");
        $data2 = Excel::toArray(new class implements WithHeadingRow {}, $fullPath);
        $this->info('Total rows (data only): ' . count($data2[0]));
        if (!empty($data2[0])) {
            $this->info('Headers (slugified): ' . json_encode(array_keys($data2[0][0]), JSON_PRETTY_PRINT));
            $this->info('First data row: ' . json_encode($data2[0][0], JSON_PRETTY_PRINT));
        }

        return 0;
    }
}
