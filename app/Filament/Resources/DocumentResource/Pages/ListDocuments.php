<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
// use Filament\Tables\Actions\Action;
use Filament\Actions\Action;
// use Filament\Actions\ActionGroup;
use App\Models\Document;
use Filament\Notifications\Notification;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;    

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Surat Baru'),

            // Action::make('activateApiAll')
            //     ->label('Aktivasi Semua API')
            //     ->icon('heroicon-m-bolt')
            //     ->requiresConfirmation()
            //     ->color('warning')
            //     ->visible(fn () => auth()->user()?->hasRole('superadmin'))
            //     ->action(function () {
            //         // Contoh: Aktivasi API ke semua surat
            //         \App\Models\SuratKeluar::query()->update([
            //             'api_token' => \Str::random(60),
            //         ]);

            //         // Tampilkan notifikasi
            //         \Filament\Notifications\Notification::make()
            //             ->title('API berhasil diaktivasi.')
            //             ->success()
            //             ->send();
            //     }),
        ];
    }
}
