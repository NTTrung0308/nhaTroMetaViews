<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
   public function index()
   {
       // Logic to list members
       return view('admin.members.index');
   }
}
