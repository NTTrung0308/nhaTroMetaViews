<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(){
        $members = Member::all();
        $feedbacks = Feedback::where('active', 1)->get();
        return view('users.members.index', compact('members', 'feedbacks'));
    }
}
