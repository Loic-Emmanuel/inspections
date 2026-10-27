<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\InspectionImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Dashboard accessible',
            'user' => Auth::user()
        ]);
    }

    public function statMonth()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $totalInspections = Inspection::count();
        $inspectMois = Inspection::whereBetween('date_inspection', [$startOfMonth, $endOfMonth])->count();
        $inspectMoisPrec = Inspection::whereBetween('date_inspection', [$startOfLastMonth, $endOfLastMonth])->count();

        $augmentNbre = $inspectMois - $inspectMoisPrec;
        $pourcentVsMoisPrec = $inspectMoisPrec > 0 
            ? round((($inspectMois - $inspectMoisPrec) / $inspectMoisPrec) * 100, 1) 
            : ($inspectMois > 0 ? 100 : 0);

        $totalImages = InspectionImage::count();

        $cinqDerniers = Inspection::withCount('images as nbreImge')
            ->latest('date_inspection')
            ->latest('id')
            ->take(5)
            ->get()
            ->map(function ($insp) {
                return [
                    'id' => $insp->id,
                    'uuid' => $insp->uuid ?: (string) $insp->id,
                    'client' => $insp->client ?: 'Client non spécifié',
                    'statut' => $insp->statut ?: 'en_cours',
                    'date_inspection' => $insp->date_inspection ? $insp->date_inspection->format('Y-m-d') : $insp->created_at->format('Y-m-d'),
                    'nbreImge' => $insp->nbreImge,
                ];
            });

        return response()->json([
            'total_inspections' => $totalInspections,
            'inspectMois' => $inspectMois,
            'inspection_images' => $totalImages,
            'augmentNbre' => $augmentNbre,
            'pourcentVsMoisPrec' => $pourcentVsMoisPrec,
            'cinqDerniers' => $cinqDerniers,
        ]);
    }
}