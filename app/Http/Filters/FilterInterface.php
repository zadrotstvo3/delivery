<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
     * @param Builder $builder
     * @return void
     */
    public function execute(Builder $builder): void;
}
