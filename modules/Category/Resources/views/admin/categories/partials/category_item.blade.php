<div class="category-item tree" data-id="{{ $category->id }}">
    <div class="category-name">
        @if ($category->children->isNotEmpty())
            <span class="toggle-icon" onclick="toggleCategory(this)">▶</span> <!-- Nút để mở/đóng danh mục con -->
        @endif
        <i class="category-icon">📁</i>
        <span class="category-text">{{ $category->name }}</span>
    </div>
    
    <button type="button" class="btn btn-default add-sub-category" style="display: none;">Thêm danh mục con</button>

    @if ($category->children->isNotEmpty())
        <div class="children" style="display: none;"> <!-- Ẩn danh mục con mặc định -->
            @foreach ($category->children as $child)
                @include('category::admin.categories.partials.category_item', ['category' => $child])
            @endforeach
        </div>
    @endif
</div>

<script>
    // Hàm để mở/đóng danh mục con
    function toggleCategory(element) {
        const categoryItem = element.closest('.category-item');
        const childrenList = categoryItem.querySelector('.children');
        
        if (childrenList) {
            if (childrenList.style.display === 'none' || childrenList.style.display === '') {
                childrenList.style.display = 'block'; // Hiện danh mục con
                element.textContent = '▼'; // Đổi thành mũi tên xuống
                element.classList.add('active'); // Thêm lớp active
            } else {
                childrenList.style.display = 'none'; // Ẩn danh mục con
                element.textContent = '▶'; // Đổi thành mũi tên sang phải
                element.classList.remove('active'); // Xóa lớp active
            }
        }
    }
</script>

<style>
    .tree {
        list-style-type: none;
        padding-left: 20px; /* Khoảng cách bên trái cho cây */
    }
    
    .category-item {
        position: relative;
        padding-left: 20px; /* Khoảng cách cho tên danh mục */
        display: block; /* Sử dụng block để xếp theo hàng dọc */
    }

    .toggle-icon {
        cursor: pointer; /* Hiển thị con trỏ khi rê chuột qua */
        margin: 0 2px; /* Khoảng cách nhỏ từ bên trái và bên phải */
        font-size: 0.5em; /* Kích thước nhỏ hơn cho mũi tên */
        color: black; /* Màu mặc định */
        transition: color 0.3s; /* Hiệu ứng chuyển màu */
    }

    .toggle-icon.active {
        color: rgb(204, 199, 199); /* Màu trắng khi mở danh mục con */
    }

    .category-icon {
        margin-right: 5px; /* Khoảng cách giữa icon và tên danh mục */
        color: rgba(0, 0, 0, 0.5); /* Màu nhạt hơn cho icon */
        font-size: 1.2em; /* Kích thước icon */
    }

    .category-text {
        margin-left: 5px; /* Khoảng cách giữa tên và dấu gạch */
    }
    
    .children {
        padding-left: 20px; /* Khoảng cách cho danh sách con */
        display: none; /* Ẩn danh sách con mặc định */
    }

    .category-item:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 1px;
        border-left: 1px dashed #000; /* Đường nối dọc nét đứt */
    }
    
    .category-item:after {
        content: '';
        position: absolute;
        left: 0;
        top: 20px; /* Điều chỉnh vị trí để tạo góc vuông */
        width: 20px; /* Chiều dài của đường ngang */
        height: 1px;
        border-top: 1px dashed #000; /* Đường nối ngang nét đứt */
    }
    
    .category-item:last-child:before {
        height: 50%; /* Chiều cao của đường nối dọc cho mục cuối */
    }
    
    .category-item:last-child:after {
        display: none; /* Ẩn đường ngang cho mục cuối */
    }
</style>