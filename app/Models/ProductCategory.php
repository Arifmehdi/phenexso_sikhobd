<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductCategory extends Model
{
    use HasFactory;


    public function fi()
    {
        return $this->image ?: 'not_found.png';
    }

    /**
     * Get the full URL for the category image.
     */
    public function getFiUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/product_categories_images/' . $this->image);
        }
        return asset('img/not_found.png');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class , 'product_cats' , 'product_category_id' , 'product_id');
    }

    // A category can have many subcategories
    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    // A subcategory belongs to one parent category
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }
    
}