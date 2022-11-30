<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class DeliveryFilter extends AbstractFilter
{

    /**
     * @return string[]
     */
    protected function callbackNames(): array
    {
        return [
            'name',
            'description',
            'weight',
            'price',
            'companyId'
        ];
    }

    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function name(Builder $builder, string $value): Builder
    {
        return $builder->where('name', 'like', "%$value%");
    }

    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function description(Builder $builder, string $value): Builder
    {
        return $builder->where('description', 'like', "%$value%");
    }

    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function weight(Builder $builder, string $value): Builder
    {
        return $builder->where('weight', floatval($value));
    }

    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function companyId(Builder $builder, string $value): Builder
    {
        return $builder->where('company_id', intval($value));
    }

    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function price(Builder $builder, string $value): Builder
    {
        return $builder->where('price', floatval($value));
    }

}
