<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

// Legal: Terms and Policy
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LegalController extends Controller
{
    /**
     * @throws FileNotFoundException
     */
    public function showPolicies(): View
    {
        $policy = Str::markdown(File::get(resource_path('markdown/policy.md')));
        return view('policy', compact('policy'));
    }

    /**
     * @throws FileNotFoundException
     */
    public function showTerms(): View
    {
        $terms = Str::markdown(File::get(resource_path('markdown/terms.md')));
        return view('terms', compact('terms'));
    }
}
