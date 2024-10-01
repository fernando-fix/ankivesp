<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionUser extends Model
{
    use HasFactory;
    protected $table = 'question_user';
    protected $fillable = [
        'user_id',
        'question_id',
        'last_view',
        'next_view',
        'score',
        'factor',
        'interval',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
