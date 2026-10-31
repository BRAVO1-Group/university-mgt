<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'department_id',
        'lecturer_id',
        'code',
        'title',
        'description',
        'credits',
        'semester',
        'academic_year',
        'max_capacity',
        'room',
        'schedule',
    ];

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return BelongsTo<Lecturer, $this>
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    /**
     * @return HasMany<CourseRegistration, $this>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }

    /**
     * @return HasManyThrough<Student, CourseRegistration, $this>
     */
    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,
            CourseRegistration::class,
            'course_id',
            'id',
            'id',
            'student_id'
        );
    }

    public function enrolledCount(): int
    {
        return $this->registrations()->where('status', 'registered')->count();
    }

    public function isFull(): bool
    {
        return $this->enrolledCount() >= $this->max_capacity;
    }
}
