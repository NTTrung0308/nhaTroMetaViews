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

        if ($request->filled('tieu_de')) {
            $query->where('tieu_de', 'like', '%' . $request->tieu_de . '%');
        }

        if ($request->filled('tac_gia')) {
            $query->where('tac_gia', 'like', '%' . $request->tac_gia . '%');
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $tinTucs = $query->orderBy('created_at', 'desc')->paginate(6);
        return view('users.news.index', compact('tinTucs'));
    }
public function detail($slug)
    {
          $tinTuc = TinTuc::where('slug', $slug)->where('trang_thai', 'hien_thi')->firstOrFail();
        return view('users.news.detail', compact('tinTuc'));
    }
}
