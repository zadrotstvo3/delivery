<?php

namespace App\Console\Commands;

use App\Models\Delivery;
use App\Services\DeliveryService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DeliveryListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delivery:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump list of all deliveries';

    /**
     * @var DeliveryService
     */
    private DeliveryService $service;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Dump list of all deliveries with company
     *
     * @return void
     */
    public function handle(): void
    {
        dump(Delivery::with('company')->get()->toArray());
    }
}
