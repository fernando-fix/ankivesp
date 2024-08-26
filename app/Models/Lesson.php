<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $table = 'lessons';

    protected $fillable = [
        'module_id',
        'name',
        'type',
        'url',
        'position',
    ];

    // Relationships
    public function course()
    {
        return $this->hasOneThrough(Course::class, Module::class, 'id', 'id', 'module_id', 'course_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function watcheds()
    {
        return $this->hasMany(Watched::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'watcheds');
    }

    public function nextLesson()
    {
        $nextLesson = $this->module->lessons()->where('position', '>', $this->position)->orderBy('position')->first();
        if (!$nextLesson) {
            $nextModule = $this->module->nextModule();
            if ($nextModule) {
                return $nextModule->lessons()->orderBy('position')->first();
            }
        }
        return $nextLesson;
    }

    public function previowsLesson()
    {
        $previowsLesson = $this->module->lessons()->where('position', '<', $this->position)->orderBy('position', 'desc')->first();
        if (!$previowsLesson) {
            $previowsModule = $this->module->previowsModule();
            if ($previowsModule) {
                return $previowsModule->lessons()->orderBy('position', 'desc')->first();
            }
        }
        return $previowsLesson;
    }
}
