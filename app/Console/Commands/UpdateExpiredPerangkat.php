<?php

namespace App\Console\Commands;

use App\Models\Perangkat;
use App\Models\User;
use App\Models\Kondisi;
use App\Notifications\PerangkatExpiredBatchNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Throwable;

class UpdateExpiredPerangkat extends Command
{
    protected $signature   = 'perangkat:update-expired';
    protected $description = 'Zero harga & set kondisi Expired untuk perangkat yang baru expired lalu kirim satu email ringkasan (sekali sehari).';

    public function handle(): int
    {
        $tz = 'Asia/Jakarta';
        $this->info('Mulai cek perangkat expired...');

        $admins = User::query()
            ->whereIn('role', ['admin', 'super-admin'])
            ->select(['id', 'name', 'email'])
            ->get();

        if ($admins->isEmpty()) {
            $this->warn('Tidak ada user role admin / super admin ditemukan.');
        }

        $expiredKondisiId = Kondisi::firstOrCreate(['nama_kondisi' => 'Expired'])->id;

        $eligible = collect();
        $eligibleIds = [];

        Perangkat::with(['kategori:id,nama_kategori,masa_pakai_tahun'])
            ->whereNotNull('tahun_pengadaan')
            ->whereNull('expired_sent_at')
            ->select([
                'id', 'nama_perangkat', 'nomor_inventaris',
                'kategori_id', 'tahun_pengadaan', 'harga'
            ])
            ->chunkById(500, function ($rows) use (&$eligible, &$eligibleIds) {
                /** @var \App\Models\Perangkat $row */
                foreach ($rows as $row) {
                    if (!$row->kategori) continue;
                    if (!$row->isExpired()) continue;

                    $eligibleIds[] = $row->id;

                    $eligible->push([
                        'id'               => $row->id,
                        'nama_perangkat'   => $row->nama_perangkat,
                        'nomor_inventaris' => $row->nomor_inventaris,
                        'kategori'         => $row->kategori->nama_kategori ?? '-',
                        'tahun_pengadaan'  => $row->tahun_pengadaan,
                        'tahun_expired'    => $row->tahun_expired,
                    ]);
                }
            });

        if ($eligible->isEmpty()) {
            $this->info('Tidak ada perangkat expired baru.');
            return self::SUCCESS;
        }

        $this->info('Perangkat expired baru: '.count($eligibleIds));

        DB::transaction(function () use ($eligibleIds, $expiredKondisiId) {
            Perangkat::whereIn('id', $eligibleIds)->chunkById(500, function ($rows) use ($expiredKondisiId) {
                foreach ($rows as $p) {
                    $p->forceFill([
                        'harga'     => 0,
                        'kondisi_id' => $expiredKondisiId,
                    ])->save();
                }
            });
        });

        try {
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new PerangkatExpiredBatchNotification($eligible));
            }

            Perangkat::whereIn('id', $eligibleIds)->update([
                'expired_sent_at' => now($tz),
            ]);

            $this->info('Email ringkasan terkirim. Semua item ditandai expired_sent_at.');

        } catch (TransportExceptionInterface|Throwable $e) {
            $this->error('Gagal kirim email ringkasan: '.$e->getMessage());
        }

        return self::SUCCESS;
    }
}
