<?php

namespace App\Models;

use App\Models\Traits\Filter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory, Filterable;

    /**
     * @var string
     */
    protected $table = 'deliveries';

    /**
     * @var string[]
     */
    protected $fillable = [
        'company_id',
        'price',
        'name',
        'description',
        'weight'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'weight' => 'float',
        'price' => 'float'
    ];

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
