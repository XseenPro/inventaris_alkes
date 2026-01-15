<?php

namespace App\Notifications;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class PeminjamanApproved extends Notification
{
  use Queueable;
  public function __construct(public Peminjaman $p) {}
  public function via($notifiable): array
  {
    return ['mail'];
  }

  public function toMail($notifiable): MailMessage
  {
    return (new MailMessage)
      ->subject('✅ Pengajuan Peminjaman Disetujui')
      ->greeting("Halo {$this->p->pihak_kedua_nama}")
      ->line("Pengajuan untuk {$this->p->nama_barang} disetujui. Status: Dipinjam.")
      ->line("Silakan mengambil barang sesuai prosedur.");
  }

  // public function toTelegram($notifiable): TelegramMessage
  // {
  //   $chatId = config('services.telegram_default_chat_id');
  //   $start = optional($this->p->tanggal_mulai)->format('d M Y');
  //   $end   = optional($this->p->tanggal_selesai)->format('d M Y');

  //   return TelegramMessage::create()
  //     ->to($chatId)
  //     ->content(
  //       "*Peminjaman Disetujui*\n\n" .
  //         "Perangkat : *{$this->p->nama_barang}*\n" .
  //         "Peminjam  : {$this->p->pihak_kedua_nama}\n" .
  //         "Periode   : {$start} → {$end}\n" .
  //         "Status    : *Dipinjam*"
  //     )
  //     ->options(['parse_mode' => 'Markdown']);
  // }
}
