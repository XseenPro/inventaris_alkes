<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Collection;

class PerangkatExpiredBatchNotification extends Notification
{
    /**
     * @param \Illuminate\Support\Collection $items 
     */
    public function __construct(public Collection $items) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $tz    = 'Asia/Jakarta';
        $today = now($tz)->toDateString();

        $mail = (new MailMessage)
            ->subject("Ringkasan Perangkat Expired — {$today}")
            ->greeting('Halo,')
            ->line('Berikut daftar perangkat yang baru melewati masa pakai. Harga sudah otomatis diatur menjadi Rp 0 dan Kondisi diubah ke "Expired".')
            ->line('');

        foreach ($this->items as $p) {
            $mail->line(sprintf(
                '- %s (%s) | Kategori: %s | Tahun Pengadaan: %s | Tahun Expired: %s',
                $p['nama_perangkat'] ?? '-',
                $p['nomor_inventaris'] ?? '-',
                $p['kategori'] ?? '-',
                $p['tahun_pengadaan'] ?? '-',
                $p['tahun_expired'] ?? '-',
            ));
        }

        $mail->line('')
             ->line('Silakan cek sistem inventaris bila membutuhkan tindakan lanjutan.');

        return $mail;
    }
}
