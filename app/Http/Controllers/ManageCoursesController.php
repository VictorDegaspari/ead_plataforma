<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class ManageCoursesController extends Controller
{

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detachCourse(Request $request)
    {
        $course = Course::find($request['courseId']);

        if (is_null($course)) {
            return $this->sendError('Course not found.');
        }

        $user = auth()->user();

        $request['all'] ? $user->courses()->detach() : $user->courses()->detach($course->id);

        return response()->json([
            'message' => 'Course(s) removed from the list.',
        ]);

    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function attachCourse(Request $request)
    {
        $course = Course::find($request['courseId']);

        if (is_null($course)) {
            return $this->sendError('Course not found.');
        }

        $user = auth()->user();

        // attach a single course from the user...
        $user->courses()->attach($course->id);

        return response()->json([
            'message' => 'Course added to the list.',
        ]);
    }
}
