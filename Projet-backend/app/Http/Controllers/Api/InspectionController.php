<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Inspection;
use App\Models\InspectionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InspectionController extends Controller
{
    /**
     * Liste des inspections avec filtres et recherche
     */
    public function index(Request $request)
    {
        $query = Inspection::with(['images', 'inspecteur', 'clientEntity']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('lieu', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('statut')) {
            $statut = trim($request->input('statut'));
            $query->where('statut', 'like', $statut);
        }

        $dateFrom = $request->input('date_from') ?: $request->input('dateFrom');
        if ($dateFrom) {
            $query->whereDate('date_inspection', '>=', $dateFrom);
        }

        $dateTo = $request->input('date_to') ?: $request->input('dateTo');
        if ($dateTo) {
            $query->whereDate('date_inspection', '<=', $dateTo);
        }

        $perPage = (int) $request->input('per_page', 12);
        if ($perPage <= 0) {
            $perPage = 12;
        }

        $paginated = $query->latest('date_inspection')
            ->latest('id')
            ->paginate($perPage);

        $paginated->getCollection()->transform(function ($insp) {
            $firstImage = $insp->images->first();
            return [
                'id' => $insp->id,
                'uuid' => $insp->uuid ?: (string) $insp->id,
                'reference' => $insp->reference,
                'client' => $insp->client ?: 'Client non spécifié',
                'client_id' => $insp->client_id,
                'date_inspection' => $insp->date_inspection ? $insp->date_inspection->format('Y-m-d') : null,
                'lieu' => $insp->lieu,
                'type' => $insp->type,
                'description' => $insp->description,
                'recommandations' => $insp->recommandations,
                'statut' => $insp->statut ?: 'en_cours',
                'nbreImage' => $insp->images->count(),
                'nbreImge' => $insp->images->count(),
                'cover_image' => $firstImage ? $firstImage->url : null,
                'thumbnail' => $firstImage ? $firstImage->url : null,
                'images' => $insp->images,
            ];
        });

        return response()->json([
            'inspections' => $paginated,
        ]);
    }

    /**
     * Création d'une nouvelle inspection avec ses catégories et images
     */
    public function store(Request $request)
    {
        if ($request->has('client_id')) {
            $cId = $request->input('client_id');
            if ($cId === 'null' || $cId === 'undefined' || $cId === '' || $cId === null) {
                $request->merge(['client_id' => null]);
            }
        }

        $validated = $request->validate([
            'date_inspection' => 'required|date',
            'type_inspection' => 'required|string|max:255',
            'lieu_inspection' => 'required|string|max:255',
            'responsible_name' => 'nullable|string|max:255',
            'client_id' => 'nullable|integer',
            'observations' => 'nullable|string',
            'statut' => 'nullable|string|max:50',
            'recommandations' => 'nullable|string',
            'categories' => 'nullable|array',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            // Gestion du client automatique selon le choix de l'utilisateur
            $clientId = $request->input('client_id');
            $clientName = trim($request->input('responsible_name') ?: '');

            if ($clientId) {
                $client = Client::find($clientId);
                if ($client) {
                    $clientName = $client->nom;
                }
            } elseif (!empty($clientName)) {
                // Création automatique du client s'il n'existe pas encore
                $client = Client::firstOrCreate(
                    ['nom' => $clientName],
                    ['nom' => $clientName]
                );
                $clientId = $client->id;
            } else {
                $clientName = 'Client général';
            }

            $uuid = (string) Str::uuid();
            $reference = 'INSP-' . strtoupper(Str::random(6));

            $inspection = Inspection::create([
                'uuid' => $uuid,
                'reference' => $reference,
                'user_id' => Auth::id() ?: 1,
                'client_id' => $clientId,
                'client' => $clientName,
                'date_inspection' => $validated['date_inspection'],
                'lieu' => $validated['lieu_inspection'],
                'type' => $validated['type_inspection'],
                'description' => $validated['observations'] ?? null,
                'recommandations' => $validated['recommandations'] ?? null,
                'statut' => $validated['statut'] ?: 'Conforme',
            ]);

            // Traitement et enregistrement des images par catégorie
            if ($request->has('categories') && is_array($request->input('categories'))) {
                foreach ($request->input('categories') as $catIndex => $categoryData) {
                    $categoryName = $categoryData['name'] ?? 'Général';

                    if ($request->hasFile("categories.{$catIndex}.images")) {
                        $files = $request->file("categories.{$catIndex}.images");
                        foreach ($files as $file) {
                            if ($file && $file->isValid()) {
                                $path = $file->store('inspections', 'public');
                                InspectionImage::create([
                                    'inspection_id' => $inspection->id,
                                    'image_path' => $path,
                                    'categories' => $categoryName,
                                ]);
                            }
                        }
                    }
                }
            }

            return response()->json([
                'message' => 'Inspection créée avec succès',
                'uuid' => $inspection->uuid,
                'id' => $inspection->id,
                'inspection' => $inspection->load('images'),
            ], 201);
        });
    }

    /**
     * Détails d'une inspection
     */
    public function show($id)
    {
        $inspection = Inspection::with(['images', 'inspecteur', 'clientEntity'])
            ->where('uuid', $id)
            ->orWhere('id', $id)
            ->firstOrFail();

        $categories = $inspection->images->pluck('categories')->unique()->filter()->values();
        $userName = $inspection->inspecteur 
            ? trim($inspection->inspecteur->firstname . ' ' . $inspection->inspecteur->name) 
            : 'Non assigné';

        return response()->json([
            'inspection' => $inspection,
            'nbreCategories' => $categories->count(),
            'userName' => $userName,
        ]);
    }

    /**
     * Mise à jour d'une inspection
     */
    public function update(Request $request, $id)
    {
        if ($request->has('client_id')) {
            $cId = $request->input('client_id');
            if ($cId === 'null' || $cId === 'undefined' || $cId === '' || $cId === null) {
                $request->merge(['client_id' => null]);
            }
        }

        $inspection = Inspection::where('uuid', $id)->orWhere('id', $id)->firstOrFail();

        $validated = $request->validate([
            'date_inspection' => 'nullable|date',
            'type' => 'nullable|string|max:255',
            'lieu' => 'nullable|string|max:255',
            'client' => 'nullable|string|max:255',
            'client_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'recommandations' => 'nullable|string',
            'statut' => 'nullable|string|max:50',
        ]);

        $inspection->update($validated);

        return response()->json([
            'message' => 'Inspection mise à jour avec succès',
            'inspection' => $inspection->fresh(['images', 'inspecteur']),
        ]);
    }

    /**
     * Suppression d'une inspection (Soft delete)
     */
    public function destroy($id)
    {
        $inspection = Inspection::where('uuid', $id)->orWhere('id', $id)->firstOrFail();
        $inspection->delete();

        return response()->json([
            'message' => 'Inspection supprimée avec succès',
        ]);
    }
}
