<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
