<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutController extends Controller
{
     public function index(){
        $abouts = AboutUs::find(1);
        return view('users.abouts.index', compact('abouts'));
     }
}
