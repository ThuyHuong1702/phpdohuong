@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.show', ['resource' => trans('order::orders.order')]))

    <li><a href="{{ route('admin.orders.index') }}">{{ trans('order::orders.orders') }}</a></li>
    <li class="active">{{ trans('admin::resource.show', ['resource' => trans('order::orders.order')]) }}</li>
@endcomponent

@section('content')
    <div class="order-wrapper box">
        @include('order::admin.orders.partials.order_and_account_information', ['order' => $order])
        @include('order::admin.orders.partials.address_information', ['order' => $order])
        @include('order::admin.orders.partials.items_ordered', ['order' => $order])
        @include('order::admin.orders.partials.order_totals')
    </div>
@endsection


@push('globals')
    @vite([
        'modules/Order/Resources/assets/admin/sass/main.scss',
        'modules/Order/Resources/assets/admin/js/main.js',
    ])
@endpush
@push('scripts')
<script>
    document.getElementById('order-status').addEventListener('change', function () {
        const orderId = this.dataset.id;
        const newStatus = this.value;

        fetch(`/admin/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            window.location.href = "{{ route('admin.orders.index') }}";
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã có lỗi xảy ra khi cập nhật trạng thái.');
        });
    });
</script>
@endpush
