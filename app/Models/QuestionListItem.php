<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionListItem extends Model
{
    use HasFactory;
    protected $table = 'question_list_items';

    protected $fillable = [
        'question_list_id',
        'answer_id',
        'question_id',
        'correct',
    ];

    // Relationships
    public function questionList()
    {
        return $this->belongsTo(QuestionList::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
