<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use Filament\Notifications\Notification;
use Filament\Forms\Components\CheckboxList; 
use App\Models\Document;
use App\Models\Bidang;
use Filament\Forms\Components\FileUpload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Http\Controllers\TelegramController;
use Illuminate\Database\Eloquent\Model;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Surat Masuk';

    protected static ?string $modelLabel = 'Surat Masuk';

    protected static ?string $pluralModelLabel = 'Surat Masuk';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
    // ==========================> Input form untuk dokumen
                Forms\Components\TextInput::make('no_surat')->required()->maxLength(255),
                Forms\Components\TextInput::make('instansi_pengirim')->required()->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_surat')->required(),
                Forms\Components\DatePicker::make('tanggal_diterima')->required(),
                Forms\Components\DatePicker::make('tanggal_kegiatan')->required(),
                Forms\Components\TextInput::make('perihal')->required()->maxLength(255),
                Forms\Components\TextInput::make('waktu_kegiatan')
                    ->type('time')
                    ->required(),
                Forms\Components\TextInput::make('tempat_kegiatan')->required()->maxLength(255),
                FileUpload::make('lampiran')
                    ->disk('public')
                    ->directory('documents')
                    ->label('lampiran')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(2048),
                Forms\Components\Textarea::make('keterangan')->columnSpanFull(),
                Forms\Components\CheckboxList::make('bidangs') // <--- Gunakan NAMA RELASI 'bidangs'
                    ->label('Disposisi ke Bidang') // Label yang sesuai
                    ->relationship(
                        'bidangs', 
                        'nama_bidang',
                    function (Builder $query) {
                            return $query->orderBy('id');
                        } // Urutkan berdasarkan ID
                    ) 
                    ->columns(2) 
                    ->required()
                    ->bulkToggleable(), // Memungkinkan memilih/tidak memilih semua opsi sekaligus
    // ==========================> Input form untuk dokumen
            ]);
    }

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return auth()->user()?->hasRole(['admin', 'superadmin']);
    // }


    public static function table(Table $table): Table
        {
            return $table
                ->columns([
    // ==========================> Kolom untuk menampilkan daftar dokumen
                    Tables\Columns\TextColumn::make('id')
                        ->label('ID')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->sortable(),

                    Tables\Columns\TextColumn::make('no_surat')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('tanggal_surat')
                        ->date()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('tanggal_diterima')
                        ->date()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('tanggal_kegiatan')
                        ->date()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('waktu_kegiatan'),
                    Tables\Columns\TextColumn::make('instansi_pengirim')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('tempat_kegiatan')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('perihal')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('lampiran_path')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('disposisi')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\IconColumn::make('notifikasi_terkirim')
                        ->label('Notifikasi')
                        ->boolean() // otomatis jadi centang atau silang
                        ->trueIcon('heroicon-o-check-circle')
                        ->falseIcon('heroicon-o-x-circle')
                        ->trueColor('success')
                        ->falseColor('danger'),
    // ==========================> Kolom untuk menampilkan daftar dokumen
        ])
                ->filters([
                    //
        ])
        // ==========================> Pengaturan tabel
                ->actions([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation()
                        ->label('Hapus') 
                        ->before(function ($record) {
                            logger('Menghapus dokumen ID: ' . $record->id);
                        }),
                    Action::make('downloadLampiran')
                        ->label('Unduh Lampiran')
                        ->icon('heroicon-o-download')
                        ->url(fn (Document $record) => $record->lampiran_path ? asset('storage/' . $record->lampiran_path) : null)
                        ->openUrlInNewTab(true)
                        ->requiresConfirmation()
                        ->visible(fn (Document $record) => !empty($record->lampiran_path)), 

                    Action::make('aktivasiApi')
                        ->label('push Notifikasi')
                        ->icon('heroicon-m-bolt')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn ($record) => auth()->user()?->hasRole('superadmin'))
                        ->action(function (Action $action, $record) {
                            app(TelegramController::class)->sendMessageToday();

                            logger('Before update: ' . $record->notifikasi_terkirim);

                            $record->update(['notifikasi_terkirim' => true]);

                            logger('After update: ' . $record->fresh()->notifikasi_terkirim);

                            Notification::make()
                                ->title('Notifikasi berhasil dikirim.')
                                ->success()
                                ->send();
                        }),
    // ==========================> Pengaturan tabel
        ])

                    

                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
        ]);
        }


    public static function getEloquentQuery(): Builder
        {
            return parent::getEloquentQuery()->withoutGlobalScopes([
                SoftDeletingScope::class,
        ]);
        }
    
    // Hanya role tertentu yang boleh Create
    public static function canCreate(): bool
        {
            return auth()->user()?->hasAnyRole('superadmin', 'user');
        }

    // Hanya role tertentu yang boleh Edit
    public static function canUpdate(Model $record): bool
        {
           return auth()->user()?->hasAnyRole('superadmin', 'user');
        }

    // Hanya role tertentu yang boleh Delete
    public static function canDelete(Model $record): bool
        {
            return auth()->user()?->hasRole('superadmin');
        }


    //  public static function canDelete($record): bool
    // {
    //     return auth()->user()?->hasRole('superadmin, user');
    // }

    public static function getRelations(): array
        {
            return [
                //
            ];
        }

    public static function getPages(): array
        {
            return [
                'index' => Pages\ListDocuments::route('/'),
                'create' => Pages\CreateDocument::route('/create'),
                'edit' => Pages\EditDocument::route('/{record}/edit'),
            ];
        }
}
