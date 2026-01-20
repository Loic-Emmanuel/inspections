<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rapport extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'inspection_id',
        'fichier_path',
        'format',
        'date_generation'
    ];

    protected $casts = [
        'date_generation' => 'datetime'
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
