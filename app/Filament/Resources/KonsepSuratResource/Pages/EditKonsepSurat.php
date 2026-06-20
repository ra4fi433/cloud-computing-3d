<?php

namespace App\Filament\Resources\KonsepSuratResource\Pages;

use App\Filament\Resources\KonsepSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKonsepSurat extends EditRecord
{
    protected static string $resource = KonsepSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman list
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika surat sebelumnya berstatus 'draft', maka ubah ke 'menunggu_kabid'
        if ($this->record->status_persetujuan === 'draft') {
            $data['status_persetujuan'] = 'menunggu_kabid';
        }

        return $data;
    }

}
