<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@university.ac.ug'],
            [
                'name' => 'Dean of Academics (Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+256 700 111 222',
            ]
        );

        // 2. Create Departments
        $csDept = Department::firstOrCreate(
            ['code' => 'CS'],
            [
                'name' => 'Computer Science & Software Engineering',
                'description' => 'Department of Computing, Information Technology, and Artificial Intelligence.',
                'building' => 'Block C, Technology Wing, 3rd Floor',
            ]
        );

        $engDept = Department::firstOrCreate(
            ['code' => 'ENG'],
            [
                'name' => 'Electrical & Electronic Engineering',
                'description' => 'Department for Power Systems, Electronics, and Telecommunications.',
                'building' => 'Engineering Complex, Level 1',
            ]
        );

        $busDept = Department::firstOrCreate(
            ['code' => 'BUS'],
            [
                'name' => 'Business Administration & Management',
                'description' => 'School of Business, Finance, Accounting, and Strategic Management.',
                'building' => 'Senate House, Ground Floor',
            ]
        );

        // 3. Create Lecturers
        $lecturerUser1 = User::firstOrCreate(
            ['email' => 'prof.smith@university.ac.ug'],
            [
                'name' => 'Prof. Alan Smith',
                'password' => Hash::make('password'),
                'role' => 'lecturer',
                'phone' => '+256 701 223 344',
            ]
        );
        $lec1 = Lecturer::firstOrCreate(
            ['user_id' => $lecturerUser1->id],
            [
                'department_id' => $csDept->id,
                'staff_id' => 'LEC-CS-001',
                'title' => 'Prof.',
                'qualification' => 'PhD in Computer Science (MIT)',
                'office_location' => 'Block C, Room 304',
            ]
        );

        $lecturerUser2 = User::firstOrCreate(
            ['email' => 'dr.muwanga@university.ac.ug'],
            [
                'name' => 'Dr. Peter Muwanga',
                'password' => Hash::make('password'),
                'role' => 'lecturer',
                'phone' => '+256 702 334 455',
            ]
        );
        $lec2 = Lecturer::firstOrCreate(
            ['user_id' => $lecturerUser2->id],
            [
                'department_id' => $csDept->id,
                'staff_id' => 'LEC-CS-002',
                'title' => 'Dr.',
                'qualification' => 'PhD in Software Engineering (Oxford)',
                'office_location' => 'Block C, Room 310',
            ]
        );

        $lecturerUser3 = User::firstOrCreate(
            ['email' => 'dr.sarah@university.ac.ug'],
            [
                'name' => 'Dr. Sarah Namutebi',
                'password' => Hash::make('password'),
                'role' => 'lecturer',
                'phone' => '+256 703 445 566',
            ]
        );
        $lec3 = Lecturer::firstOrCreate(
            ['user_id' => $lecturerUser3->id],
            [
                'department_id' => $engDept->id,
                'staff_id' => 'LEC-ENG-001',
                'title' => 'Dr.',
                'qualification' => 'PhD in Electrical Engineering (Stanford)',
                'office_location' => 'Engineering Complex, Room E-12',
            ]
        );

        // 4. Create Students
        $studentUser1 = User::firstOrCreate(
            ['email' => 'alex.kamau@student.ac.ug'],
            [
                'name' => 'Alex Kamau',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '+256 771 998 811',
            ]
        );
        $stu1 = Student::firstOrCreate(
            ['user_id' => $studentUser1->id],
            [
                'department_id' => $csDept->id,
                'student_id_number' => 'STU-2025-001',
                'program' => 'BSc Computer Science',
                'year_of_study' => 2,
                'status' => 'active',
            ]
        );

        $studentUser2 = User::firstOrCreate(
            ['email' => 'grace.nakato@student.ac.ug'],
            [
                'name' => 'Grace Nakato',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '+256 772 887 722',
            ]
        );
        $stu2 = Student::firstOrCreate(
            ['user_id' => $studentUser2->id],
            [
                'department_id' => $csDept->id,
                'student_id_number' => 'STU-2025-002',
                'program' => 'BSc Software Engineering',
                'year_of_study' => 1,
                'status' => 'active',
            ]
        );

        $studentUser3 = User::firstOrCreate(
            ['email' => 'john.okello@student.ac.ug'],
            [
                'name' => 'John Okello',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '+256 773 776 633',
            ]
        );
        $stu3 = Student::firstOrCreate(
            ['user_id' => $studentUser3->id],
            [
                'department_id' => $engDept->id,
                'student_id_number' => 'STU-2024-045',
                'program' => 'BSc Electrical Engineering',
                'year_of_study' => 3,
                'status' => 'active',
            ]
        );

        $studentUser4 = User::firstOrCreate(
            ['email' => 'mary.atuhairwe@student.ac.ug'],
            [
                'name' => 'Mary Atuhairwe',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '+256 774 665 544',
            ]
        );
        $stu4 = Student::firstOrCreate(
            ['user_id' => $studentUser4->id],
            [
                'department_id' => $busDept->id,
                'student_id_number' => 'STU-2025-089',
                'program' => 'Bachelor of Business Administration',
                'year_of_study' => 2,
                'status' => 'active',
            ]
        );

        // 5. Create Courses
        $c1 = Course::firstOrCreate(
            ['code' => 'CS101'],
            [
                'department_id' => $csDept->id,
                'lecturer_id' => $lec1->id,
                'title' => 'Introduction to Programming & Algorithms',
                'description' => 'Fundamental concepts of structured programming, problem solving, algorithms, and data types.',
                'credits' => 3,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
                'max_capacity' => 60,
                'room' => 'Computer Lab 2',
                'schedule' => 'Mon & Wed 09:00 - 11:00 AM',
            ]
        );

        $c2 = Course::firstOrCreate(
            ['code' => 'CS201'],
            [
                'department_id' => $csDept->id,
                'lecturer_id' => $lec1->id,
                'title' => 'Data Structures and Algorithms',
                'description' => 'Arrays, linked lists, stacks, queues, trees, graphs, sorting and searching techniques with complexity analysis.',
                'credits' => 4,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
                'max_capacity' => 50,
                'room' => 'Lecture Hall B3',
                'schedule' => 'Tue & Thu 11:00 AM - 01:00 PM',
            ]
        );

        $c3 = Course::firstOrCreate(
            ['code' => 'CS305'],
            [
                'department_id' => $csDept->id,
                'lecturer_id' => $lec2->id,
                'title' => 'Database Management Systems',
                'description' => 'Relational algebra, SQL, normalization, transactions, query optimization and database design.',
                'credits' => 3,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
                'max_capacity' => 45,
                'room' => 'Computer Lab 4',
                'schedule' => 'Wed & Fri 02:00 - 04:00 PM',
            ]
        );

        $c4 = Course::firstOrCreate(
            ['code' => 'CS410'],
            [
                'department_id' => $csDept->id,
                'lecturer_id' => $lec2->id,
                'title' => 'Advanced Web Applications & Frameworks',
                'description' => 'Modern full-stack web engineering, RESTful APIs, MVC architecture, security, and authentication.',
                'credits' => 4,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
                'max_capacity' => 40,
                'room' => 'Software Innovation Lab',
                'schedule' => 'Tue & Thu 02:00 - 04:00 PM',
            ]
        );

        $c5 = Course::firstOrCreate(
            ['code' => 'ENG110'],
            [
                'department_id' => $engDept->id,
                'lecturer_id' => $lec3->id,
                'title' => 'Circuit Analysis and Network Theory',
                'description' => 'Ohm and Kirchhoff laws, AC/DC circuit analysis, nodal analysis, and operational amplifiers.',
                'credits' => 3,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
                'max_capacity' => 55,
                'room' => 'Engineering Hall E-04',
                'schedule' => 'Mon & Fri 10:00 AM - 12:00 PM',
            ]
        );

        $c6 = Course::firstOrCreate(
            ['code' => 'BUS101'],
            [
                'department_id' => $busDept->id,
                'lecturer_id' => null,
                'title' => 'Principles of Business Management',
                'description' => 'Organizational leadership, business ethics, project planning, and operations management.',
                'credits' => 3,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
                'max_capacity' => 70,
                'room' => 'Senate Auditorium',
                'schedule' => 'Thu 09:00 AM - 12:00 PM',
            ]
        );

        // 6. Create Course Registrations
        CourseRegistration::firstOrCreate(
            [
                'student_id' => $stu1->id,
                'course_id' => $c1->id,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
            ],
            [
                'status' => 'registered',
            ]
        );

        CourseRegistration::firstOrCreate(
            [
                'student_id' => $stu1->id,
                'course_id' => $c2->id,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
            ],
            [
                'status' => 'registered',
            ]
        );

        CourseRegistration::firstOrCreate(
            [
                'student_id' => $stu1->id,
                'course_id' => $c3->id,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
            ],
            [
                'status' => 'registered',
            ]
        );

        CourseRegistration::firstOrCreate(
            [
                'student_id' => $stu2->id,
                'course_id' => $c1->id,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
            ],
            [
                'status' => 'registered',
            ]
        );

        CourseRegistration::firstOrCreate(
            [
                'student_id' => $stu2->id,
                'course_id' => $c4->id,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
            ],
            [
                'status' => 'registered',
            ]
        );

        CourseRegistration::firstOrCreate(
            [
                'student_id' => $stu3->id,
                'course_id' => $c5->id,
                'semester' => 'Semester 1',
                'academic_year' => '2025/2026',
            ],
            [
                'status' => 'registered',
            ]
        );
    }
}
