<?php

namespace App\Notifications;

use App\Models\kalibrasi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KalibrasiNotification extends Notification
{
    use Queueable;

    public function __construct(public Kalibrasi $p) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $perangkatInv = $this->p->perangkats?->nomor_inventaris?? 'None';
        $perangkatSeri = $this->p->perangkats?->nomor_seri?? 'None';
        $perangkatName = $this->p->perangkats?->nama_perangkat?? 'None';
        $lokasiName = $this->p->lokasi?->nama_lokasi?? 'Pengguna';

        return (new MailMessage)
            ->subject('📅 Pengingat Belum Kalibrasi: ' . $perangkatName)
            ->greeting('Hallo Petugas Kalibrasi')
            ->line('No Inventaris Perangkat' .$perangkatInv)
            ->line('Nama Perangkat' . $perangkatName)
            ->line('No Seri Perangkat' . $perangkatSeri)
            ->line('Lokasi' . $lokasiName)
            ->line("Tanggal Kalibrasi Terakhir {$this->p->tanggal_kalibrasi}");
    }
}
