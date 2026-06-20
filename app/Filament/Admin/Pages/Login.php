<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Auth;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $this->validate();

        if (! Auth::attempt([
            'name' => $this->form->getState()['name'],
            'password' => $this->form->getState()['password'],
        ], $this->form->getState()['remember'])) {
            $this->addError('name', __('filament-panels::pages/auth/login.messages.failed'));
            return null;
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('USERNAME BUKAN EMAIL') // <--- label pembeda
                ->placeholder('Masukkan username') // <--- juga bisa
                ->required()
                ->autofocus()
                ->autocomplete('username'),

            TextInput::make('password')
                ->label('Kata Sandi')
                ->password()
                ->required()
                ->autocomplete('current-password'),
        ];
    }


    // protected function getFormSchema(): array
    // {
    //     return [
    //         TextInput::make('name')
    //             ->label('Username')
    //             ->required()
    //             ->autofocus()
    //             ->autocomplete('username'),

    //         TextInput::make('password')
    //             ->label(__('filament-panels::pages/auth/login.form.password.label'))
    //             ->password()
    //             ->required()
    //             ->autocomplete('current-password'),
    //     ];
    // }
}
