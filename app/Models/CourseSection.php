<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title_en',
        'title_bn',
        'priority',
        'active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function lessons()
    {
        return $this->hasMany(CourseLesson::class)->orderBy('priority');
    }
}
