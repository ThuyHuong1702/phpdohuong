<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Modules\Order\Entities\OrderProduct;

class Order extends Model
{
    use SoftDeletes;

    // Constants for order statuses
    const CANCELED = 'canceled';
    const COMPLETED = 'completed';
    const ON_HOLD = 'on_hold';
    const PENDING = 'pending';
    const PENDING_PAYMENT = 'pending_payment';
    const PROCESSING = 'processing';
    const REFUNDED = 'refunded';

    protected $fillable = [
        'customer_id',
        'customer_email',
        'customer_phone',
        'customer_first_name',
        'customer_last_name',
        'billing_first_name',
        'billing_last_name',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'sub_total',
        'shipping_method',
        'shipping_cost',
        'coupon_id',
        'discount',
        'total',
        'payment_method',
        'currency',
        'currency_rate',
        'locale',
        'status',
        'note',
    ];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCustomerFullNameAttribute(): string
    {
        return trim($this->customer_first_name . ' ' . $this->customer_last_name);
    }

    public function getBillingFullNameAttribute(): string
    {
        return trim($this->billing_first_name . ' ' . $this->billing_last_name);
    }

    public function getShippingFullNameAttribute(): string
    {
        return trim($this->shipping_first_name . ' ' . $this->shipping_last_name);
    }

    protected static function booted()
    {
        static::saving(function ($order) {
            $order->sub_total = $order->orderProducts()->sum('line_total');
            $order->total = $order->sub_total - $order->shipping_cost - ($order->discount * $order->sub_total);
        });
    }
}
