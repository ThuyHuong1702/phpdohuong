@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('order::orders.orders'))

    <li class="active">{{ trans('order::orders.orders') }}</li>
@endcomponent

@section('content')
    <div class="box box-primary">
        <div class="box-body index-table" id="orders-table">
            @component('admin::components.table', ['showDelete' => $showDelete])
            @slot('thead')
                @include('order::admin.orders.partials.thead', ['name' => 'products-index'])
            @endslot

                @slot('tbody')
                @if (!empty($orders))
                @foreach ($orders as $order)
                    <tr class="clickable-row">
                        <td class="dt-type-numeric">{{ $order->id }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->customer_full_name }}</a>
                        </td>
                        <td>{{ $order->customer_email }}</td>
                        <td><span class="badge badge-info">{{ ucfirst($order->status) }}</span></td>
                        <td class="dt-type-numeric">{{ number_format($order->total) }}đ</td>
                        <td class="sorting_1">
                            <span data-toggle="tooltip" title="{{ $order->created_at->format('M d, Y') }}">
                                {{ $order->created_at->diffForHumans() }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="8" class="dt-empty">No data available in table</td>
                    </tr>
                @endif
            @endslot
            @slot('tResult')
                {{ request()->get('page', 1) * $perPage - $perPage + 1 }} - {{ request()->get('page', 1) * $perPage }} of
                {{ $totalOrders }} results entries
            @endslot

            @slot('tPagination')
                {!! $orders->appends(request()->input())->links('admin::pagination.simple') !!}
            @endslot
            @endcomponent
        </div>
    </div>
@endsection
@if (session()->has('exit_flash'))
    @push('notifications')
        <div class="alert alert-success fade in alert-dismissible clearfix">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM11.25 8C11.25 7.59 11.59 7.25 12 7.25C12.41 7.25 12.75 7.59 12.75 8V13C12.75 13.41 12.41 13.75 12 13.75C11.59 13.75 11.25 13.41 11.25 13V8ZM12.92 16.38C12.87 16.51 12.8 16.61 12.71 16.71C12.61 16.8 12.5 16.87 12.38 16.92C12.26 16.97 12.13 17 12 17C11.87 17 11.74 16.97 11.62 16.92C11.5 16.87 11.39 16.8 11.29 16.71C11.2 16.61 11.13 16.51 11.08 16.38C11.03 16.26 11 16.13 11 16C11 15.87 11.03 15.74 11.08 15.62C11.13 15.5 11.2 15.39 11.29 15.29C11.39 15.2 11.5 15.13 11.62 15.08C11.86 14.98 12.14 14.98 12.38 15.08C12.5 15.13 12.61 15.2 12.71 15.29C12.8 15.39 12.87 15.5 12.92 15.62C12.97 15.74 13 15.87 13 16C13 16.13 12.97 16.26 12.92 16.38Z" fill="#555555"/>
            </svg>

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M5.00082 14.9995L14.9999 5.00041" stroke="#555555" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.9999 14.9996L5.00082 5.00049" stroke="#555555" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <span class="alert-text">{{ session('exit_flash') }}</span>
        </div>
    @endpush
@endif
@push('scripts')
<script type="module">
    const tableBody = $('tbody');
    const tableRows = tableBody.find('tr');
    const processingPanel = $('#DataTables_Table_0_processing');
    const noResultsRow = createNoResultsRow();

    function createNoResultsRow() {
        const row = $('<tr>').addClass('no-results').css('display', 'none');
        const cell = $('<td>').attr('colspan', tableRows.first().children().length)
            .addClass('text-center text-muted py-3')
            .text('Không tìm thấy đơn hàng phù hợp');
        row.append(cell);
        tableRows.first().closest('tbody').append(row);
        return row;
    }

    const searchInput = $('.dt-search input[type="search"]');

    if (searchInput.length) {
        searchInput.on("keypress", function(e) {
            if (e.which === 13) {
                processingPanel.css('display', 'block');

                const query = $(this).val().toLowerCase().trim();
                let visibleRowCount = 0;

                tableRows.each(function() {
                    const row = $(this);

                    const idCell = row.find('td:nth-child(1)');
                    const nameCell = row.find('td:nth-child(2)');
                    const emailCell = row.find('td:nth-child(3)');
                    const statusCell = row.find('td:nth-child(4)');
                    const totalCell = row.find('td:nth-child(5)');
                    const createdAtCell = row.find('td:nth-child(6)');

                    const matches =
                        containsSearchTerm(idCell.text(), query) ||
                        containsSearchTerm(nameCell.text(), query) ||
                        containsSearchTerm(emailCell.text(), query) ||
                        containsSearchTerm(statusCell.text(), query) ||
                        containsSearchTerm(totalCell.text(), query) ||
                        containsSearchTerm(createdAtCell.text(), query);

                    if (matches) {
                        row.show();
                        visibleRowCount++;
                    } else {
                        row.hide();
                    }
                });

                noResultsRow.css('display', visibleRowCount > 0 ? 'none' : '');
                setTimeout(() => processingPanel.css('display', 'none'), 300);
            }
        });

        searchInput.on('search', function() {
            if ($(this).val() === '') {
                processingPanel.css('display', 'block');
                tableRows.show();
                noResultsRow.css('display', 'none');
                setTimeout(() => processingPanel.css('display', 'none'), 300);
            }
        });

        function containsSearchTerm(text, query) {
            if (!text) return false;
            const normalizedText = text.toLowerCase().trim();
            return normalizedText.includes(query) ||
                normalizedText.split(/\s+/).some(word => word.startsWith(query));
        }
    }
</script>
@endpush
