<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function preview($bladePath, $type, $id)
    {
        // Pastikan view yang dimaksud ada
        if (!view()->exists($bladePath)) {
            abort(404, 'View not found');
        }

        $pdf = Pdf::loadView($bladePath);
        return $pdf->stream();
    }

    public function download($bladePath, $type, $id)
    {
        if (!view()->exists($bladePath)) {
            abort(404, 'View not found');
        }

        $fileName = str_replace('.', '_', $bladePath) . '.pdf';
        $pdf = Pdf::loadView($bladePath);
        return $pdf->download($fileName);
    }
}
