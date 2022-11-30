<?php

namespace App\Services;

use App\Http\Filters\DeliveryFilter;
use App\Models\Company;
use App\Models\Delivery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DeliveryService
{
    /**
     * @var Delivery
     */
    private $model;

    /**
     * @param Delivery $model
     */
    public function __construct(Delivery $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $queryParams
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getList(array $queryParams, int $page, int $perPage): LengthAwarePaginator
    {
        $filterInstance = $this->defineFilter($queryParams);

        return $this->model->filter($filterInstance)->with('company')->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @param array $data
     * @return Delivery
     */
    public function store(array $data): Delivery
    {
        $company = Company::findOrFail($data['company_id']);

        $price = $company->getPriceByFormulaForSpecificCompany($data['weight']);

        $data['price'] = $price;

        return $company->deliveries()->create($data);
    }

    /**
     * @param int $deliveryId
     * @return Builder|Builder[]|Collection|Model
     */
    public function show(int $deliveryId)
    {
        return $this->model->with('company')->findOrFail($deliveryId);
    }

    /**
     * @param int $deliveryId
     * @param array $data
     * @return Delivery
     */
    public function update(int $deliveryId, array $data): Delivery
    {
        $delivery = $this->model->findOrFail($deliveryId);
        $weight = $data['weight'];
        $companyID = $data['company_id'];

        if ($companyID === $delivery->company_id && $weight != $delivery->weight) {
            /**
             * in case if only company was changed
             */
            $newPrice = $this->calculatePriceForUpdateAction($delivery->company, $weight);
            $data['price'] = $newPrice;
        } elseif ($companyID != $delivery->company_id) {
            /**
             * in case if company and weight changed
             */
            $company = Company::findOrFail($companyID);
            $newPrice = $this->calculatePriceForUpdateAction($company, $weight);
            $data['price'] = $newPrice;
        }

        $delivery->update($data);

        return $delivery->refresh();
    }

    /**
     * @param Company $company
     * @param float $weight
     * @return float
     */
    public function calculatePriceForUpdateAction(Company $company, float $weight): float
    {
        return $company->getPriceByFormulaForSpecificCompany($weight);
    }

    /**
     * @param array $queryParams
     * @return DeliveryFilter
     */
    protected function defineFilter(array $queryParams): DeliveryFilter
    {
        return new DeliveryFilter($queryParams);
    }
}
