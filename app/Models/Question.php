<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'explanation',
        'created_by',
        'product_id',
        'course_lesson_id',
    ];

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }

    /** The course this question belongs to (optional). */
    public function course()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /** The class (course lesson) this question belongs to (optional). */
    public function lesson()
    {
        return $this->belongsTo(CourseLesson::class, 'course_lesson_id');
    }

    /** Scope: questions tagged to a given course. */
    public function scopeForCourse($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /** Scope: questions tagged to a given class (lesson). */
    public function scopeForLesson($query, $lessonId)
    {
        return $query->where('course_lesson_id', $lessonId);
    }
}
