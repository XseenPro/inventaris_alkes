<?php

namespace App\Console\Commands;

use App\Models\Kalibrasi;
use App\Models\User;
use App\Notifications\KalibrasiNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendPeminjamanH7Reminder extends Command
{
    protected $signature = 'kalibrasi:reminder-h7';
    protected $description = 'Kirim email pengingat Kalibrasi Perangkat H-7';

    public function handle(): int
    {
        $todayStr = Carbon::now('Asia/Jakarta')->toDateString();

        $kalibrasiList = Kalibrasi::query()
            ->whereRaw('DATEDIFF(tanggal_kalibrasi_ulang, ?) = -7', [$todayStr])
            ->whereNull('reminder_h7_sent_at')
            ->get();

        if ($kalibrasiList->isEmpty()) {
            $this->info('Tidak ada perangkat yang perlu dikalibrasi.');
            return self::SUCCESS;
        }

        $admins = User::whereIn('role', ['admin', 'super-admin'])->get();

        if ($admins->isEmpty()) {
            $this->warn('Tidak ada user admin/super-admin untuk dikirimi email.');
            return self::SUCCESS;
        }

        Notification::send($admins, new KalibrasiNotification($kalibrasiList));

        Kalibrasi::whereKey($kalibrasiList->pluck('id'))
            ->update(['reminder_h7_sent_at' => now('Asia/Jakarta')]);

        $this->info("Pengingat H-7 terkirim untuk {$kalibrasiList->count()} perangkat.");
        return self::SUCCESS;
    }
}
