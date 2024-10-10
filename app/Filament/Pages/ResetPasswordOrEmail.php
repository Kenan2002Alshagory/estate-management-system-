<?php
namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
class ResetPasswordOrEmail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static string $view = 'filament.pages.reset-password-or-email';

    public $email;
    public $password;


    public static function getNavigationLabel(): string
    {
        return __('ResetPasswordOrEmail');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Setting');
    }

    public static function getNavigationSort(): ?int
    {
        return 10 ;
    }

    public function mount()
    {
        $this->email = Auth::user()->email;
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('email')
                ->label(__('Email'))
                ->email()
                ->required(),
            Forms\Components\TextInput::make('password')
                ->label(__('New Password'))
                ->password()
                ->nullable(),
        ];
    }

    public function submit()
    {
        $user = Auth::user();

        if ($this->email) {
            $user->email = $this->email;
        }

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        Notification::make()
            ->title('Profile updated successfully.')
            ->success()
            ->send();

    }
}
