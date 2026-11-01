<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UniversitySeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniversityPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            RoleSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            UniversitySeeder::class,
        ]);
    }

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('University Academic & Course');
        $response->assertSee('CS101');
    }

    public function test_users_from_user_seeder_can_login_to_appropriate_portals(): void
    {
        // Admin login
        $response = $this->post(route('login.post'), [
            'email' => 'admin@gmail.com',
            'password' => 'Admin123',
        ]);
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();

        $this->post(route('logout'));
        $this->assertGuest();

        // Lecturer login
        $response = $this->post(route('login.post'), [
            'email' => 'lecturer@gmail.com',
            'password' => 'Lecturer123',
        ]);
        $response->assertRedirect(route('lecturer.dashboard'));
        $this->assertAuthenticated();

        $this->post(route('logout'));
        $this->assertGuest();

        // Student login
        $response = $this->post(route('login.post'), [
            'email' => 'student@gmail.com',
            'password' => 'Student123',
        ]);
        $response->assertRedirect(route('student.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_admin_can_access_dashboard_and_manage_records(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Academic Administration Dashboard');
        $response->assertSee('Recent Course Registrations');

        // Test students management
        $response = $this->actingAs($admin)->get(route('admin.students.index'));
        $response->assertStatus(200);
        $response->assertSee('Student Records Management');

        // Test creating student
        $dept = Department::first();
        $createResponse = $this->actingAs($admin)->post(route('admin.students.store'), [
            'name' => 'New Student Test',
            'email' => 'newstudent@test.com',
            'password' => 'secret123',
            'student_id_number' => 'STU-TEST-999',
            'department_id' => $dept->id,
            'program' => 'BSc Computer Science',
            'year_of_study' => 1,
            'phone' => '+256 700 999 888',
        ]);
        $createResponse->assertRedirect(route('admin.students.index'));
        $this->assertDatabaseHas('users', ['email' => 'newstudent@test.com']);
        $this->assertDatabaseHas('students', ['student_id_number' => 'STU-TEST-999']);

        // Test courses management
        $response = $this->actingAs($admin)->get(route('admin.courses.index'));
        $response->assertStatus(200);
        $response->assertSee('Course Curriculum & Catalog');

        // Test creating course
        $lec = Lecturer::first();
        $createCourseResponse = $this->actingAs($admin)->post(route('admin.courses.store'), [
            'code' => 'TEST999',
            'title' => 'Advanced Robotics',
            'department_id' => $dept->id,
            'lecturer_id' => $lec->id,
            'credits' => 4,
            'semester' => 'Semester 1',
            'academic_year' => '2025/2026',
            'max_capacity' => 45,
            'room' => 'Lab 9',
            'schedule' => 'Mon 10:00 - 12:00',
            'description' => 'Test course description',
        ]);
        $createCourseResponse->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseHas('courses', ['code' => 'TEST999']);
    }

    public function test_lecturer_can_view_assigned_courses_and_roster(): void
    {
        $lecturerUser = User::where('email', 'prof.smith@university.ac.ug')->first();
        $lecturer = $lecturerUser->lecturer;

        $response = $this->actingAs($lecturerUser)->get(route('lecturer.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Lecturer Academic Portal');
        $response->assertSee('Prof. Alan Smith');

        $coursesResponse = $this->actingAs($lecturerUser)->get(route('lecturer.courses'));
        $coursesResponse->assertStatus(200);
        $coursesResponse->assertSee('My Assigned Courses');

        // Check course roster for an assigned course
        $course = Course::where('lecturer_id', $lecturer->id)->first();
        $rosterResponse = $this->actingAs($lecturerUser)->get(route('lecturer.courses.students', $course));
        $rosterResponse->assertStatus(200);
        $rosterResponse->assertSee('Class Roster: '.$course->code);

        // Grade submission
        $registration = CourseRegistration::where('course_id', $course->id)->first();
        if ($registration) {
            $gradeResponse = $this->actingAs($lecturerUser)->put(route('lecturer.courses.students.grade', [$course, $registration]), [
                'grade' => 'A',
                'status' => 'completed',
            ]);
            $gradeResponse->assertRedirect();
            $this->assertDatabaseHas('course_registrations', [
                'id' => $registration->id,
                'grade' => 'A',
                'status' => 'completed',
            ]);
        }
    }

    public function test_student_can_view_courses_register_and_view_registrations(): void
    {
        $studentUser = User::where('email', 'alex.kamau@student.ac.ug')->first();

        // Dashboard
        $response = $this->actingAs($studentUser)->get(route('student.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Student Academic Portal');
        $response->assertSee('My Registered Courses');

        // Course catalog
        $catalogResponse = $this->actingAs($studentUser)->get(route('student.courses'));
        $catalogResponse->assertStatus(200);
        $catalogResponse->assertSee('Course Registration Catalog');

        // Register for an unregistered course
        $unregisteredCourse = Course::whereDoesntHave('registrations', function ($q) use ($studentUser) {
            $q->where('student_id', $studentUser->student->id);
        })->first();

        if ($unregisteredCourse) {
            $registerResponse = $this->actingAs($studentUser)->post(route('student.courses.register'), [
                'course_id' => $unregisteredCourse->id,
            ]);
            $registerResponse->assertRedirect();
            $this->assertDatabaseHas('course_registrations', [
                'student_id' => $studentUser->student->id,
                'course_id' => $unregisteredCourse->id,
                'status' => 'registered',
            ]);
        }

        // View registrations
        $myRegistrationsResponse = $this->actingAs($studentUser)->get(route('student.registrations'));
        $myRegistrationsResponse->assertStatus(200);
        $myRegistrationsResponse->assertSee('My Course Registrations');
        $myRegistrationsResponse->assertSee('Current Semester Credit Load');

        // Drop a registered course
        $reg = CourseRegistration::where('student_id', $studentUser->student->id)
            ->where('status', 'registered')
            ->first();

        $dropResponse = $this->actingAs($studentUser)->delete(route('student.registrations.drop', $reg));
        $dropResponse->assertRedirect();
        $this->assertDatabaseHas('course_registrations', [
            'id' => $reg->id,
            'status' => 'dropped',
        ]);
    }

    public function test_students_cannot_access_admin_portal(): void
    {
        $studentUser = User::where('email', 'alex.kamau@student.ac.ug')->first();

        $response = $this->actingAs($studentUser)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }
}
