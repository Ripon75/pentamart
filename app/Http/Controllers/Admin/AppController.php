<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AppController extends Controller
{
    public function updateView()
    {
        return view('adminend.pages.app.view');
    }

    public function update(Request $request)
    {
        return Utility::updateApp();
    }
}
