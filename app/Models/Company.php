<?php

namespace App\Models;

use App\Models\Traits\CompaniesFormula\Formula;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Company extends Model
{
    use HasFactory, Formula;

    const DEFAULT_NAMES = [
        'DHL',
        'USP'
    ];

    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class, 'company_id', 'id');
    }

    /**
     * @param float $weight
     * @return float
     */
    public function getPriceByFormulaForSpecificCompany(float $weight): float
    {
        $currentName = $this->getAttribute('name');

        if (in_array($currentName, self::DEFAULT_NAMES)) {
            $methodName = "getPriceFor$currentName";
            return call_user_func_array([$this, $methodName], [$weight]);
        }
        throw new BadRequestHttpException("The company $currentName has wrong name");
    }
}
