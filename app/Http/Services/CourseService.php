<?php

namespace App\Http\Services;

use App\Models\Course;

class CourseService {


    public function getAllCourses()
    {
        return Course::all();
    }

    public function findCourseById(string $id)
    {
        return Course::find($id);
    }

    public function storeCourse(array $validated) {
        return Course::create($validated);
    }

    public function updateCourse(string $id, array $validated) {
        $course = (new CourseService)->findCourseById($id);

        if($course!==null) {
            $course->fill($validated);
            $course->save();
        }
        return $course;
    }

    public function deleteCourse(string $id) {
        $course = $this->findCourseById($id);
        if($course===null) return 404;
        $course->delete();
        return 204;
    }
}
