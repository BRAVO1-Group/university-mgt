<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return BelongsToMany<Student, $this>
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_registrations')
            ->withPivot(['id', 'semester', 'academic_year', 'status', 'grade'])
            ->withTimestamps();
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
