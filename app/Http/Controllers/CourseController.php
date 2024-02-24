<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Services\CourseService;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

class CourseController extends Controller
{

    /**
     * Display a listing of the courses.
     *
     * @return JsonResponse course listing and 200 on success
     */
    #[OpenApi\Operation]
    public function index(): JsonResponse
    {
        return response()->json(['courses' => (new CourseService)->getAllCourses()], 200);
    }

    /**
     * Display a specific course by ID.
     *
     * @param Course id of the target course
     * @return JsonResponse course and 200 on success
     */
    #[OpenApi\Operation]
    public function show(string $course): JsonResponse|Response
    {
        $result = (new CourseService)->findCourseById($course);
        return $result? response()->json(['course' => $result], 200) : (new Response)->setStatusCode(404);
    }

    /**
     * Store a newly created course in database.
     *
     * @param StoreCourseRequest request with title, description, price_in_cents_usd
     * @return JsonResponse course on success, 404 or not found, 422 on invalid request data
     */
    #[OpenApi\Operation]
    public function store(StoreCourseRequest $request): JsonResponse
    {
        $course = (new CourseService)->storeCourse($request->validated());
        return response()->json(['course' => $course],201);
    }

    /**
     * Update the specified course in storage.
     *
     * @param UpdateCourseRequest request with title, description, price_in_cents_usd
     * @return JsonResponse course on success, 404 or not found, 422 on invalid request data
     */
    #[OpenApi\Operation]
    public function update(UpdateCourseRequest $request, string $course): JsonResponse|Response
    {
        $result = (new CourseService)->updateCourse($course, $request->validated());
        if($result===null) return (new Response)->setStatusCode(404);
        return response()->json(['course' => $result],200);
    }

    /**
     * Remove the specified course from storage.
     *
     * @param Course id of target course
     * @return Response 204 on success, 404 on not found
     */
    #[OpenApi\Operation]
    public function destroy(string $course): Response
    {
        $code = (new CourseService)->deleteCourse($course);
        return (new Response)->setStatusCode($code);
    }
}
