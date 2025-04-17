<tr>
    @php
        $sortBy = request()->get('sort_by', 'id');
        $sort = request()->get('sort', 'asc');
        $newSort = ($sort === 'asc') ? 'desc' : 'asc';
    @endphp

    {{-- Cột ID --}}
    <th data-dt-column="id" class="dt-orderable-asc dt-orderable-desc" style="width: 6%;">
        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'id', 'sort' => $newSort]) }}" class="text-decoration-none">
            <span class="dt-column-title">ID</span>
            <span class="dt-column-order
                @if($sortBy === 'id') {{ $sort === 'asc' ? 'dt-ordering-asc' : 'dt-ordering-desc' }} @endif" role="button">
            </span>
        </a>
    </th>

    <th>Customer Name</th>

    {{-- Cột Customer Email --}}
    <th data-dt-column="customer_email" class="dt-orderable-asc dt-orderable-desc">
        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'customer_email', 'sort' => $newSort]) }}" class="text-decoration-none">
            <span class="dt-column-title">Email khách hàng</span>
            <span class="dt-column-order
                @if($sortBy === 'customer_email') {{ $sort === 'asc' ? 'dt-ordering-asc' : 'dt-ordering-desc' }} @endif" role="button">
            </span>
        </a>
    </th>

    {{-- Cột Trạng thái --}}
    <th data-dt-column="status" class="dt-orderable-asc dt-orderable-desc">
        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'status', 'sort' => $newSort]) }}" class="text-decoration-none">
            <span class="dt-column-title">Trạng thái</span>
            <span class="dt-column-order
                @if($sortBy === 'status') {{ $sort === 'asc' ? 'dt-ordering-asc' : 'dt-ordering-desc' }} @endif" role="button">
            </span>
        </a>
    </th>

    {{-- Cột Tổng tiền --}}
    <th data-dt-column="total" class="dt-orderable-asc dt-orderable-desc">
        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'total', 'sort' => $newSort]) }}" class="text-decoration-none">
            <span class="dt-column-title">Tổng tiền</span>
            <span class="dt-column-order
                @if($sortBy === 'total') {{ $sort === 'asc' ? 'dt-ordering-asc' : 'dt-ordering-desc' }} @endif" role="button">
            </span>
        </a>
    </th>

    {{-- Cột Ngày tạo --}}
    <th data-dt-column="created_at" class="dt-orderable-asc dt-orderable-desc">
        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort' => $newSort]) }}" class="text-decoration-none">
            <span class="dt-column-title">Ngày tạo</span>
            <span class="dt-column-order
                @if($sortBy === 'created_at') {{ $sort === 'asc' ? 'dt-ordering-asc' : 'dt-ordering-desc' }} @endif" role="button">
            </span>
        </a>
    </th>
</tr>
