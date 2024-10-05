<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'year',
        'semester',
    ];

    // Relationships

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'subscriptions');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    public function image()
    {
        return $this->hasOne(Att::class, 'table_id')->where('table_name', 'courses')->where('field_name', 'image');
    }

    // No modelo Course
    public function getQuestionsAttribute()
    {
        return $this->lessons->flatMap->questions;
    }

    public function countWatchedLesssons()
    {
        $user = Auth::user();
        $watchedLessonsIds = Watched::where('user_id', $user->id)->pluck('lesson_id')->toArray();
        return $this->lessons->filter(function ($lesson) use ($watchedLessonsIds) {
            return in_array($lesson->id, $watchedLessonsIds);
        })->count();
    }
}
