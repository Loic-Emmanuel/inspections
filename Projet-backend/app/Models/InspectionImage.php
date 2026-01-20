<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionImage extends Model
{
    use SoftDeletes;

     protected $fillable = [
        'inspection_id',
        'image_path',
        'commentaire'
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
