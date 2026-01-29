<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\AlkesImporter;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class TestAlkesExcel extends Command
{
    protected $signature = 'test:alkes-excel {file}';
    protected $description = 'Test import Alkes Excel file';

    public function handle()
    {
        $file = $this->argument('file');
        
        // Cek apakah file ada
        if (!Storage::disk('public')->exists($file)) {
            $this->error("File tidak ditemukan: {$file}");
            return 1;
        }

        $fullPath = Storage::disk('public')->path($file);
        $this->info("Reading file: {$fullPath}");
        $this->newLine();

        try {
            $startTime = microtime(true);
            
            $importer = new AlkesImporter();
            Excel::import($importer, $fullPath);
            
            $duration = round(microtime(true) - $startTime, 2);
            
            $this->info("✓ Import berhasil dalam {$duration} detik!");
            return 0;
            
        } catch (\Throwable $e) {
            $this->error('✗ Import gagal!');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->line('File: ' . $e->getFile());
            $this->line('Line: ' . $e->getLine());
            
            if ($this->option('verbose')) {
                $this->newLine();
                $this->error($e->getTraceAsString());
            }
            
            return 1;
        }
    }
}
