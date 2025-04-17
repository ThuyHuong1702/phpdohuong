<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProductVariation extends Model
{
    use HasFactory;

    protected $table = 'order_product_variations';

    protected $fillable = [
        'order_product_id',
        'variation_id',
        'type',
        'value',
    ];

    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }
}
