<div class="order-totals-wrapper">
    <div class="row">
        <div class="order-totals pull-right">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ trans('order::orders.subtotal') }}</td>
                            <td class="text-right">{{ number_format($order->sub_total, 0, ',', '.') }}đ</td>
                        </tr>
                        <tr>
                            <td>{{ trans('order::orders.shipping') }}</td>
                            <td class="text-right">{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}đ</td>
                        </tr>
                        @if (!empty($order->coupon_code))
                        <tr>
                            <td>{{ trans('order::orders.coupon') }} (<span class="coupon-code">#{{ $order->coupon_code }}</span>)</td>
                            <td class="text-right">–{{ number_format($order->discount ?? 0, 0, ',', '.') }}đ</td>
                        </tr>
                        @endif
                        <tr>
                            <td>{{ trans('order::orders.total') }}</td>
                            <td class="text-right">{{ number_format($order->total, 0, ',', '.') }}đ</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
