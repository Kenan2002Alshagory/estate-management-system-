<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class EstateBlock implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereHas('user', function (Builder $query) {
            $query->where('block', false);
        });
    }
}
