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

        $admins = User::whereIn('role', ['admin', 'super-admin'])->get();
        $sent = 0;
        foreach ($kalibrasiList as $k) {
            if ($admins->isEmpty()) {
                continue;
            }

            Notification::send($admins, new KalibrasiNotification($k));

            $k->forceFill(['reminder_h7_sent_at' => now('Asia/Jakarta')])->save();
            $sent++;
        }

        $this->info("Pengingat H-7 terkirim: {$sent}");
        return self::SUCCESS;
    }
}
