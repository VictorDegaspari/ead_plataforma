<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageCoursesController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detachCourse($courseId)
    {
        $course = Course::find($id);

        if (is_null($course)) {
            return $this->sendError('Course not found.');
        }

        $user = auth()->user();

        // Detach a single course from the user...
        $user->roles()->detach($courseId);

        // Detach all courses from the user...
        $user->roles()->detach();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attachCourse($courseId)
    {
        $course = Course::find($id);

        if (is_null($course)) {
            return $this->sendError('Course not found.');
        }

        $user = auth()->user();

        // attach a single course from the user...
        $user->courses()->attach($courseId);

    }
}
