<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['lampiran']) && $data['lampiran']) {
            $data['lampiran_path'] = $data['lampiran']->store('lampiran', 'public');
        }

        unset($data['lampiran']);

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman list
        return $this->getResource()::getUrl('index');
    }



}
