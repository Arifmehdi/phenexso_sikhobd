<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_name',
        'featured_image',
        'file_type',
        'priority',
        'thumbnail_image',
        'active',
        'addedby_id',
        'editedby_id',
    ];

    public function fi()
    {
        return $this->thumbnail_image ?: 'fi.jpg';
    }

    public function getFiUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/galleries/' . $this->featured_image);
        }
        return asset('img/not_found.png');
    }
}
