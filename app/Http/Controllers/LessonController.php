<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
        $modules = Module::with('lessons')->where('course_id', $course_id)->orderBy('position')->get();
        $previousLesson = $lesson->previowsLesson();
        $nextLesson = $lesson->nextLesson();
        return view('lessons.show', compact('modules', 'lesson', 'previousLesson', 'nextLesson'));
    }

    public function showLastWatched(Course $course)
    {
        $lesson = $course->lessons()->first();
        return redirect()->route('lessons.show', $lesson->id);
    }
}
