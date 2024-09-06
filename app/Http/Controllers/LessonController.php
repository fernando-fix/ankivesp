<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Watched;
use Illuminate\Support\Facades\Auth;

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
        $watchedLesson = Watched::where('user_id', Auth::user()->id)->where('lesson_id', $lesson->id)->first() ?? null;
        return view('lessons.show', compact('modules', 'lesson', 'previousLesson', 'nextLesson', 'watchedLesson'));
    }

    public function showLastWatched(Course $course)
    {
        $lessons = $course->lessons;
        $lastWatchedLessonId = Watched::where('user_id', Auth::user()->id)->pluck('lesson_id')->last();
        if (!$lastWatchedLessonId) {
            $lastWatchedLessonId = $lessons->first()->id;
        }
        return redirect()->route('lessons.show', $lastWatchedLessonId);
    }
}
