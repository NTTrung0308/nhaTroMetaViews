<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
   public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'active' => 'boolean',
        ]);

        Faq::create($request->only('question', 'answer', 'active'));
        return redirect()->route('admin.faqs.index')->with('success', 'Thêm FAQ thành công');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'active' => 'boolean',
        ]);

        $faq->update($request->only('question', 'answer', 'active'));
        return redirect()->route('admin.faqs.index')->with('success', 'Cập nhật FAQ thành công');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'Xóa FAQ thành công');
    }
    public function show(Faq $faq)
{
    // Nếu gọi từ AJAX thì trả về HTML (render từ partial view)
    if (request()->ajax()) {
        return view('admin.faqs._show', compact('faq'))->render();
    }

    // Hoặc redirect nếu truy cập thường
    return redirect()->route('admin.faqs.index');
}

}
