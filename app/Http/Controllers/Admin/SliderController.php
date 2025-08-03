<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem slider')->only(['index']);
        $this->middleware('can:Thêm slider')->only(['create', 'store']);
        $this->middleware('can:Sửa slider')->only(['edit', 'update']);
        $this->middleware('can:Xóa slider')->only(['destroy']);
    }
    public function index()
    {
        $sliders = Slider::orderBy('position')->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'cropped_image' => 'required|string',
            'link' => 'nullable|url',
            'position' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ], [
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'subtitle.string' => 'Phụ đề phải là chuỗi.',
            'subtitle.max' => 'Phụ đề không được vượt quá 255 ký tự.',

            'cropped_image.required' => 'Vui lòng chọn và cắt ảnh.',

            'link.url' => 'Liên kết không hợp lệ. Vui lòng nhập đúng định dạng URL.',

            'position.integer' => 'Vị trí phải là số nguyên.',

            'active.boolean' => 'Trạng thái hiển thị phải là true hoặc false.',
        ]);


        $imagePath = $this->saveBase64Image($request->input('cropped_image'));

        $slider = Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'link' => $request->link,
            'position' => $request->position ?? 0,
            'active' => $request->boolean('active'),
        ]);
        LogHelper::ghi(
            'Thêm mới slider: "' . ($slider->title ?? 'Không tiêu đề') . '" (ID: ' . $slider->id . ')',
            'Slider',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã thêm slider "' . ($slider->title ?? 'Không tiêu đề') . '" trong quản trị viên.'
        );
        return redirect()->route('sliders.index')->with('success', 'Thêm slider thành công.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'cropped_image' => 'nullable|string',
            'link' => 'nullable|url',
            'position' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ], [
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'subtitle.string' => 'Phụ đề phải là chuỗi.',
            'subtitle.max' => 'Phụ đề không được vượt quá 255 ký tự.',


            'link.url' => 'Liên kết không hợp lệ. Vui lòng nhập đúng định dạng URL.',

            'position.integer' => 'Vị trí phải là số nguyên.',

            'active.boolean' => 'Trạng thái hiển thị phải là true hoặc false.',
        ]);


        if ($request->filled('cropped_image')) {
            $imagePath = $this->saveBase64Image($request->input('cropped_image'));
            $slider->image = $imagePath;
        }

        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->link = $request->link;
        $slider->position = $request->position ?? 0;
        $slider->active = $request->boolean('active');
        $slider->save();
        // Ghi lại log chi tiết
        LogHelper::ghi(
            'Cập nhật slider: "' . ($slider->title ?? 'Không tiêu đề') . '" (ID: ' . $slider->id . ')',
            'Slider',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã cập nhật slider "' . ($slider->title ?? 'Không tiêu đề') . '" trong quản trị viên.'
        );
        return redirect()->route('sliders.index')->with('success', 'Cập nhật slider thành công.');
    }

    public function destroy(Slider $slider)
    {
        // Xóa ảnh nếu có
        if ($slider->image && file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }

        $title = $slider->title ?? 'Không tiêu đề';
        $id = $slider->id;

        $slider->delete();

        // Ghi log chi tiết
        LogHelper::ghi(
            'Xóa slider: "' . $title . '" (ID: ' . $id . ')',
            'Slider',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã xóa slider "' . $title . '" trong quản trị viên.'
        );

        return redirect()->route('sliders.index')->with('success', 'Xóa slider thành công.');
    }


    protected function saveBase64Image($base64Image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new \Exception('Định dạng ảnh không hợp lệ.');
            }

            $imageName = time() . '_' . Str::random(10) . '.' . $type;
            $directory = public_path('uploads/sliders');
            $imagePath = $directory . '/' . $imageName;

            // 👉 Tạo thư mục nếu chưa có
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            file_put_contents($imagePath, base64_decode($base64Image));

            return 'uploads/sliders/' . $imageName;
        }

        throw new \Exception('Ảnh không hợp lệ.');
    }
}
