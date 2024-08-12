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
}
