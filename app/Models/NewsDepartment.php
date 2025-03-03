<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsDepartment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
