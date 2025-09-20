<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaperController extends Controller
{
    public function showPaper($filepath): StreamedResponse
    {
        // Evita acesso fora da pasta
        if (str_contains($filepath, '..')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists("papers/{$filepath}")) {
            abort(404);
        }

        return Storage::disk('public')->response("papers/{$filepath}", null, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filepath . '"'
        ]);
    }
}
