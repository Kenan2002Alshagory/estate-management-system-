<?php

namespace App\Models;

use App\Scopes\EstateBlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'services' => 'array',
        'filters' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(FavoriteEstate::class);
    }

    public function usersWhoFavorited()
    {
        return $this->belongsToMany(User::class, 'favorite_estates', 'estate_id', 'user_id')
                    ->withTimestamps();
    }

    protected static function booted()
    {
        static::addGlobalScope(new EstateBlock());
    }
}
