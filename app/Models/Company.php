<?php

namespace App\Models;

use App\Scopes\CompanyBlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function getContactInformationAttribute($value)
    {
        return json_decode($value, true);
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyBlock());
    }
}
