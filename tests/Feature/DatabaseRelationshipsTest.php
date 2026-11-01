<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\UniversitySeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UniversitySeeder::class);
    }

    public function test_all_model_relationships_resolve_seeded_records(): void
    {
        $student = Student::where('student_id_number', 'STU-2025-001')->firstOrFail();
        $lecturer = Lecturer::where('staff_id', 'LEC-CS-001')->firstOrFail();
        $course = Course::where('code', 'CS101')->firstOrFail();
        $registration = CourseRegistration::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->firstOrFail();
        $department = Department::where('code', 'CS')->firstOrFail();

        $this->assertSame($student->id, $student->user->student->id);
        $this->assertSame($student->id, $student->department->students->firstWhere('id', $student->id)->id);
        $this->assertTrue($student->courseRegistrations->contains('id', $registration->id));
        $this->assertTrue($student->courses->contains('id', $course->id));
        $this->assertSame($course->id, $registration->course->id);
        $this->assertSame($student->id, $registration->student->id);

        $this->assertSame($lecturer->id, $lecturer->user->lecturer->id);
        $this->assertSame($department->id, $lecturer->department->id);
        $this->assertTrue($lecturer->courses->contains('id', $course->id));

        $this->assertSame($department->id, $course->department->id);
        $this->assertSame($lecturer->id, $course->lecturer->id);
        $this->assertTrue($course->registrations->contains('id', $registration->id));
        $this->assertTrue($course->students->contains('id', $student->id));
        $this->assertTrue($department->lecturers->contains('id', $lecturer->id));
        $this->assertTrue($department->courses->contains('id', $course->id));

        $this->assertSame('admin', User::where('role', 'admin')->firstOrFail()->role);
    }

    public function test_database_rejects_duplicate_registration_for_the_same_course_term(): void
    {
        $student = Student::where('student_id_number', 'STU-2025-001')->firstOrFail();
        $course = Course::where('code', 'CS101')->firstOrFail();

        $this->expectException(QueryException::class);

        CourseRegistration::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'academic_year' => '2025/2026',
            'semester' => 'Semester 1',
            'status' => 'registered',
        ]);
    }

    public function test_university_seeder_is_repeatable_and_meets_minimum_data_requirements(): void
    {
        $countsBefore = [
            User::count(),
            Student::count(),
            Lecturer::count(),
            Course::count(),
            CourseRegistration::count(),
        ];

        $this->seed(UniversitySeeder::class);

        $this->assertSame($countsBefore, [
            User::count(),
            Student::count(),
            Lecturer::count(),
            Course::count(),
            CourseRegistration::count(),
        ]);
        $this->assertGreaterThanOrEqual(5, Student::count());
        $this->assertGreaterThanOrEqual(4, Course::count());
        $this->assertDatabaseHas('users', ['email' => 'admin@university.ac.ug', 'role' => 'admin']);
    }
}
