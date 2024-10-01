<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionList extends Model
{
    use HasFactory;
    protected $table = 'question_lists';

    protected $fillable = [
        'user_id',
        'type',
        'count_correct',
        'count_total',
        'datetime_limit',
        'finished',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questionListItems()
    {
        return $this->hasMany(QuestionListItem::class, 'question_list_id');
    }
}
