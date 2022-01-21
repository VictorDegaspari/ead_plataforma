<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Course as CourseResource;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with([
            'users' => function ($user) {
                $user->where('id', '=', auth()->user()->id);
            },
            'categories'
        ])->paginate(15);

        return $this->sendResponse($courses, 'Courses retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required',
            'url' => 'required',
            'time' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $course = Course::create($input);
        $userId = auth()->user()->id;

        $course->users()->attach($userId, [ 'admin' => true ]);
        $course->categories()->attach($request[ 'categoryId' ]);

        return $this->sendResponse(new CourseResource($course), 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with([ 'categories' ])
        ->where('id', $id)
        ->first();

        if (is_null($course)) {
            return $this->sendError('Course not found.');
        }

        return $this->sendResponse($course, 'Course retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $input = $request->all();

        $category = Category::find($request[ 'categoryId' ]);

        if (is_null($category) && !empty($input[ 'categoryId' ]) ) {
            return $this->sendError('Category not found.');
        }
        $course->categories()->attach($category->id);

        if (!empty($input[ 'detail' ]) ) $course->detail = $input['detail'];
        if (!empty($input[ 'name' ]) ) $course->name = $input['name'];
        if (!empty($input[ 'time' ]) ) $course->time = $input['time'];
        if (!empty($input[ 'url' ]) ) $course->url = $input['url'];
        if (!empty($input[ 'price' ]) ) $course->price = $input['price'];

        $course->save();

        return $this->sendResponse($course, 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $user = Auth::user();

        $category_id = DB::table('categories_courses')
            ->select('categories_id')
            ->where('courses_id', $course->id)
            ->first();

        if (isset($category_id->categories_id)) {
            $category = Category::find($category_id->categories_id);
            $category->courses()->detach($course->id);
        }

        $user->courses()->detach($course->id);

        $course->delete();
        return $this->sendResponse([], 'Course deleted');


    }

}
