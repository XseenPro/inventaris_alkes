@php
    /** @var \App\Models\Peminjaman|null $record */
    $record = $getRecord();
    $status = $record?->status;

    $statusConfig = match ($status) {
        'Menunggu' => ['color' => 'text-slate-200', 'bg' => 'bg-slate-500/20', 'border' => 'border-slate-500/30', 'icon' => 'heroicon-m-clock'],
        'Dipinjam' => ['color' => 'text-amber-200', 'bg' => 'bg-amber-500/20', 'border' => 'border-amber-500/30', 'icon' => 'heroicon-m-arrow-right-start-on-rectangle'],
        'Dikembalikan' => ['color' => 'text-emerald-200', 'bg' => 'bg-emerald-500/20', 'border' => 'border-emerald-500/30', 'icon' => 'heroicon-m-check-circle'],
        'Terlambat' => ['color' => 'text-rose-200', 'bg' => 'bg-rose-500/20', 'border' => 'border-rose-500/30', 'icon' => 'heroicon-m-exclamation-triangle'],
        'Ditolak' => ['color' => 'text-rose-200', 'bg' => 'bg-rose-500/20', 'border' => 'border-rose-500/30', 'icon' => 'heroicon-m-x-circle'],
        default => ['color' => 'text-gray-200', 'bg' => 'bg-gray-500/20', 'border' => 'border-gray-500/30', 'icon' => 'heroicon-m-question-mark-circle'],
    };

    $title = $record?->nama_barang ?: 'Detail Peminjaman';
    $invNumber = $record?->nomor_inventaris ?? '-';
    $merk = $record?->merk ?? '-';

    $start = optional($record?->tanggal_mulai)->format('d M Y');
    $end   = optional($record?->tanggal_selesai)->format('d M Y');
    $range = ($start || $end) ? "{$start} - {$end}" : '-';
@endphp

<div class="group relative overflow-hidden rounded-3xl border border-gray-200 bg-slate-900 shadow-lg ring-1 ring-white/10 dark:border-white/5">
    
    <div class="absolute inset-0 z-0">
        <div class="absolute -right-20 -top-20 h-96 w-96 rounded-full bg-primary-500/20 blur-[100px] opacity-40"></div>
        <div class="absolute -left-20 bottom-0 h-64 w-64 rounded-full bg-blue-500/10 blur-[80px] opacity-30"></div>
        
        <svg class="absolute inset-0 h-full w-full opacity-[0.03]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-pattern" width="32" height="32" patternUnits="userSpaceOnUse">
                    <path d="M0 32V.5H32" fill="none" stroke="currentColor" stroke-width="1" class="text-white"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-pattern)" />
        </svg>
    </div>

    <div class="relative z-10 p-6 md:p-8">
        
        <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
            
            <div class="flex items-start gap-5">
                <div class="relative flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-white/10 to-white/5 ring-1 ring-white/20 backdrop-blur-sm shadow-inner">
                    <x-filament::icon
                        icon="heroicon-o-cube"
                        class="h-8 w-8 text-white/90"
                    />
                </div>

                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center rounded-md bg-white/10 px-2 py-0.5 text-xs font-medium text-white/70 ring-1 ring-inset ring-white/10">
                            Inventaris: {{ $invNumber }}
                        </span>
                        <span class="inline-flex items-center rounded-md bg-white/10 px-2 py-0.5 text-xs font-medium text-white/70 ring-1 ring-inset ring-white/10">
                            {{ $merk }}
                        </span>
                    </div>
                    
                    <h2 class="text-2xl font-bold tracking-tight text-white md:text-3xl">
                        {{ $title }}
                    </h2>
                    
                    <p class="mt-1 flex items-center gap-1.5 text-sm text-slate-400">
                        <x-filament::icon icon="heroicon-m-calendar-days" class="h-4 w-4" />
                        Periode: <span class="text-slate-200 font-medium">{{ $range }}</span>
                    </p>
                </div>
            </div>

            <div class="self-start">
                <div class="inline-flex items-center gap-2 rounded-full border px-4 py-1.5 text-sm font-semibold shadow-sm backdrop-blur-md {{ $statusConfig['bg'] }} {{ $statusConfig['border'] }} {{ $statusConfig['color'] }}">
                    <x-filament::icon :icon="$statusConfig['icon']" class="h-4 w-4" />
                    {{ $status ?? 'Draft' }}
                </div>
            </div>
        </div>

        <div class="my-8 border-t border-white/10"></div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            
            <div class="group/card rounded-xl border border-white/5 bg-white/5 p-4 transition hover:bg-white/10">
                <div class="mb-2 flex items-center gap-2 text-xs font-medium uppercase tracking-wider text-slate-400">
                    <x-filament::icon icon="heroicon-m-user" class="h-4 w-4 opacity-50" />
                    Peminjam
                </div>
                <div class="font-semibold text-white">
                    {{ $record?->pihak_kedua_nama ?? '-' }}
                </div>
                <div class="text-sm text-slate-400 truncate">
                    {{ $record?->peminjam_email ?? '-' }}
                </div>
            </div>

            <div class="group/card rounded-xl border border-white/5 bg-white/5 p-4 transition hover:bg-white/10">
                <div class="mb-2 flex items-center gap-2 text-xs font-medium uppercase tracking-wider text-slate-400">
                    <x-filament::icon icon="heroicon-m-clipboard-document-check" class="h-4 w-4 opacity-50" />
                    Kondisi Terakhir
                </div>
                <div class="font-semibold text-white">
                    {{ $record?->kondisi_terakhir ?? '-' }}
                </div>
                <div class="text-xs text-slate-500 mt-1">
                   Update: {{ optional($record?->updated_at)->diffForHumans() }}
                </div>
            </div>

            <div class="group/card rounded-xl border border-white/5 bg-white/5 p-4 transition hover:bg-white/10">
                <div class="mb-2 flex items-center gap-2 text-xs font-medium uppercase tracking-wider text-slate-400">
                    <x-filament::icon icon="heroicon-m-bell-alert" class="h-4 w-4 opacity-50" />
                    Reminder H-3
                </div>
                 @if($record?->reminder_h3_sent_at)
                    <div class="flex items-center gap-2 text-emerald-400 font-medium text-sm">
                        <x-filament::icon icon="heroicon-m-check" class="h-4 w-4" />
                        Terikirim
                    </div>
                    <div class="text-xs text-slate-500">
                        {{ $record->reminder_h3_sent_at->format('d M, H:i') }}
                    </div>
                @else
                    <div class="flex items-center gap-2 text-slate-400 text-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                        Belum dikirim
                    </div>
                @endif
            </div>

        </div>

        @if(! blank($record?->alasan_pinjam))
            <div class="mt-4 rounded-xl border border-white/5 bg-white/[0.02] p-4 text-sm leading-relaxed text-slate-300">
                <span class="mb-1 block text-xs font-bold text-slate-500 uppercase">Alasan Peminjaman:</span>
                "{{ $record->alasan_pinjam }}"
            </div>
        @endif

    </div>
</div>