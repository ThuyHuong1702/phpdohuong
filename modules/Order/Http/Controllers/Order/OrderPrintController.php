<?php

namespace Modules\Order\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Order\Entities\Order;

class OrderPrintController extends Controller
{
    protected $model = Order::class;

    protected $viewPath = 'order::admin.orders.print';

    public function show(Order $order)
    {
        $order->load(['customer', 'orderProducts.product', 'orderProducts.variations']);
        return view("{$this->viewPath}.show", compact('order'));
    }

}
