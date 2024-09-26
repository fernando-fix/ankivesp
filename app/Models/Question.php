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
            if (isset($filter['seila'])) {
                $query->where('question', 'LIKE', "%{$filter['seila']}%");
            }
        });

        return $search;
    }
}
