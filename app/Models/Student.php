<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'student_id_number',
        'program',
        'year_of_study',
        'status',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return HasMany<CourseRegistration, $this>
     */
    public function courseRegistrations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }

    /**
     * @return HasManyThrough<Course, CourseRegistration, $this>
     */
    public function courses(): HasManyThrough
    {
        return $this->hasManyThrough(
            Course::class,
            CourseRegistration::class,
            'student_id', // Foreign key on course_registrations table...
            'id', // Foreign key on courses table...
            'id', // Local key on students table...
            'course_id' // Local key on course_registrations table...
        );
    }
}
