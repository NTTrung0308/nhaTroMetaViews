<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(){
      $sliders = Slider::where('active', 1)->get();
    return view('users.section.home', compact('sliders'));
   }
}
