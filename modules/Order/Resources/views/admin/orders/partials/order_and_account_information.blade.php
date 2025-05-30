<div class="order-information-wrapper">
    <div class="order-information-buttons">
        <a href="{{ route('admin.orders.print.show', $order->id) }}" class="btn btn-default" target="_blank"
            data-toggle="tooltip" title="{{ trans('order::orders.print') }}">
            <i class="fa fa-print" aria-hidden="true"></i>
        </a>
    </div>

    <h4 class="section-title">{{ trans('order::orders.order_and_account_information') }}</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="order clearfix">
                <h5>{{ trans('order::orders.order_information') }}</h5>

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>{{ trans('order::orders.order_id') }}</td>
                                <td>{{ $order->id }}</td>
                            </tr>

                            <tr>
                                <td>{{ trans('order::orders.order_date') }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->toFormattedDateString() }}</td>
                            </tr>

                            <tr>
                                <td>{{ trans('order::orders.order_status') }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-9 col-md-10 col-sm-10">
                                            <select id="order-status" class="form-control custom-select-black" data-id="{{ $order->id }}">
                                                @foreach (trans('order::statuses') as $name => $label)
                                                    <option value="{{ $name }}" {{ $order->status === $name ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>{{ trans('order::orders.shipping_method') }}</td>
                                <td>{{ $order->shipping_method ?? '-' }}</td>
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

                            <tr>
                                <td>{{ trans('order::orders.order_note') }}</td>
                                <td>{{ $order->note ?? '-' }}</td>
                            </tr>

                            <tr>
                                <td>{{ trans('order::orders.currency') }}</td>
                                <td>{{ $order->currency ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('order::orders.currency_rate') }}</td>
                                <td>{{ $order->currency_rate ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="account-information">
                <h5>{{ trans('order::orders.account_information') }}</h5>

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>{{ trans('order::orders.customer_name') }}</td>
                                <td>{{ $order->customer_full_name }}</td>
                            </tr>

                            <tr>
                                <td>{{ trans('order::orders.customer_email') }}</td>
                                <td>{{ $order->customer_email }}</td>
                            </tr>

                            <tr>
                                <td>{{ trans('order::orders.customer_phone') }}</td>
                                <td>{{ $order->customer_phone }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
