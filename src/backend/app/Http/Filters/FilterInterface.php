<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
     * @param Builder $builder
     *
     * @return mixed
     */
    public function apply(Builder $builder);
}
