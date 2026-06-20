<?php

namespace App\Filament\Resources\KonsepSuratResource\Pages;

use App\Filament\Resources\KonsepSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKonsepSurats extends ListRecords
{
    protected static string $resource = KonsepSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Surat Baru')
        ];
    }
}
