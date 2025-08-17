<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ServiceAbout;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = ServiceAbout::latest()->get();
        return view('users.services.index', compact('services'));
    }
public function detail($slug)
    {
        $service = ServiceAbout::where('slug', $slug)->firstOrFail();
        return view('users.services.detail', compact('service'));
    }
}
