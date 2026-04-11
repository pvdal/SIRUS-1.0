<?php

namespace App\Http\Controllers;

use App\Exports\SimbajuCalendarExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * GET /export/simbaju?year=2025&semester=2&title=SIMBAJU+03/11+a+14/11/2025
     */
    public function simbaju(Request $request)
    {
        $request->validate([
            'year'     => 'required|integer|min:2000|max:2099',
            'semester' => 'required|integer|in:1,2',
            'title'    => 'nullable|string|max:100',
        ]);

        $year     = $request->integer('year');
        $semester = $request->integer('semester');
        $title    = $request->input('title', "SIMBAJU {$year}/{$semester}");

        $filename = "SIMBAJU_{$year}_{$semester}.xlsx";

        return Excel::download(
            new SimbajuCalendarExport($title, $year, $semester),
            $filename,
            \Maatwebsite\Excel\Excel::XLSX
        );
    }
}
