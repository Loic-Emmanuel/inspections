<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport d'Inspection - {{ $inspection->reference }}</title>
    <style>
        @page {
            margin: 20px 25px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e1b4b;
            text-transform: uppercase;
        }
        .header-meta {
            float: right;
            text-align: right;
            font-size: 11px;
            color: #6b7280;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-conforme {
            background-color: #dcfce7;
            color: #166534;
        }
        .badge-non-conforme {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .badge-partiel {
            background-color: #fef9c3;
            color: #854d0e;
        }
        .section {
            margin-bottom: 18px;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 6px 8px;
            vertical-align: top;
        }
        .info-label {
            font-weight: bold;
            color: #4b5563;
            width: 25%;
        }
        .info-val {
            color: #111827;
            width: 75%;
        }
        .text-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px 12px;
            white-space: pre-line;
            color: #374151;
        }
        .photos-grid {
            width: 100%;
        }
        .photo-card {
            display: inline-block;
            width: 48%;
            margin-right: 1.5%;
            margin-bottom: 12px;
            vertical-align: top;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
            background: #fff;
        }
        .photo-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }
        .photo-cat {
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            background: #f3f4f6;
            color: #4b5563;
            border-top: 1px solid #e5e7eb;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
            color: #9ca3af;
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td style="vertical-align: middle;">
                    <div class="header-title">Rapport d'Inspection</div>
                    <div style="font-size: 12px; color: #4f46e5; font-weight: bold;">Réf : {{ $inspection->reference }}</div>
                </td>
                <td class="header-meta" style="vertical-align: middle;">
                    <div>Date d'émission : {{ now()->format('d/m/Y') }}</div>
                    <div style="margin-top: 4px;">
                        @php
                            $st = strtolower($inspection->statut);
                            $badgeClass = 'badge-partiel';
                            if (str_contains($st, 'non')) {
                                $badgeClass = 'badge-non-conforme';
                            } elseif (str_contains($st, 'conforme')) {
                                $badgeClass = 'badge-conforme';
                            }
                        @endphp
                        Statut : <span class="badge {{ $badgeClass }}">{{ $inspection->statut }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Informations Générales -->
    <div class="section">
        <div class="section-title">Informations Générales</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Lieu d'inspection :</td>
                <td class="info-val">{{ $inspection->lieu ?: 'Non renseigné' }}</td>
            </tr>
            <tr>
                <td class="info-label">Responsable / Client :</td>
                <td class="info-val">{{ $inspection->client ?: 'Non renseigné' }}</td>
            </tr>
            <tr>
                <td class="info-label">Type d'intervention :</td>
                <td class="info-val">{{ $inspection->type ?: 'Inspection de contrôle' }}</td>
            </tr>
            <tr>
                <td class="info-label">Date de la visite :</td>
                <td class="info-val">{{ $inspection->date_inspection ? $inspection->date_inspection->format('d/m/Y') : '' }}</td>
            </tr>
            <tr>
                <td class="info-label">Inspecteur :</td>
                <td class="info-val">{{ $userName }}</td>
            </tr>
        </table>
    </div>

    <!-- Observations -->
    @if(!empty($inspection->description))
    <div class="section">
        <div class="section-title">Constats & Observations</div>
        <div class="text-box">{{ $inspection->description }}</div>
    </div>
    @endif

    <!-- Recommandations -->
    @if(!empty($inspection->recommandations))
    <div class="section">
        <div class="section-title">Recommandations & Mesures Correctives</div>
        <div class="text-box">{{ $inspection->recommandations }}</div>
    </div>
    @endif

    <!-- Galerie de photos -->
    @if($inspection->images && $inspection->images->count() > 0)
    <div class="section">
        <div class="section-title">Preuves Photographiques ({{ $inspection->images->count() }} cliché(s))</div>
        <div class="photos-grid">
            @foreach($inspection->images as $img)
                @php
                    $fullPath = storage_path('app/public/' . $img->image_path);
                @endphp
                @if(file_exists($fullPath))
                <div class="photo-card">
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($fullPath)) }}" alt="Photo">
                    <div class="photo-cat">Catégorie : {{ $img->categories ?: 'Général' }}</div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <div class="footer">
        Document officiel généré par le Système de Gestion d'Inspections - Tous droits réservés.
    </div>

</body>
</html>
