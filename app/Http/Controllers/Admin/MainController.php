<?php

namespace LaravelItalia\Http\Controllers\Admin;

use LaravelItalia\Http\Controllers\Controller;

class MainController extends Controller
{
    public function getDashboard()
    {
        return view('admin.dashboard');
    }
}
