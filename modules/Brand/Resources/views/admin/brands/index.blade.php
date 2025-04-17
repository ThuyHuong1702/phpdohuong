@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('brand::brands.brands'))

    <li class="active">{{ trans('brand::brands.brands') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'brands')
    @slot('name', trans('brand::brands.brands'))

    @slot('thead')
        @include('brand::admin.brands.partials.thead', ['name' => 'brands-index'])
    @endslot

    @slot('tbody')
    @if (!empty($brands))
        @foreach ($brands as $brand)
            <tr class="clickable-row">
                <td>
                    <div class="checkbox">
                        <input type="checkbox" class="select-row" value="{{ $brand->id }}" id="checkbox-{{ $brand->id }}">
                        <label for="checkbox-{{ $brand->id }}"></label>
                    </div>
                </td>
                <td class="dt-type-numeric">{{ $brand->id }}</td>
                <td>
                    <div class="thumbnail-holder">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACoCAMAAABt9SM9AAAAllBMVEX///8LIIkAAIMAAH8AAITr7fYAF4YAG4cIHoiwtdTHy+IAFoZSXaQAEYUAHIgAD4UACoTAxN45RZje4e4uPpj19vt0fLSkqc74+fy4vdkAAH2XncbY2+vl5/IABoTp6/VtdrFMV6FEUJ59hbmFjLyaoMjP0uUoN5NBTZ1ia6uMk8AaLZAiMpGqr9BQW6RveLJdZ6kTJoxuN2TwAAALoElEQVR4nO2d6WKyOhCGNSAEkFURqIALinsr939zJ0gSAi61X1G0J8+fUtCYvE4mk0nATofD4XA4HA6Hw+FwOBwOh8PhcDgcDofD4XA4HA6Hw+Fw/jf4vUkUpqoaKIo3PrFFjLfo4KAcAlUNo6jnt13L1vDd3kANDttk+jkf7jNDs0QgghyryumciM4a2crpT7eenUZu27V/Em6YKuPkOFsZJ2ksU5ck2TAgonsLdN0wZE23YiSd4fRHY3vwZ01tEgbeoj/UgZArpEnyN+LcFk6W9BgIupMs00nbLWsQ302D7XS905Ehmb+S6IJokhkDfZgEg7Zb+Xsi1UtmOxNZki4ZjapUUUw2QTxM7Lf1Y0imkWMKIDYl40EanQkm9g+9ttv9Q9xBsOhnFoh1+VGmdE0wDej94G18fqgk8wx5Js14sk6MXrvt63dHpJNjCciDtyQTxbDAKGpbjetM7O0nipna1wkDzXj0ktY1CL7WGrCkhw11/wS0dl7bytQID9OdAPRXMagKBpi9jnGF3qYLgP6UsODf0I20bZFyBspmlQv1ihbFIItqy0L11MRBQj07hPonDKFN2wqXn2jQewuhThhSSzGEby+GYvySzvw62rwFpXrBBr6TSVHA4clKRR7yUtr7CZVjZE9Vajm3wJt1PhbwtBERKSW+s1IIa/skpRzwbg79HO34eKVcZfbWvY8iO4+WSt1I7+rR68irhyoVLTJB/xtKIaTZ45RylX5svfDs+Mfoo0dJFS2Mv9L9CPHyMVKpc8H6W0ohhEfMDt3xHkhtt6x5HuGyBgnqf/mCetOVhbLUcLGoROn+pUhgNy1VePz4EFfr43qoAUuufpoGKDFbRbk8DyuvYttlAtGZF8Wy7zXwSy3miGAWJ/KXW2cFdqEOtOGsv96jyeo9WklNR1nqGghTvPTtD8ZDwNqBtjmUDMsWy+tUxdhdqG3of0HZOClOUlxsuN3FtFhjj189BkP8riVRy1wU1/ZG19ymtQK7kvWlFmuok6APvjcvKDab/bPngrmvFDmOGbVAwFwZ6WW1++XplWyN6T89gerssJs1/IVIipWH5LMF8sWnRBGgFCcWFvnossCuOWRLtLvf+ti40bhBGQoSrKcTl8x3CUL2QnxRrI3GeAbaNmNXW0dPzOtiqXWxBgCeiaXNqyX29jWXUUfa/5sqF1GHQL4wL/fLNUAosTstVKaLMWJtLUZS2ra4vnAXkf59j2V1ZlJdLGjVowC14s/OMLSw0xTpDJy+GZLxmawTfGVO7Zu2q3hF2SNYsQKgl0t0tG0C7jKhs8CX9sYPxDqAuljaJ76kDIkh7265LVhxIb8iPJLxRMAb58ZCjNs8pb5J+qy8SbwoVigwkpK2QYALGwHSH2fSVbHOumHHF+timeS73AjEFZUVvaCV0FRG2V2I9HME3NO2sYRbVTpyWsGCNTU5VixXZHJGVCyRNMgkYh21H1hW50uoiUUnLv14g4+2ZchxblfloPM7vC4z4hGxgg8i1hcVq5bvpz66IlZnxUh6JpYn/JtY6UdNLFqXfky+HK8ccR6lVTirhCjEuXQWgm7kwC5Vkvgz3KU86lErYvUZX162jfixL0Eris2uO/jzbtjpZHWxyKXSsg7XPLwhNOOv/EUt+C3rl/sxyO6whiL2Z1iz9EyskyKL/LLr1tpGVwrQSCKxxd5nWZ2tck0sc1ZErumCWnoVSW5mlpOu4tpMTWIWIlOnEr/DLu5B2HR6NH9DxErzFxzyITrtVdumbcpi1R37oXeKNbgqlibhWdIVrcxVM3uXE3AeyAE2IlJiZoShOk7x3xV5NxFLySUauOSIDYsqc9glk9K4sxt2JtUCS7HK2eolqSCYNbKtNKpO/GjpbILM7ZeOQP/CJ9f4L/HRpVh0prSodUMURDIN70wcagZ3WhbmXKz5wXdP+N6F0VAGzSx+HazLsykI5mysO6XNIsG9b+BLdKymYtHGHetioWKPTHfw+8Rkfy0Wdd7euYO3smbC9tElsyrQALMJ06dzLtKTXBpekNpRsUh43nHOxEKWaS7KHtGD94+GLvO2n4hlCNNG9vtNnGtBiaTruikwgcmY2I+Av6XJBz4Y1MUKSCay162LpZ2KtcpIjURpd1hWVI78F8RSiJQ1saCVNTMKhtm1bJl0HJ2Y0wRIWXVcq/SDxFtkOKRi7Uj5Zk0sbVMUu16TuTgxyzssq1cOpRccfJcUUBVLBl/NbCNVxavpDIB9dCCIuFkRrh/dghJ8EPtw5JpYAL/HtmpikVjXEzLchJAUSwS+0Q27NNtxKc4iqRdWLAOsGsr0KTfSisQxBYBMKHycp6PZ/oNARhgyE6JikQ461uti4QteLNjVZl8Qq94NeyJ19BfE0s/FgiZsai6o1APRiljYPwSATFWJWCbx3ls6zyf5v1Is3ISNUY/gU/IO0ko6beziwm50Q5qPYQok4eAFsTRx2tQtTvb1YbBbTlBtgcRbLn49nbpu4hktqiaWgAVd1R08MVgPkHnagOYPcGHpB4nfgrNuSLp3WSDNXR/jms+ShHljab5UvLkURdIwk2wXVVtFp3cznWyviGpi2QI+ELOaWMRMQ32I2132NXxiQjNAdPwllmVQOzqfPx1EIttJLBk4za139eDtVDXdlOOTERlP5qFJ8rhDSSLjjAmrlgWKPhUJdbGow6MhE41oaWaKXnJoZIfF6mo0JqHzJ6NXfxsSSwarxhKiiPWNdGJRwXq23CkCfWOHFfIzA5CwAjerFKswExXUxTpb33RpEhgatWz6mDpq2g0NgF9TFmhO603zANg3KRVTkWtAsaJWb4aDRzqN7ullj8SRJSNWWlQ782ttg2Jl6hI5ZaAnZZWdnuPSpxKxDEjMj5kSgHJla3z6ipb7s9nRrxjcdO64WcDBOYOOHy500ihtWkxY/TSGMZ68+ng5VJ5PBohoaVnjCP0dmVmYnxgwKy4Q9Mlty36YmOy8VAZHFV9y7RlTRWsZ5aWkXSg7p6NBynzZllPcp+omH9toELrNrd4UHL/rhMVXDbT1ZpR8HXeg3EgDu1qBDLtQwscki2qIJ5CdmflfdD4+najsw9GANs+L/dwBs/qdwfzSdDSazrXqfhS9KBfmdSoOq/XM0Hyjr1kQfDiN3+Cb3mFYRe0lTTd1rRK7QkLtmLlIjspXfF8svYQmj+f33zGFXCiva6AppybH1lfTVtVhElB/ByiD/fYRz71wb4dY74gJhsFjbrsMvh0K3wqI/FjysNviri1/vCXQFGfKA59ysfkzLgvqwEge4NQZ+n9DLBRoiFP70Y8C+QtiQdkSZ894yMytbSbvgWyB1eI5D8haXt058Q7AXKntYx0Vw0D4vkovSt77nOcplbN+zxsBkEe3hs9VqlOmgd8Jo7XHhm3eKyyFkgX2rT2Q7ruk8iuBTEpbj9MWH60WCW+hlqEBYZc8aIp8P6Hx4k4eGloMdpvDs/35RQb7F/ZbaNwD2XH5Oo+yde+5Kej5QFkHQnz02nRSl1CMWwv4zwdCLb+9bvoaXa+Ou9Cvb7B/LrlBAThbBC/8SORJIsRtj4tQMoEAViMlbHvU+xZ3vBfaurceGkgnFEUlXvhiHuoqvr3Rnv8sAlmPgZXNk8OrefJvcZVj/iS6Z4iErAnJBOLVaGlH76YTwQ9GQ/DIx4sildBgB8RsjmQavLx7+pZJMFpLTT8VEuaeKbelzNkslD/1AwCdnuqNVvnPSJjabzRDEsmaeXqugL77HC2DdPL+xnQZd2B7yXGln56uoGuSbHz3uxtd2M1/eCPfxJArJABtvz4mW88OJ+/qmH6IP0ltbzs9rp1dppc3ElmWZSIsK45jclIEur7bO+v+NBl7thr+WTu6g/zXcNLUDhTP85bj8TZJksV4u1wu0f9KYKtpGvV67v/EhjgcDofD4XA4HA6Hw+FwOBwOh8PhcDgcDofD4XA4HA6Hw+FwOBwOh8PhcDgcDofDeTP+A88n6+oiTH1nAAAAAElFTkSuQmCC"
                            alt="thumbnail">
                    </div>
                </td>
                <td class="name" onclick="window.location='{{ route('admin.brands.edit', $brand->id) }}'">
                    <a href="{{ route('admin.brands.edit', $brand->id) }}">{{ $brand->name}}</a>
                </td>
                <td>
                    <span class="badge badge-success {{ $brand->is_active ? 'bg-primary' : 'bg-secondary' }}">
                        {{ $brand->is_active ? 'Active' : 'UnActive' }}
                    </span>
                </td>
                <td class="sorting_1">
                    <span data-toggle="tooltip" title="{{ $brand->created_at }}">{!! $brand->created_at->diffForHumans() !!}</span>
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
        {{ $totalBrands }} results entries
    @endslot

    @slot('tPagination')
        {!! $brands->appends(request()->input())->links('admin::pagination.simple') !!}
    @endslot

@endcomponent


@if (session()->has('exit_flash'))
    @push('notifications')
        <div class="alert alert-success fade in alert-dismissible clearfix">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                    d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM11.25 8C11.25 7.59 11.59 7.25 12 7.25C12.41 7.25 12.75 7.59 12.75 8V13C12.75 13.41 12.41 13.75 12 13.75C11.59 13.75 11.25 13.41 11.25 13V8ZM12.92 16.38C12.87 16.51 12.8 16.61 12.71 16.71C12.61 16.8 12.5 16.87 12.38 16.92C12.26 16.97 12.13 17 12 17C11.87 17 11.74 16.97 11.62 16.92C11.5 16.87 11.39 16.8 11.29 16.71C11.2 16.61 11.13 16.51 11.08 16.38C11.03 16.26 11 16.13 11 16C11 15.87 11.03 15.74 11.08 15.62C11.13 15.5 11.2 15.39 11.29 15.29C11.39 15.2 11.5 15.13 11.62 15.08C11.86 14.98 12.14 14.98 12.38 15.08C12.5 15.13 12.61 15.2 12.71 15.29C12.8 15.39 12.87 15.5 12.92 15.62C12.97 15.74 13 15.87 13 16C13 16.13 12.97 16.26 12.92 16.38Z"
                    fill="#555555" />
            </svg>

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M5.00082 14.9995L14.9999 5.00041" stroke="#555555" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M14.9999 14.9996L5.00082 5.00049" stroke="#555555" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

            <span class="alert-text">{{ session('exit_flash') }}</span>
        </div>
    @endpush
@endif
@push('scripts')
    <script type="module">
    $(document).ready(function () {
        // Xử lý chọn tất cả checkbox
        $(".select-all").on("change", function () {
            $("input[type='checkbox']:not(.select-all)").prop("checked", $(this).prop("checked"));
        });

        // Xử lý khi bấm nút Delete
        $(".btn-delete").on("click", function () {
            const selectedIds = [];
            $("input.select-row:checked").each(function () {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                toastr.warning("Vui lòng chọn ít nhất một mục để xóa!");
                return;
            }

            const confirmationModal = $("#confirmation-modal");
            confirmationModal.modal('show');
            confirmationModal.find("#delete-ids").val(JSON.stringify(selectedIds));
        });

        // Tìm kiếm trong bảng
        const searchInput = $('.dt-search input[type="search"]');
        const tableRows = $('tbody tr.clickable-row');

        // // Gắn sự kiện lắng nghe
        // searchInput.on("keyup", function () {
        //     const query = $(this).val().toLowerCase();

        //     tableRows.each(function () {
        //         // Lấy giá trị ID và tên từ từng dòng
        //         const idCell = $(this).find('td.dt-type-numeric');
        //         const nameCell = $(this).find('a.name');

        //         // Kiểm tra có khớp không
        //         const matches = idCell.text().includes(query) || nameCell.text().toLowerCase().includes(query);

        //         // Hiển thị hoặc ẩn dòng dựa trên kết quả so khớp
        //         $(this).toggle(matches);
        //     });
        // });
        // Tìm kiếm trong bảng
        $(document).ready(function () {
    const searchInput = $('.dt-search input[type="search"]');
    const tableRows = $('tbody tr.clickable-row');
    const tableBody = $('tbody');
    const processingPanel = $('#DataTables_Table_0_processing'); // Sử dụng đúng ID của processing panel

    searchInput.on("keydown", function (event) {
        if (event.key === "Enter") {
            const query = $(this).val().toLowerCase();
            let hasResults = false;

            // Hiển thị panel xử lý
            processingPanel.css('display', 'block');

            tableRows.each(function () {
                const idCell = $(this).find('td.dt-type-numeric');
                const nameCell = $(this).find('a.name');

                const matches = idCell.text().includes(query) || nameCell.text().toLowerCase().includes(query);

                $(this).toggle(matches);

                if (matches) {
                    hasResults = true;
                }
            });

            tableBody.find('.no-data').remove();
            if (!hasResults) {
                tableBody.append('<tr class="no-data"><td colspan="100%" style="text-align: center;">Không tìm thấy dữ liệu!</td></tr>');
            }

            // Ẩn panel xử lý sau khi hoàn thành
            setTimeout(function () {
                processingPanel.css('display', 'none');
            }, 300);
        }
    });
});

    });
</script>

@endpush
@push('style')
<style>
    .logo-holder {
    position: relative;
    border: 1px solid #e2e8f0;
    background: transparent;
    height: 55px;
    width: 60px;
    border-radius: 6px;
    overflow: hidden !important;

    > {
        i {
            position: absolute;
            font-size: 24px;
            color: #d9d9d9;
            top: 50%;
            left: 50%;
            -webkit-text-stroke: 0.06px #fff;
            transform: translate(-50%, -50%);
        }

        img {
            position: absolute;
            left: 50%;
            top: 50%;
            max-height: 100%;
            max-width: 100%;
            transform: translate(-50%, -50%);
        }
    }
}
</style>
@endpush
