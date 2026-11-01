<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use App\Models\Lecturer;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['CS101', 'Introduction to Programming & Algorithms', 'CS', 'LEC-CS-001', 3, 60, 'Computer Lab 2', 'Mon & Wed 09:00 - 11:00 AM'],
            ['CS201', 'Data Structures and Algorithms', 'CS', 'LEC-CS-001', 4, 50, 'Lecture Hall B3', 'Tue & Thu 11:00 AM - 01:00 PM'],
            ['CS305', 'Database Management Systems', 'CS', 'LEC-CS-002', 3, 45, 'Computer Lab 4', 'Wed & Fri 02:00 - 04:00 PM'],
            ['CS410', 'Advanced Web Applications & Frameworks', 'CS', 'LEC-CS-002', 4, 40, 'Software Innovation Lab', 'Tue & Thu 02:00 - 04:00 PM'],
            ['ENG110', 'Circuit Analysis and Network Theory', 'ENG', 'LEC-ENG-001', 3, 55, 'Engineering Hall E-04', 'Mon & Fri 10:00 AM - 12:00 PM'],
            ['BUS101', 'Principles of Business Management', 'BUS', null, 3, 70, 'Senate Auditorium', 'Thu 09:00 AM - 12:00 PM'],
        ];

        foreach ($courses as [$code, $title, $departmentCode, $staffId, $credits, $capacity, $room, $schedule]) {
            $lecturerId = $staffId === null
                ? null
                : Lecturer::where('staff_id', $staffId)->firstOrFail()->id;

            Course::updateOrCreate(
                ['code' => $code],
                [
                    'department_id' => Department::where('code', $departmentCode)->firstOrFail()->id,
                    'lecturer_id' => $lecturerId,
                    'title' => $title,
                    'description' => null,
                    'credits' => $credits,
                    'semester' => 'Semester 1',
                    'academic_year' => '2025/2026',
                    'max_capacity' => $capacity,
                    'room' => $room,
                    'schedule' => $schedule,
                ],
            );
        }
    }
}
