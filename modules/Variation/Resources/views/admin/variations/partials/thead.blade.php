<tr>
    @include('admin::partials.table.select_all')

    @php
        $sortBy = request()->get('sort_by', 'id'); // Lấy cột hiện tại được sắp xếp
        $sort = request()->get('sort', 'asc'); // Lấy thứ tự sắp xếp hiện tại
        $newSort = ($sort === 'asc') ? 'desc' : 'asc'; // Chuyển đổi trạng thái sắp xếp
    @endphp
    
    {{-- Cột ID --}}
    <th data-dt-column="1" class="dt-orderable-asc dt-orderable-desc" style="width: 12%;">
        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'id', 'sort' => $newSort]) }}" class="text-decoration-none">
            <span class="dt-column-title">{{ trans('admin::admin.table.id') }}</span>
            <span class="dt-column-order
                @if($sortBy === 'id') {{ $sort === 'asc' ? 'dt-ordering-asc' : 'dt-ordering-desc' }} @endif"
                role="button">
            </span>
        </a>
    </th>

    {{-- Cột name --}}
    <th data-dt-column="1" style="width: 52%;" >
        <span class="dt-column-title">
            {{ trans('product::products.table.name') }}
        </span>
    </th>

    {{-- Cột TYPE --}}
    <th data-dt-column="1" class="dt-orderable-asc dt-orderable-desc" style="width: 16%;" >
        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'type', 'sort' => $newSort]) }}" class="text-decoration-none">
            <span class="dt-column-title">{{ trans('variation::variations.table.type') }}</span>
            <span class="dt-column-order
                @if($sortBy === 'type') {{ $sort === 'asc' ? 'dt-ordering-asc' : 'dt-ordering-desc' }} @endif"
                role="button">
            </span>
        </a>
    </th>

    {{-- Cột Ngày cập nhật --}}
    <th data-dt-column="1" class="dt-orderable-asc dt-orderable-desc"  style="width: 20%;">
        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'updated_at', 'sort' => $newSort]) }}" class="text-decoration-none">
            <span class="dt-column-title">{{ trans('admin::admin.table.updated') }}</span>
            <span class="dt-column-order
                @if($sortBy === 'updated_at') {{ $sort === 'asc' ? 'dt-ordering-asc' : 'dt-ordering-desc' }} @endif"
                role="button">
            </span>
        </a>
    </th>
</tr>
