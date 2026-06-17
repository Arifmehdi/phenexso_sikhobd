<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'user_id', 'product_id', 'ebook_id', 'quantity', 'product_price', 'product_name', 'total_cost', 'addedby_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }
}