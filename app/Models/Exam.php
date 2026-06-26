<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'start_time',
        'end_time',
        'question_count',
        'status',
        'created_by'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'exam_user');
    }

    /**
     * Courses this exam is assigned to. Any student actively enrolled in one of
     * these courses can take the exam (no need to pick students manually).
     */
    public function courses()
    {
        return $this->belongsToMany(Product::class, 'course_exam', 'exam_id', 'product_id');
    }

    /**
     * Scope: exams a given student is allowed to see/take.
     * Visible if directly assigned, OR enrolled in one of the exam's courses,
     * OR fully public (no assigned students AND no assigned courses).
     */
    public function scopeVisibleToStudent($query, $userId)
    {
        $enrolledCourseIds = \App\Models\Enrollment::where('user_id', $userId)
            ->where('status', 'active')
            ->pluck('product_id')
            ->filter()
            ->all();

        return $query->where(function ($q) use ($userId, $enrolledCourseIds) {
            $q->whereHas('students', function ($s) use ($userId) {
                $s->where('users.id', $userId);
            })->orWhereHas('courses', function ($c) use ($enrolledCourseIds) {
                $c->whereIn('products.id', $enrolledCourseIds ?: [0]);
            })->orWhere(function ($pub) {
                $pub->whereDoesntHave('students')->whereDoesntHave('courses');
            });
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
