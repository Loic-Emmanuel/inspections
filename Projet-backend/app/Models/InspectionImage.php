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
        'categories',
        'commentaire'
    ];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        if (!$this->image_path) {
            return '';
        }
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }
        return asset('storage/' . $this->image_path);
    }

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
