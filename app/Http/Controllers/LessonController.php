<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        $course_id = $lesson->module->course->id;
        $modules = Module::with('lessons')->where('course_id', $course_id)->get();

        return view('lessons.show', compact('lesson', 'modules'));
    }

    public function showLastWatched()
    {
        return redirect()->route('lessons.show', 1);
    }
}
