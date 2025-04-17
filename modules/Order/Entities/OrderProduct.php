<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductVariant;
use Modules\Order\Entities\OrderProductVariation;

class OrderProduct extends Model
{
    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'unit_price',
        'qty',
        'line_total',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function variations()
    {
        return $this->hasMany(OrderProductVariation::class);
    }

    protected static function booted()
    {
        static::saving(function ($orderProduct) {
            $orderProduct->line_total = $orderProduct->unit_price * $orderProduct->qty;
        });
    }
}
