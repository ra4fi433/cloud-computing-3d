<?php

namespace App\Filament\Resources\SuratKeluarResource\Pages;

use App\Filament\Resources\SuratKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSuratKeluar extends CreateRecord
{
    protected static string $resource = SuratKeluarResource::class;

    protected function getCreatedNotificationMessage(): ?string
    {
        return 'Dokumen berhasil ditambahkan!';
    }

    protected function afterCreate(): void
    {
        // Override untuk menghentikan redirect ke edit
    }

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman list
        return $this->getResource()::getUrl('index');
    }
}
