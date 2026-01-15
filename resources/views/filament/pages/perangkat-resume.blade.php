<x-filament-panels::page>
    {{ $this->form }}

    @php
    $fmt = fn($v) => number_format($v ?? 0, 0, ',', '.');

    $year = $this->year ?? now()->year;
    $monthFrom = $this->monthFrom;
    $monthTo = $this->monthTo;

    if ($monthFrom && $monthTo && $monthFrom > $monthTo) {
    [$monthFrom, $monthTo] = [$monthTo, $monthFrom];
    }

    if (!$year && !$monthFrom && !$monthTo) {
    $bulanTahun = mb_strtoupper(now()->locale('id')->translatedFormat('F Y'));
    }
    elseif ($year && !$monthFrom && !$monthTo) {
    $bulanTahun = (string) $year;
    }
    elseif ($year && $monthFrom && (!$monthTo || $monthTo == $monthFrom)) {
    $bulanTahun = mb_strtoupper(
    \Carbon\Carbon::createFromDate($year, $monthFrom, 1)
    ->locale('id')->translatedFormat('F Y')
    );
    }
    else {
    $start = \Carbon\Carbon::createFromDate($year, $monthFrom, 1)
    ->locale('id')->translatedFormat('F');
    $end = \Carbon\Carbon::createFromDate($year, $monthTo, 1)
    ->locale('id')->translatedFormat('F Y');

    $bulanTahun = mb_strtoupper($start . '–' . $end);
    }
    @endphp
        <div class="mt-4 flex justify-end">
        <div class="inline-flex gap-x-2">
            <x-filament::button 
                tag="a" 
                href="{{ route('export.perangkat.resume.excel', [
                    'year'       => $this->year,
                    'month_from' => $this->monthFrom,
                    'month_to'   => $this->monthTo,
                ]) }}" 
                icon="heroicon-o-document-arrow-down"
                target="_blank"
            >
                Export Excel
            </x-filament::button>

            <x-filament::button 
                tag="a" 
                href="{{ route('export.perangkat.resume.pdf', [
                    'year'       => $this->year,
                    'month_from' => $this->monthFrom,
                    'month_to'   => $this->monthTo,
                ]) }}" 
                icon="heroicon-o-document-text"
                color="primary"
                target="_blank"
            >
                Export PDF
            </x-filament::button>
        </div>
    </div>




    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
        <x-filament::card>
            <div class="text-sm text-gray-500 dark:text-gray-400">Total Perangkat ({{ $bulanTahun }})</div>
            <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $fmt($this->grandTotal['total_count']) }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Semua perangkat terdaftar</div>
        </x-filament::card>
        <x-filament::card>
            <div class="text-sm text-gray-500 dark:text-gray-400">Aktif</div>
            <div class="mt-2 text-2xl font-bold text-success-600">{{ $fmt($this->grandTotal['aktif_count']) }} unit</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Rp {{ $fmt($this->grandTotal['aktif_sum']) }}</div>
        </x-filament::card>
        <x-filament::card>
            <div class="text-sm text-gray-500 dark:text-gray-400">Rusak</div>
            <div class="mt-2 text-2xl font-bold text-danger-600">{{ $fmt($this->grandTotal['rusak_count']) }} unit</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Rp {{ $fmt($this->grandTotal['rusak_sum']) }}</div>
        </x-filament::card>
        <x-filament::card>
            <div class="text-sm text-gray-500 dark:text-gray-400">Tidak Digunakan</div>
            <div class="mt-2 text-2xl font-bold text-warning-600">{{ $fmt($this->grandTotal['tidak_digunakan_count']) }} unit</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Rp {{ $fmt($this->grandTotal['tidak_digunakan_sum']) }}</div>
        </x-filament::card>
    </div>


    <x-filament::section heading="Detail Laporan Inventaris" class="mt-6">
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">

                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr class="text-left">
                        <th scope="col" class="px-4 py-3 font-medium text-gray-950 dark:text-white">Nama Perangkat</th>
                        <th scope="col" class="px-4 py-3 font-medium text-gray-950 dark:text-white">Aktif (Unit)</th>
                        <th scope="col" class="px-4 py-3 font-medium text-gray-950 dark:text-white">Aktif (Rp)</th>
                        <th scope="col" class="px-4 py-3 font-medium text-gray-950 dark:text-white">Rusak (Unit)</th>
                        <th scope="col" class="px-4 py-3 font-medium text-gray-950 dark:text-white">Rusak (Rp)</th>
                        <th scope="col" class="px-4 py-3 font-medium text-gray-950 dark:text-white">Tidak Digunakan (Unit)</th>
                        <th scope="col" class="px-4 py-3 font-medium text-gray-950 dark:text-white">Tidak Digunakan (Rp)</th>
                        <th scope="col" class="px-4 py-3 font-medium text-gray-950 dark:text-white">Total (Unit)</th>
                        <th scope="col" class="px-4 py-3 font-medium text-gray-950 dark:text-white">Total (Rp)</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($this->rows as $row)
                    <tr class="hover:bg-green-100 dark:hover:bg-white/5">

                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-950 dark:text-white">{{ $row->nama_perangkat }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-gray-950 dark:text-white">{{ $fmt($row->aktif_count) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-gray-950 dark:text-white">Rp {{ $fmt($row->aktif_sum) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-gray-950 dark:text-white">{{ $fmt($row->rusak_count) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-gray-950 dark:text-white">Rp {{ $fmt($row->rusak_sum) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-gray-950 dark:text-white">{{ $fmt($row->tidak_digunakan_count) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-gray-950 dark:text-white">Rp {{ $fmt($row->tidak_digunakan_sum) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-right font-medium text-gray-950 dark:text-white">{{ $fmt($row->total_count) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-right font-medium text-gray-950 dark:text-white">Rp {{ $fmt($row->total_sum) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">Tidak ada data pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>

                <tfoot class="bg-gray-100 dark:bg-gray-800">
                    <tr class="font-semibold text-gray-950 dark:text-white">
                        <td class="px-4 py-3">Grand Total</td>
                        <td class="px-4 py-3 text-right">{{ $fmt($this->grandTotal['aktif_count']) }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ $fmt($this->grandTotal['aktif_sum']) }}</td>
                        <td class="px-4 py-3 text-right">{{ $fmt($this->grandTotal['rusak_count']) }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ $fmt($this->grandTotal['rusak_sum']) }}</td>
                        <td class="px-4 py-3 text-right">{{ $fmt($this->grandTotal['tidak_digunakan_count']) }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ $fmt($this->grandTotal['tidak_digunakan_sum']) }}</td>
                        <td class="px-4 py-3 text-right">{{ $fmt($this->grandTotal['total_count']) }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ $fmt($this->grandTotal['total_sum']) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </x-filament::section>

</x-filament-panels::page>