<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var array
     */
    private $queryParams;

    /**
     * @param array $queryParams
     */
    public function __construct(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }

    /**
     * @return array
     */
    protected abstract function callbackNames(): array;

    /**
     * @param Builder $builder
     * @return void
     */
    public function execute(Builder $builder): void
    {
        foreach ($this->queryParams as $key => $value) {
            if (in_array($key, $this->callbackNames())) {
                call_user_func_array([$this, $key], [$builder, $value]);
            } else {
                throw new BadRequestHttpException("Filter  by $key doesn`t exists");
            }
        }
    }
}
