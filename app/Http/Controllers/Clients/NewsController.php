<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\TinTuc;
use Illuminate\Http\Request;
use App\Models\Faq;

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

    $tinTucs = $query->orderBy('created_at', 'desc')->paginate(12);

    // Lấy 5 tin mới nhất
    $tinMoi = TinTuc::orderBy('created_at', 'desc')->take(5)->get();

    // Lấy các FAQ đang active, mới nhất
    $faqs = Faq::where('active', 1)->latest()->take(5)->get();

    return view('users.news.index', compact('tinTucs', 'tinMoi', 'faqs'));
}


public function detail($slug)
    {
          $tinTuc = TinTuc::where('slug', $slug)->where('trang_thai', 'hien_thi')->firstOrFail();
        return view('users.news.detail', compact('tinTuc'));
    }
}