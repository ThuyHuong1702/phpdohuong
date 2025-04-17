@extends('admin::layout')
 
@component('admin::components.page.header')
    @slot('title', trans('variation::variations.variations'))
 
    <li class="active">{{ trans('variation::variations.variations') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'variations')
    @slot('name', trans('variation::variations.variation'))
 
    @slot('thead')
        @include('variation::admin.variations.partials.thead', ['name' => 'variations-index'])
        
    @endslot
 
    @slot('tbody')
    @if (!empty($variations))
        @foreach ($variations as $variation)
            <tr class="variation-row" data-id="{{ $variation->id }}">
                <td>
                    <div class="checkbox">
                        <input type="checkbox" class="select-row" name="ids[]" id="variation-{{ $variation->id }}"
                            value="{{ $variation->id }}">
                        <label for="variation-{{ $variation->id }}"></label>
                    </div>
                </td>
                <td>{{ $variation->id }}</td>
                <td>
                    <a href="{{ route('admin.variations.edit', $variation->id) }}">{{ $variation->name }}</a>
                </td>
                <td>{{ $variation->type }}</td>
                <td class="sorting_1">
                    <span data-toggle="tooltip"
                        title="{{ $variation->updated_at }}">{{ $variation->updated_at->diffForHumans() }}</span>
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
        {{ $totalProducts }} results entries
    @endslot

    @slot('tPagination')
        {!! $variations->appends(request()->input())->links('admin::pagination.simple') !!}
    @endslot
 
    @slot('ttotal')
        <div>
            <label class="dt-info" aria-live="polite" id="DataTables_Table_0_info" role="status">
                {{ "Show $perPage of $totalProducts variations" }}
            </label>
        </div>
    @endslot
 
    @slot('tchange')
        <div class="row dt-layout-row">
            <div class="dt-paging">
                <nav aria-label="pagination">
                    <ul class="pagination">
                        <li class="dt-paging-button page-item">
                            {{ $variations->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    @endslot
@endcomponent
 
@push('scripts')
    <script type="module">
   $(document).ready(function() {
    // Xử lý checkbox "chọn tất cả"
    $(document).on('change', '.select-all', function() {
        const isChecked = $(this).is(':checked');
        $('.index-table').find(".select-row").prop('checked', isChecked);
    });

    $(document).on('click', '#delete-records', function(event) {
        const recordsChecked = $('.index-table').find(".select-row:checked");
        const recordsCheckedAll = $('.index-table').find(".select-all:checked");

        let ids = [];

        if (recordsCheckedAll.length > 0) {
        // Nếu "chọn tất cả" được chọn, lấy tất cả ID bản ghi
        ids = $('.index-table').find(".select-row").toArray()
            .map(row => parseInt(row.value))
            .filter(id => !isNaN(id)); // Lọc ra các giá trị không hợp lệ
        } else {
        // Nếu không, chỉ lấy các ID bản ghi được chọn
        ids = recordsChecked.toArray()
            .map(row => parseInt(row.value))
            .filter(id => !isNaN(id)); // Lọc ra các giá trị không hợp lệ
        }

        if (ids.length === 0) {
        return;
        }

        const confirmationModal = $("#confirmation-modal");
        confirmationModal.modal('show');
        confirmationModal.find("form").find('input[name="ids"][type="hidden"]').val(JSON.stringify(ids));
        confirmationModal.find("form").attr('action', "{{ route('admin.variations.delete') }}");
    });

    // Lưu trữ DOM ban đầu của bảng
    const tableBody = $('tbody');
    const tableRows = tableBody.find('tr');
    const processingPanel = $('#DataTables_Table_0_processing');
    const noResultsRow = createNoResultsRow();

    // Tạo hàng "Không tìm thấy kết quả"
    function createNoResultsRow() {
        const row = $('<tr>').addClass('no-results').css('display', 'none');
        const cell = $('<td>').attr('colspan', tableRows.first().children().length)
            .addClass('text-center text-muted py-3')
            .text('Không tìm thấy sản phẩm phù hợp');
        row.append(cell);
        tableRows.first().closest('tbody').append(row);
        return row;
    }

    // Thiết lập sự kiện tìm kiếm
    const searchInput = $('.dt-search input[type="search"]').attr('placeholder', 'Search ID, Name, Type');
    if (searchInput.length) {
        // Xử lý tìm kiếm khi nhấn Enter
        searchInput.on("keypress", function(e) {
            if (e.which === 13) { // Kiểm tra phím Enter
                // Hiển thị panel xử lý
                processingPanel.css('display', 'block');

                const query = $(this).val().toLowerCase().trim();
                let visibleRowCount = 0;

                tableRows.each(function() {
                    const row = $(this);
                    const idCell = row.find('td:nth-child(2)');
                    const nameCell = row.find('td:nth-child(3)');
                    const priceCell = row.find('td:nth-child(4)');
                    const stockCell = row.find('td:nth-child(5)');

                    const matches =
                        (idCell.length && containsSearchTerm(idCell.text(), query)) ||
                        (nameCell.length && containsSearchTerm(nameCell.text(), query)) ||
                        (priceCell.length && containsSearchTerm(priceCell.text(), query)) ||
                        (stockCell.length && containsSearchTerm(stockCell.text(), query));

                    if (matches) {
                        row.show();
                        visibleRowCount++;
                    } else {
                        row.hide();
                    }
                });

                noResultsRow.css('display', visibleRowCount > 0 ? 'none' : '');

                // Ẩn panel xử lý sau khi hoàn thành tìm kiếm
                setTimeout(function() {
                    processingPanel.css('display', 'none');
                }, 300);
            }
        });

        // Xử lý khi xóa toàn bộ nội dung ô tìm kiếm
        searchInput.on('search', function() {
            if ($(this).val() === '') {
                // Hiển thị panel xử lý
                processingPanel.css('display', 'block');

                // Reset lại bảng khi ô tìm kiếm trống
                tableRows.show();
                noResultsRow.css('display', 'none');

                // Ẩn panel xử lý sau khi hoàn thành
                setTimeout(function() {
                    processingPanel.css('display', 'none');
                }, 300);
            }
        });

        // Hàm kiểm tra từ khóa có trong văn bản
        function containsSearchTerm(text, query) {
            if (!text) return false;

            const normalizedText = text.toLowerCase().trim();
            const normalizedQuery = query.toLowerCase().trim();

            return normalizedText.includes(normalizedQuery) ||
                normalizedText.split(/\s+/).some(word => word.startsWith(normalizedQuery));
        }
    }
    });
    </script>
@endpush
