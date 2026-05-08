<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ManualController extends Controller
{
    public function index(): View
    {
        return view("user-manual.index");
    }
}
