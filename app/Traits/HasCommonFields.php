<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasCommonFields
{
    protected static function bootHasCommonFields()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $tableName = $builder->getModel()->getTable();
            $builder->orderBy($tableName . '.ord', 'asc')
                ->orderBy($tableName . '.created_at', 'desc');
        });
    }

    public function scopeWithoutDefaultOrder($query)
    {
        return $query->withoutGlobalScope('order');
    }
}
