<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\TinTuc;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
{
    $query = TinTuc::query();

    if ($request->filled('keyword')) {
        $query->where(function ($q) use ($request) {
            $q->where('tieu_de', 'like', '%' . $request->keyword . '%')
              ->orWhere('mo_ta_ngan', 'like', '%' . $request->keyword . '%');
        });
    }

    $tinTucs = $query->orderBy('created_at', 'desc')->paginate(6);
    return view('users.news.index', compact('tinTucs'));
}


public function detail($slug)
{
    $tinTuc = TinTuc::where('slug', $slug)
        ->where('trang_thai', 'hien_thi')
        ->firstOrFail();

    // Lấy thêm 5 bài viết mới nhất, loại trừ bài hiện tại
    $tinMoi = TinTuc::where('trang_thai', 'hien_thi')
        ->where('id', '!=', $tinTuc->id)
        ->orderBy('created_at', 'desc')
        ->take(7)
        ->get();

    return view('users.news.detail', compact('tinTuc', 'tinMoi'));
}
}
