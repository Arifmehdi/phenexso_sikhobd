<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title_en',
        'title_bn',
        'author_name',
        'description_en',
        'description_bn',
        'price',
        'discount',
        'is_free',
        'preview_pages',
        'cover_image',
        'file_path',
        'preview_path',
        'status',
        'active',
        'view_count',
    ];

    protected $casts = [
        'is_free' => 'boolean',
    ];

    public function isFree()
    {
        return (bool) $this->is_free;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function getFinalPriceAttribute()
    {
        return $this->price - $this->discount;
    }
}
