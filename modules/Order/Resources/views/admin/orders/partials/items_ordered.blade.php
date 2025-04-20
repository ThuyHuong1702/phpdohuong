<div class="items-ordered-wrapper">
    <h4 class="section-title">{{ trans('order::orders.items_ordered') }}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="items-ordered">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('order::orders.product') }}</th>
                                <th>{{ trans('order::orders.unit_price') }}</th>
                                <th>{{ trans('order::orders.quantity') }}</th>
                                <th>{{ trans('order::orders.line_total') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->orderProducts as $orderProduct)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $orderProduct->product_id) }}">
                                            {{ $orderProduct->product->name }}
                                        </a>
                                        <br>

                                        @if ($orderProduct->variations && $orderProduct->variations->isNotEmpty())
                                            @foreach ($orderProduct->variations as $variation)
                                                <span>{{ ucfirst($variation->type) }}: <span>{{ $variation->value }}</span></span><br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ number_format($orderProduct->unit_price, 0, ',', '.') }}đ</td>
                                    <td>{{ $orderProduct->qty }}</td>
                                    <td>{{ number_format($orderProduct->unit_price * $orderProduct->qty, 0, ',', '.') }}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
