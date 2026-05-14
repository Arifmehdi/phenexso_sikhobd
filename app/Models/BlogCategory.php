<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    public function blogSubcategories(){
        return $this->hasMany(BlogSubCategory::class);
    }

    // Changed from belongsToMany to hasMany based on category_id column in blog_posts table
    public function posts(){
        return $this->hasMany(BlogPost::class, 'category_id');
    }

}
