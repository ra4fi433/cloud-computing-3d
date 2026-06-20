<?php

namespace App\Filament\Resources\KonsepSuratResource\Pages;

use App\Filament\Resources\KonsepSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKonsepSurat extends CreateRecord
{
    protected static string $resource = KonsepSuratResource::class;

     protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status_persetujuan'] = 'menunggu_kabid';
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman list
        return $this->getResource()::getUrl('index');
    }
}
