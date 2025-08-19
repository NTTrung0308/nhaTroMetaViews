<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Policie;

class PolicyController extends Controller
{
    public function detail($policy)
    {
        // Lấy chính sách theo id
        $policy = Policie::where('id', $policy)->firstOrFail();
        return view('users.policy.index', compact('policy'));
    }
}