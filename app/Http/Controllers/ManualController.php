<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ManualController extends Controller
{
    public function show(string $page): View
    {
        $view = "user-manual.$page";

        if (!view()->exists($view)) {
            abort(404);
        }

        return view("$view");
    }

    public function getManual(): View
    {
        return view("user-manual.content");
    }
}
