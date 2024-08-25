<?php

namespace App\Http\Controllers;

use App\Helpers\LogAndFlash;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public $pagination = 15;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('modules', 'lessons')->paginate($this->pagination);
        return view('courses.index', compact('courses'));
    }
}
