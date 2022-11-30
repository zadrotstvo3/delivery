<?php

namespace App\Models\Traits\CompaniesFormula;

trait Formula
{
    /**
     * Better for calculation float we should use specific calculation package. This solution only for test
     *
     * @param float $weight
     * @return float
     */
    public function getPriceForDHL(float $weight): float
    {
        $hundredWeightPrice = 0.33;

        $roundWeight = round($weight, 0, PHP_ROUND_HALF_UP);

        $priceEUR = ($roundWeight * $hundredWeightPrice) / 100;

        $priceUSD = $priceEUR / 0.97;

        return round($priceUSD, 2);
    }

    /**
     * Better for calculation float we should use specific calculation package.This solution only for test
     *
     * @param float $weight
     * @return float
     */
    public function getPriceForUSP(float $weight): float
    {
        $priceUSD = $weight <= 4500
            ? ($weight * 2.00) / 100
            : ($weight * 3.00) / 100;

        return round($priceUSD, 2);
    }
}
