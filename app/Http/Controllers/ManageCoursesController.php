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
        $alreadyLiked = DB::table('courses_users')
            ->where([
                [ 'users_id', '=', $user->id ],
                [ 'courses_id', '=', $course->id ]
            ])
            ->count();

        if ($alreadyLiked > 0) {

            $user->courses()->detach($course->id);

            return response()->json([
                'message' => 'Course removed from the list.',
            ]);
        }
        // attach a single course from the user...
        $user->courses()->attach($course->id);

        return response()->json([
            'message' => 'Course added to the list.',
        ]);
    }
}
