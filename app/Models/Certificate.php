<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'certificate_number',
        'user_id',
        'product_id',
        'enrollment_id',
        'final_score',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
