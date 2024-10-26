<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';

    protected $fillable = [
        'question',
        'lesson_id',
    ];

    // Relationships
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function correctAnswer()
    {
        return $this->answers()->where('correct', true)->first();
    }

    public function module()
    {
        return $this->hasOneThrough(Module::class, Lesson::class, 'id', 'id', 'lesson_id', 'module_id');
    }

    public function getCourseAttribute()
    {
        // public function course;
        return $this->lesson->module->course;
    }

    public static function search($filter = null)
    {
        $search = Question::where(function ($query) use ($filter) {

            if (isset($filter['course_id'])) {
                $query->whereHas('module', function ($query) use ($filter) {
                    $query->whereHas('course', function ($query) use ($filter) {
                        $query->where('course_id', $filter['course_id']);
                    });
                });
            }

            if (isset($filter['module_id'])) {
                $query->whereHas('module', function ($query) use ($filter) {
                    $query->where('module_id', $filter['module_id']);
                });
            }

            if (isset($filter['lesson_id'])) {
                $query->where('lesson_id', $filter['lesson_id']);
            }

            if (isset($filter['question'])) {
                $query->where('question', 'like', '%' . $filter['question'] . '%');
            }

        });

        return $search;
    }
}
