<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\CompanyName;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $com_name = CompanyName::first()->name;
        return view('app.index', compact('com_name'));
    }
}
