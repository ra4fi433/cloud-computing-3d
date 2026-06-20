<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // protected function getCreatedNotificationRedirectUrl(): ?string
    // {
    //     return UserResource::getUrl('index'); // Redirect ke halaman index setelah create
    // }

    protected function getRedirectUrl(): string
    {
       if (auth()->user()->hasRole('superadmin')) {
        return $this->getResource()::getUrl('index');
    }
        return route('dashboard');
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['password'])) {
           $data['password'] = Hash::make($data['password']); // Hash password
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        // dd($data);
        $user = static::getModel()::create($data);


        // Jika field 'role' disediakan, assign role ke user
        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return $user;
    }
}
