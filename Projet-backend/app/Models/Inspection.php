<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'reference',
        'user_id',
        'client_id',
        'client',
        'date_inspection',
        'lieu',
        'type',
        'description',
        'recommandations',
        'statut'
    ];

    protected $casts = [
        'date_inspection' => 'date',
    ];

    public function clientEntity()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function inspecteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(InspectionImage::class);
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class);
    }
}
