<?php

namespace Modules\Variation\Http\Controllers\Admin;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Modules\Variation\Entities\Variation;
use Modules\Variation\Entities\VariationValue;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Variation\Http\Controllers\Admin\RedirectResponse;
use Illuminate\Support\Facades\DB;

class VariationController extends Controller
{
    /**
     * Hiển thị danh sách dữ liệu.
     *
     * @return Response
     */
    public function index(Request $request)
    {
      // Danh sách cột có thể sắp xếp
      $sortableColumns = ['id', ' type','updated_at'];

      // Lấy giá trị cột cần sắp xếp từ request, mặc định là 'id'
      $sortBy = $request->get('sort_by', 'id');

      // Kiểm tra nếu cột không hợp lệ, đặt lại thành 'id'
      if (!in_array($sortBy, $sortableColumns)) {
          $sortBy = 'id';
      }

      // Lấy thứ tự sắp xếp, mặc định là 'asc'
      $sortOrder = $request->get('sort', 'desc');
      if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
          $sortOrder = 'desc';
      }


        $perPage = $request->input('per_page', 20);
        $totalProducts = Variation::count();
        $variations = Variation::orderBy($sortBy, $sortOrder)->paginate($perPage);
        $showDelete = true;
        return view('variation::admin.variations.index', compact('variations', 'sortBy', 'sortOrder','perPage', 'totalProducts', 'showDelete'));
    }


    /**
     * Hiển thị form thêm dữ liệu mới.
     *
     * @return View
     */
    public function create()
    {
        $varition = new Variation(); // Tạo một đối tượng rỗng

        return view('variation::admin.variations.create', compact('varition'));
    }

    /**
     * Lưu dữ liệu mới vào cơ sở dữ liệu.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'values' => 'required|array',
        ];

        // Điều kiện xác thực cho label, color, image
        if ($request->type === 'color') {
            $rules['values.*.color'] = 'required|string|max:255';
        } elseif ($request->type === 'image') {
            $rules['values.*.image'] = 'required|string|max:255';
        } else {
            $rules['values.*.label'] = 'required|string|max:255';
        }

        // Thực hiện xác thực
        $request->validate($rules);

        try {
            // Tạo variation mới
            $variation = Variation::create([
                'name' => $request->name,
                'type' => $request->type,
            ]);

            // Lưu các variation values
            foreach ($request->values as $value) {
                if ($request->type === 'color') {
                    VariationValue::create([
                        'variation_id' => $variation->id,
                        'label' => $value['label'],
                        'value' => $value['color'],
                    ]);
                } elseif ($request->type === 'image') {
                    VariationValue::create([
                        'variation_id' => $variation->id,
                        'label' => $value['label'],
                        'value' => $value['image'],
                    ]);
                } else {
                    VariationValue::create([
                        'variation_id' => $variation->id,
                        'label' => $value['label'],
                        'value' => '',
                    ]);
                }
            }
            return redirect()->route('admin.variations.index')->with('success', 'Dữ liệu đã được thêm thành công!');
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('admin.variations.index')->with('error', 'Dữ liệu đã được thêm  vui lòng kiểm tra lại!');
        }
    }
    /**
     * Hiển thị chi tiết dữ liệu (nếu cần).
     *
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $variation = Variation::query()
            ->select('id', 'name', 'type')
            ->where('id', $id)
            ->with([
                'values' => function ($query) {
                    $query->select('id', 'label', 'value', 'variation_id')->orderBy('position', 'asc');
                },
            ])->first();

        return view('variation::admin.variations.show', compact('variation', 'values'));
    }

    public function showVariants($id)
    {
        // Truy vấn biến thể theo ID, lấy kèm danh sách các giá trị từ bảng variation_values
        $variation = Variation::with(['values' => function ($query) {
            $query->selectRaw('*') // Chọn tất cả các cột
                  ->addSelect(['value as color']); // Ánh xạ cột 'value' thành 'color'
        }])->findOrFail($id);

        // Nếu không tìm thấy, trả về lỗi 404
        if (!$variation) {
            return response()->json(['message' => 'Không tìm thấy biến thể'], 404);
        }

        // Trả về dữ liệu biến thể dưới dạng JSON
        return response()->json($variation);
    }


    /**
     * Hiển thị form sửa dữ liệu.
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $variation = Variation::query()
            ->select('id', 'name', 'type')
            ->where('id', $id)
            ->with([
                'values' => function ($query) {
                    $query->select('id', 'label', 'value as color', 'variation_id')->orderBy('position', 'asc');
                },
            ])->first();

        return view('variation::admin.variations.edit', compact('variation'));
    }

    /**
 * Cập nhật dữ liệu vào cơ sở dữ liệu.
 *
 * @param Request $request
 * @param int $id
 * @return RedirectResponse
 */
public function update(Request $request, $id)
{
    // Xác thực dữ liệu
    $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'values' => 'required|array',
    ];

    // Điều kiện xác thực cho label, color, image
    if ($request->type === 'color') {
        $rules['values.*.color'] = 'required|string|max:255';
    } elseif ($request->type === 'image') {
        $rules['values.*.image'] = 'required|string|max:255';
    } else {
        $rules['values.*.label'] = 'required|string|max:255';
    }

    // Thực hiện xác thực
    $request->validate($rules);

    try {
        // Cập nhật Variation
        $variation = Variation::findOrFail($id);
        $variation->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        // Xóa các giá trị cũ
        VariationValue::where('variation_id', $variation->id)->delete();

        // Thêm các giá trị mới
        foreach ($request->values as $value) {
            if ($request->type === 'color') {
                VariationValue::create([
                    'variation_id' => $variation->id,
                    'label' => $value['label'],
                    'value' => $value['color'],
                ]);
            } elseif ($request->type === 'image') {
                VariationValue::create([
                    'variation_id' => $variation->id,
                    'label' => $value['label'],
                    'value' => $value['image'],
                ]);
            } else {
                VariationValue::create([
                    'variation_id' => $variation->id,
                    'label' => $value['label'],
                    'value' => '',
                ]);
            }
        }

        return redirect()->route('admin.variations.index')->with('success', 'Dữ liệu đã được cập nhật thành công!');
    } catch (\Exception $e) {
        report($e);
        return redirect()->route('admin.variations.index')->with('error', 'Bản ghi này đã tồn tại');
    }
}


   /**
 * Xóa nhiều bản ghi cùng lúc.
 *
 * @param Request $request
 * @return \Illuminate\Http\Response
 */
public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $result = [];
            $variationIds = json_decode($request->input('ids'));
            $deletedRows = 0;

            if (!empty($variationIds)) {
                $deletedRows = Variation::whereIn('id', $variationIds)->delete();
            }
            if ($deletedRows > 0) {
                DB::commit();
                $result['success'] = "Xoá thành công bản ghi.";
            } else {
                DB::rollBack();
                $result['success'] = "Không có bản ghi nào được xoá.";
            }
            return redirect()->route('admin.variations.index')->with($result);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.variations.index')->with([
                'success' => $e->getMessage(),
            ]);
        }
    }


}
