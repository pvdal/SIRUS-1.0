<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaperController extends Controller
{
    public function showPaper($filepath): StreamedResponse
    {
        $path = "papers/$filepath";
        $paper = Paper::where('file_path', $path)->first();

        $this->authorize('view-paper', $paper);

        if(!auth()->check()) {
            abort(403,"Acesso negado.");
        }
        // Evita acesso fora da pasta
        if (str_contains($filepath, '..')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $filename = basename($filepath); // pega só o arquivo, sem pastas
        $displayName = preg_replace('/_[a-f0-9]{10}(\.pdf)$/', '$1', $filename);

        return Storage::disk('public')->response($path, null, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $displayName . '"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        ]);
    }
}
