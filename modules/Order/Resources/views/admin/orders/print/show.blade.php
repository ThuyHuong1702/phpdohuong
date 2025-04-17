<!DOCTYPE html>
<html lang="{{ locale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trans('order::print.invoice') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['modules/Order/Resources/assets/admin/sass/print.scss'])
</head>

<body class="ltr" dir="ltr">
    <!--[if lt IE 8]>
        <p>You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a>
            to improve your experience.</p>
        <![endif]-->

    <div class="container">
        <div class="invoice-wrapper clearfix">
            <div class="row">
                <div class="invoice-header clearfix">
                    <div class="col-md-3">
                        <div class="store-name">
                            <h1>FleetCart</h1>
                        </div>
                    </div>

                    <div class="col-md-9 clearfix">
                        <div class="invoice-header-right pull-right">
                            <span class="title">{{ trans('order::print.invoice') }}</span>

                            <div class="invoice-info clearfix">
                                <div class="invoice-id">
                                    <label for="invoice-id">{{ trans('order::print.invoice_id') }}:</label>
                                    <span>#{{ $order->id }}</span>
                                </div>

                                <div class="invoice-date">
                                    <label for="invoice-date">{{ trans('order::print.date') }}:</label>
                                    <span>{{ \Carbon\Carbon::parse($order->created_at)->format('Y / m / d') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-body clearfix">
                <div class="invoice-details-wrapper">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="invoice-details">
                                <h5>{{ trans('order::print.order_details') }}</h5>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>{{ trans('order::print.email') }}:</td>
                                                <td>{{  $order->customer_email ?? 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <td>{{ trans('order::print.phone') }}:</td>
                                                <td>{{ $order->customer_phone ?? 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <td>{{ trans('order::print.shipping_method') }}:</td>
                                                <td>{{ $order->shipping_method }}</td>
                                            </tr>

                                            <tr>
                                                <td>{{ trans('order::orders.payment_method') }}</td>
                                                <td>
                                                    {{ $order->payment_method ?? '-' }}
                                                    <br>
                                                    @if($order->payment_method === 'bank_transfer')
                                                        <span style="color: #999; font-size: 13px;">
                                                            Bank Name: Lorem Ipsum. <br>
                                                            Beneficiary Name: John Doe. <br>
                                                            Account Number/IBAN: 123456789 <br>
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="invoice-address">
                                <h5>{{ trans('order::print.billing_address') }}</h5>

                               <!-- Billing Address -->
                               <span>
                                    {{ $order->billing_full_name }}
                                    <br>
                                    {{ $order->billing_address_1 }}
                                    <br>
                                    {{ $order->billing_address_2 }}
                                    <br>
                                    {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zip }}
                                    <br>
                                    {{ $order->billing_country }}
                                </span>

                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="invoice-address">
                                <h5>{{ trans('order::print.shipping_address') }}</h5>
                                <span>
                                    {{ $order->shipping_full_name }}
                                    <br>
                                    {{ $order->shipping_address_1 }}
                                    <br>
                                    {{ $order->shipping_address_2 }}
                                    <br>
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}
                                    <br>
                                    {{ $order->shipping_country }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="cart-list">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('order::print.product') }}</th>
                                        <th>{{ trans('order::print.unit_price') }}</th>
                                        <th>{{ trans('order::print.quantity') }}</th>
                                        <th>{{ trans('order::print.line_total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderProducts as $orderProduct)
                                    <tr>
                                        @foreach($order->orderProducts as $orderProduct)
                                            <td>
                                                <span>{{ $orderProduct->product->name ?? 'N/A' }}</span>

                                                @if ($orderProduct->variations->isNotEmpty())
                                                    <div class="option">
                                                        @foreach($orderProduct->variations as $variation)
                                                            <span>{{ $variation->type }}:
                                                                <span>{{ $variation->value }}</span>
                                                                @if ($variation->variation_value)
                                                                    <span> - {{ $variation->variation_value }}</span>
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach


                                        <td>{{ number_format($orderProduct->unit_price, 0, ',', '.') }}đ</td>
                                        <td>{{ $orderProduct->qty }}</td>
                                        <td>{{ number_format($orderProduct->line_total, 0, ',', '.') }}đ</td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="total pull-right">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>{{ trans('order::orders.subtotal') }}</td>
                                    <td class="text-right">{{ number_format($order->subtotal, 0, ',', '.') }}đ</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('order::orders.shipping') }}</td>
                                    <td class="text-right">{{ number_format($order->shipping_cost, 0, ',', '.') }}đ</td>
                                </tr>
                                @if($order->coupon_code)
                                <tr>
                                    <td>{{ trans('order::orders.coupon') }} (<span class="coupon-code">#{{ $order->coupon_code }}</span>)</td>
                                    <td class="text-right">–{{ number_format($order->discount, 0, ',', '.') }}đ</td>
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
    </div>

    <script type="module">
        window.print();
    </script>
</body>

</html>
