<?php

namespace App\Filters\Shared;

use Illuminate\Database\Eloquent\Builder;

class SearchByFilter
{
    public function handle(Builder $query, $value)
    {
        if (json_validate($value)) {
            $filter = json_decode($value, true);
            if(!array_key_exists('field', $filter) or !array_key_exists('value', $filter)) return $query;
            return $query->where($filter['field'], 'LIKE', '%' . $filter['value'] . '%');
        }
        return $query;
    }
}