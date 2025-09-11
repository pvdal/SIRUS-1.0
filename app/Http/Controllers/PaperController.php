<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaperController extends Controller
{
    public function showPaper($filename): StreamedResponse
    {
        // Evita acesso fora da pasta
        if (str_contains($filename, '..')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists("papers/{$filename}")) {
            abort(404);
        }

        return Storage::disk('public')->response("papers/{$filename}", null, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
