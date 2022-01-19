<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class ManageCoursesController extends Controller
{

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

        $user->courses()->toggle($course->id);

        return response()->json([
            'message' => 'Course added to the list.',
        ]);
    }
}
