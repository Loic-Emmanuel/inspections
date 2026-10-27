<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generate($id)
    {
        return $this->download($id);
    }

    public function download($id)
    {
        $inspection = Inspection::with(['images', 'inspecteur', 'clientEntity'])
            ->where('uuid', $id)
            ->orWhere('id', $id)
            ->firstOrFail();

        $userName = $inspection->inspecteur 
            ? trim($inspection->inspecteur->firstname . ' ' . $inspection->inspecteur->name) 
            : 'Non assigné';

        $pdf = Pdf::loadView('reports.inspection', [
            'inspection' => $inspection,
            'userName' => $userName,
        ])->setPaper('a4', 'portrait');

        $fileName = 'rapport-inspection-' . ($inspection->reference ?: $inspection->id) . '.pdf';

        return $pdf->download($fileName);
    }
}
