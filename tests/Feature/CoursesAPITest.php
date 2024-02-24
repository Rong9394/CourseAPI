<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Course;

// See: https://laravel.com/docs/10.x/http-tests

// Some possibly helpful functions:

// assertHeader: https://laravel.com/docs/10.x/http-tests#assert-header
// assertJson: https://laravel.com/docs/10.x/http-tests#assert-json
// assertNoContent: https://laravel.com/docs/10.x/http-tests#assert-no-content

class CoursesAPITest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        Course::factory()->count(100)->create();
    }

    public function test_get_courses()
    {
        $response = $this->get('http://localhost:8000/api/courses');
        $response->assertStatus(200);
        $response->assertHeader('Access-Control-Allow-Origin', 'http://localhost:8080');
    }

    public function test_get_courses_json_structure()
    {
        $response = $this->get('http://localhost:8000/api/courses');
        $response->assertJsonStructure([
            'courses' => [
                '*' => [
                    "id",
                    "title",
                    "description",
                    "price_in_cents_usd",
                    "created_at",
                    "updated_at"
                ]
            ]
        ]);
    }

    public function test_get_course_by_id_success()
    {
        $response = $this->get('http://localhost:8000/api/courses/50');
        $response->assertStatus(200);
    }

    public function test_get_course_by_id_json_structure()
    {
        $response = $this->get('http://localhost:8000/api/courses/50');
        $response->assertJsonStructure([
            'course' => [
                "id",
                "title",
                "description",
                "price_in_cents_usd",
                "created_at",
                "updated_at"
            ]
        ]);
    }

    public function test_get_course_by_id_404_failure()
    {
        $response = $this->get('http://localhost:8000/api/courses/99999');
        $response->assertNoContent($status = 404);
    }

    public function test_post_courses_success()
    {
        $response = $this->post('http://localhost:8000/api/courses',
        [
            "title" => "hello",
            "description" => "world",
            "price_in_cents_usd" => 100,
        ]);
        $response->assertStatus(201);
    }

    public function test_post_courses_json_structure()
    {
        $response = $this->post('http://localhost:8000/api/courses',
        [
            "title" => "hello",
            "description" => "world",
            "price_in_cents_usd" => 100,
        ]);
        $response->assertJsonStructure([
            'course' => [
                "id",
                "title",
                "description",
                "price_in_cents_usd",
                "created_at",
                "updated_at"
            ]
        ]);
    }

    public function test_post_courses_invalid_reqeust_params()
    {
        $response = $this->post('http://localhost:8000/api/courses',
        [
            "title" => 123,
            "description" => 123,
            "price_in_cents_usd" => 'hey',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title','description',"price_in_cents_usd"], 'errors');
    }

    public function test_put_courses_success_by_id_success()
    {
        $response = $this->put('http://localhost:8000/api/courses/50',
        [
            "title" => "changed",
            "description" => "changed",
            "price_in_cents_usd" => 123,
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'course' => [
                "id",
                "title",
                "description",
                "price_in_cents_usd",
                "created_at",
                "updated_at"
            ]
        ]);
    }

    public function test_put_courses_success_by_id_404_failure()
    {
        $response = $this->put('http://localhost:8000/api/courses/9999',
        [
            "title" => "changed",
            "description" => "changed",
            "price_in_cents_usd" => 123,
        ]);
        $response->assertNoContent($status = 404);
    }

    public function test_put_courses_success_by_id_invalid_request_params()
    {
        $response = $this->put('http://localhost:8000/api/courses/9999',
        [
            "title" => 123,
            "description" => 123,
            "price_in_cents_usd" => 'hey',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title','description',"price_in_cents_usd"], 'errors');
    }

    public function test_delete_courses_success()
    {
        $response = $this->delete('http://localhost:8000/api/courses/50');
        $response->assertNoContent($status = 204);
    }

    public function test_delete_courses_404_failure()
    {
        $response = $this->delete('http://localhost:8000/api/courses/9999');
        $response->assertNoContent($status = 404);
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        DB::table('courses')->truncate();
        parent::tearDown();
    }
}
