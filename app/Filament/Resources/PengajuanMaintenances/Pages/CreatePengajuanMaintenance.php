<?php

namespace App\Filament\Resources\PengajuanMaintenances\Pages;

use App\Filament\Resources\PengajuanMaintenances\PengajuanMaintenanceResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PengajuanMaintenanceNotification;
use Illuminate\Support\Facades\Auth;

class CreatePengajuanMaintenance extends CreateRecord
{
    protected static string $resource = PengajuanMaintenanceResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
    protected function afterCreate(): void
  {
    $admins = User::query()
      ->whereIn('role', ['super-admin'])
      ->limit(1)
      ->get();

    Notification::send($admins, new PengajuanMaintenanceNotification($this->record));
  }
  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
