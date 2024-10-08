<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $table = 'modules';

    protected $fillable = [
        'course_id',
        'name',
        'position',
        'due_date',
        'lessons_count'
    ];

    // Relationships

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function nextModule()
    {
        return $this->course->modules()->where('position', '>', $this->position)->orderBy('position')->first();
    }

    public function previowsModule()
    {
        return $this->course->modules()->where('position', '<', $this->position)->orderBy('position', 'desc')->first();
    }
}
