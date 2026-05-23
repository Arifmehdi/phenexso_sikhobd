<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'course_section_id',
        'title_en',
        'title_bn',
        'description',
        'video_provider',
        'video_url',
        'pdf_url',
        'audio_url',
        'video_file',
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

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    public function completions()
    {
        return $this->hasMany(LessonCompletion::class);
    }

    public function isCompletedBy($user)
    {
        if (!$user) return false;
        return $this->completions()->where('user_id', $user->id)->exists();
    }
}
