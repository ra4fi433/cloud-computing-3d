<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

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
