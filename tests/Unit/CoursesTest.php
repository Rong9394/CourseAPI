<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Services\CourseService;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CoursesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        Course::factory()->count(100)->create();
    }

    public function test_getAllCourses() {
        $courses = (new CourseService)->getAllCourses();
        $this->assertEquals(100,count($courses));
    }

    public function test_findCourseById() {
        $course = (new CourseService)->findCourseById(100);
        $this->assertEquals(100,$course->id);
    }

    public function test_storeCourse() {
        (new CourseService)->storeCourse(
            [
                'title'=>'hello world',
                'description'=>'goodbye world',
                'price_in_cents_usd'=>99
            ]
        );

        $courses = (new CourseService)->getAllCourses();
        $this->assertEquals(101, count($courses));

        $new = (new CourseService)->findCourseById(101);
        $this->assertEquals('hello world', $new->title);
        
    }

    public function test_updateCourse() {
        (new CourseService)->updateCourse(100, 
            [
                'title'=>'hello world',
                'description'=>'goodbye world =(',
                'price_in_cents_usd'=>99
            ]
        );
        $new = (new CourseService)->findCourseById(100);
        $this->assertEquals('goodbye world =(', $new->description);  
    }

    public function test_deleteCourse() {
        (new CourseService)->deleteCourse(100);
        $courses = (new CourseService)->getAllCourses();
        $this->assertEquals(99, count($courses));
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        DB::table('courses')->truncate();
        parent::tearDown();
    }
}
