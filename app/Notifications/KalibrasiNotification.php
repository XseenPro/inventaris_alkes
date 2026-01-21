<?php

namespace App\Notifications;

use App\Models\Kalibrasi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class KalibrasiNotification extends Notification
{
    use Queueable;

    /** @var \Illuminate\Support\Collection<int,Kalibrasi> */
    public function __construct(public Collection $items) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('📅 Daftar Perangkat Belum Kalibrasi')
            ->greeting('Hallo Petugas Kalibrasi')
            ->line('Berikut daftar perangkat yang perlu segera dikalibrasi:');

        foreach ($this->items as $p) {
            $perangkatInv  = $p->perangkats?->nomor_inventaris ?? 'None';
            $perangkatSeri = $p->perangkats?->nomor_seri ?? 'None';
            $perangkatName = $p->perangkats?->nama_perangkat ?? 'None';
            $lokasiName    = $p->lokasi?->nama_lokasi ?? 'Tidak diketahui';

            $mail->line("- {$perangkatInv} | {$perangkatName} | No Seri: {$perangkatSeri} | Lokasi: {$lokasiName} | Tgl kalibrasi terakhir: {$p->tanggal_kalibrasi}");
        }

        return $mail->line('Silakan dapat ditindaklanjuti.');
    }
}

