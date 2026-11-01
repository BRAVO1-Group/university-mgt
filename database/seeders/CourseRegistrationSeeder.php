<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use Illuminate\Database\Seeder;

class CourseRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $registrations = [
            ['STU-2025-001', 'CS101'],
            ['STU-2025-001', 'CS201'],
            ['STU-2025-001', 'CS305'],
            ['STU-2025-002', 'CS101'],
            ['STU-2025-002', 'CS410'],
            ['STU-2024-045', 'ENG110'],
        ];

        foreach ($registrations as [$studentNumber, $courseCode]) {
            CourseRegistration::firstOrCreate(
                [
                    'student_id' => Student::where('student_id_number', $studentNumber)->firstOrFail()->id,
                    'course_id' => Course::where('code', $courseCode)->firstOrFail()->id,
                    'academic_year' => '2025/2026',
                    'semester' => 'Semester 1',
                ],
                ['status' => 'registered'],
            );
        }
    }
}
