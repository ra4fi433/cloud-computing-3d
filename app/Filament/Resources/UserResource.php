<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Bidang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Filament\Notifications\Notification;
// use App\Filament\Resources\UserResource\Pages\ViewUser;


// ===================> UserResource
// manajement resource untuk User oleh superadmin
class UserResource extends Resource
{
    protected static ?string $model = User::class; // Model yang digunakan

    protected static ?string $navigationIcon = 'heroicon-o-users'; // Ikon untuk navigasi

    protected static ?string $navigationGroup = 'Manajemen User'; // Grup navigasi untuk mengelompokkan resource ini

    public static function form(Form $form): Form
    {
        $bidangOptions = Bidang::orderBy('id')->pluck('nama_bidang', 'id')->toArray();
        return $form->schema([
            // ==========================> Input nama akun
            Forms\Components\TextInput::make('name')
                ->label('Nama Akun')
                ->required()
                ->unique(ignoreRecord: true), // input nama akun harus unik
            // ==========================> Input nama akun

            // ==========================> Input email akun
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true), // input email harus unik
            // ==========================> Input email akun
                
            // ==========================> Pilihan bidang untuk user
            Forms\Components\Radio::make('bidang_id')
                ->label('Bidang') 
                ->options($bidangOptions) // <--- opsi yang sudah diambil dari DB
                ->required()  
                ->inline(), 
            // ==========================> Pilihan bidang untuk user

            // ==========================> Input default password untuk user baru
            Forms\Components\TextInput::make('password') 
                ->password()
                ->label('Password')
                ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                ->dehydrated(fn ($state) => filled($state))
                ->autocomplete('new-password'), 
            // ==========================> Input password untuk user baru

            // ==========================> Pilihan role untuk user
            Forms\Components\Radio::make('role')
            ->label('Role')
            ->options(fn () => Role::pluck('name', 'name'))
            ->required(fn ($livewire) => !$livewire->record || !$livewire->record->hasRole('superadmin'))
            ->default(fn ($record) => $record?->roles->pluck('name')->first())
            ->afterStateHydrated(function ($component, $state) {
                $component->state($state);
            })
            ->dehydrated(fn ($state, $livewire) => !$livewire->getRecord() || !$livewire->getRecord()->hasRole('superadmin'))
            ->visible(fn ($livewire) => !$livewire->getRecord() || !$livewire->getRecord()->hasRole('superadmin'))
            ->columns(2), // agar lebih rapi tampilannya
            // ==========================> Pilihan role untuk user

        ]);
    }

    public static function table(Table $table): Table
    {
        // ==========================> Tabel untuk menampilkan daftar user
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama'),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('bidang.nama_bidang') // Mengakses nama_bidang dari relasi 'bidang'
            ->label('Bidang Tujuan') // Ubah label agar lebih jelas
            ->sortable()
            ->searchable(),
            Tables\Columns\TextColumn::make('roles.name')->label('Role'),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d-m-Y'),
        ])
        // ==========================> Tabel untuk menampilkan daftar user

        // ==========================> Pengaturan tabel
        ->actions([
            Tables\Actions\Action::make('someAction')
                // ✅ Ini adalah kode yang benar. Gunakan $record sebagai parameter.
                ->action(function ($record) { 
                    // Sekarang kamu bisa mengakses properti model dengan benar.
                    $record->update(['is_verified' => true]); 

                    Notification::make()->success()->title('User ' . $record->name . ' berhasil diverifikasi.')->send();
                }),
            // Tables\Actions\ViewAction::make(),
            // Tables\Actions\ViewAction::make()
            //     ->action(function () {
            //         // Ini akan menyebabkan error karena halaman list tidak memiliki $this->record
            //         $this->record->someMethod();
            //     }),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
        // ==========================> Pengaturan tabel
    }

    // ==========================> Pengaturan query untuk tabel
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    // ==========================> Pengaturan query untuk tabel

    // Handle after save to assign role
    public static function afterSave(User $record, array $data): void
    {
        if (!empty($data['role'])) {
            $record->syncRoles([$data['role']]);
        }
    }
    // Handle after delete to remove role

    public static function getEloquentQuery(): Builder
    {
    return parent::getEloquentQuery()
        ->select(['users.*']) // pastikan ambil semua kolom dari tabel users
        ->with('roles'); // eager-load relasi role
    }

    // hanya superadmin yang bisa akses
    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->hasRole('superadmin');
    }

    public static function canDelete($record): bool
    {
        return true;
        // return auth()->user()?->hasRole('superadmin, user');
    }

}
