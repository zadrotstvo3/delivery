<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryListRequest;
use App\Http\Requests\DeliveryStoreRequest;
use App\Http\Requests\DeliveryUpdateRequest;
use App\Http\Resources\DeliveryListResource;
use App\Http\Resources\DeliveryCreateResource;
use App\Http\Resources\DeliveryShowResource;
use App\Http\Resources\DeliveryUpdateResource;
use App\Services\DeliveryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DeliveryController extends Controller
{
    /**
     * @var DeliveryService
     */
    private $service;

    /**
     * @param DeliveryService $service
     */
    public function __construct(DeliveryService $service)
    {
        $this->service = $service;
    }

    /**
     * @param DeliveryListRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(DeliveryListRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $page = $request->input('page') ?? 1;
        $perPage = $request->input('perPage') ?? 2;

        $result = $this->service->getList($data, $page, $perPage);

        return DeliveryListResource::collection($result);
    }

    /**
     * @param DeliveryStoreRequest $request
     * @return DeliveryCreateResource
     */
    public function store(DeliveryStoreRequest $request): DeliveryCreateResource
    {
        $data = $request->validated();

        $result = $this->service->store($data);

        return new DeliveryCreateResource($result);
    }

    /**
     * @param Request $request
     * @return DeliveryShowResource
     */
    public function show(Request $request): DeliveryShowResource
    {
        $deliveryId = intval($request->route('id'));

        $result = $this->service->show($deliveryId);

        return new DeliveryShowResource($result);
    }

    /**
     * @param DeliveryUpdateRequest $request
     * @return DeliveryUpdateResource
     */
    public function update(DeliveryUpdateRequest $request): DeliveryUpdateResource
    {
        $data = $request->validated();
        $deliveryId = intval($request->route('id'));

        $result = $this->service->update($deliveryId, $data);

        return new DeliveryUpdateResource($result);
    }
}
