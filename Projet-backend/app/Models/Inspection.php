<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'user_id',
        'reference',
        'client',
        'date_inspection',
        'lieu',
        'type',
        'description',
        'statut'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
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
