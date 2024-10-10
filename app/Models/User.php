<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Scopes\UserBlock;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable ,SoftDeletes;
    protected $guarded = [];

    public function estates()
    {
        return $this->hasMany(Estate::class);
    }

    public function privateNotifications()
    {
        return $this->hasMany(PrivateNotification::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favoriteEstates()
    {
        return $this->belongsToMany(Estate::class, 'favorite_estates', 'user_id', 'estate_id')
            ->withTimestamps();
    }

    public function forgetPasswordCodes()
    {
        return $this->hasMany(ForgetPasswordCode::class);
    }

    public function verificationCodes()
    {
        return $this->hasMany(VerificationCode::class);
    }


    public function canAccessPanel(Panel $panel): bool
    {
        return $this->type == 'admin' ;
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserBlock());
    }
}

