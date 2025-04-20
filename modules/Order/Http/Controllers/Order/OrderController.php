<?php

namespace Modules\Order\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Order\Entities\Order;

class OrderController extends Controller
{
    protected $model = Order::class;

    protected $viewPath = 'order::admin.orders';

    public function index(Request $request)
    {
        // Các cột có thể sắp xếp
        $sortableColumns = ['customer_email', 'status', 'total', 'created_at'];

        // Lấy giá trị sắp xếp từ request
        $sortBy = $request->get('sort_by', 'created_at');
        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'created_at';
        }

        // Thứ tự sắp xếp
        $sortOrder = $request->get('sort', 'desc');
        if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        // Phân trang
        $perPage = $request->input('per_page', 2);
        $totalOrders = Order::count(); // Tổng số sản phẩm
        // Tìm kiếm
        $search = $request->input('search', '');

        // Query
        $query = Order::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_first_name', 'like', "%{$search}%")
                  ->orWhere('customer_last_name', 'like', "%{$search}%");
            });
        }

        // Sắp xếp và phân trang
        $orders = $query->orderBy($sortBy, $sortOrder)->paginate($perPage);

        $showDelete = false;

        return view("{$this->viewPath}.index", compact('orders', 'sortBy', 'sortOrder', 'perPage', 'totalOrders', 'search', 'showDelete'));
    }

    public function show($id)
    {
        //Eager load order products and variations
        $order = Order::with([
            'orderProducts.product',
            'orderProducts.variations',
            'customer',
        ])
        ->findOrFail($id);

        return view("{$this->viewPath}.show", compact('order'));
    }


}
