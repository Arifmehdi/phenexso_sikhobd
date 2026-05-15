<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title_en',
        'title_bn',
        'description',
        'video_provider',
        'video_url',
        'duration',
        'priority',
        'is_free',
        'active',
        'addedby_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
