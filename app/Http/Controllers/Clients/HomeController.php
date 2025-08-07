<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Slider;
use App\Models\TinTuc;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(){
      $sliders = Slider::where('active', 1)->get();
      $feedbacks = Feedback::where('active', 1)->get();
      $latestPosts = TinTuc::where('trang_thai', 'hien_thi')
                        ->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();
    return view('users.section.home', compact('sliders','feedbacks', 'latestPosts'));
   }
}
