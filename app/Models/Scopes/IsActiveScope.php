<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IsActiveScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    // (Builder $builder, Model $model), builder query, model yg menggunakannya
    public function apply(Builder $builder, Model $model): void
    {
        // tambah is_active true
        $builder->where('is_active', '=', true);
    }
}
