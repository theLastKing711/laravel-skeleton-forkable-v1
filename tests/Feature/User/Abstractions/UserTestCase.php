<?php

namespace Tests\Feature\Student\Abstractions;

use App\Helpers\RotueBuilder\RouteBuilder;
use App\Models\User;
use Database\Seeders\AcademicYearSemesterSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\DepartmentRegisterationPeriodSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\OpenCourseRegisterationSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\TeacherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTestCase extends TestCase
{
    use RefreshDatabase;

    public User $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->route_builder =
                RouteBuilder::withMainRoute('users');

        $this->seed(
            [
                // AcademicYearSemesterSeeder::class,
                RolesAndPermissionsSeeder::class,
                // DepartmentSeeder::class,
                // TeacherSeeder::class,
                // CourseSeeder::class,
                // OpenCourseRegisterationSeeder::class,
                // StudentSeeder::class,
                // DepartmentRegisterationPeriodSeeder::class,
            ]
        );

        // $this->createStudent();

        // $this->actingAs($this->student);
    }

    // private function createStudent(): void
    // {
    //     $this->student =
    //         User::query()
    //             ->has(relation: 'courses', operator: '>', count: 1)
    //             ->has('studentCourseRegisterations')
    //             ->first();
    // }

    public function getUser(): User
    {
        return
            User::factory()
                ->staticUser()
                ->create();

    }
}
