<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\ExamAnswerFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function session()
    {
        return $this->belongsTo(ExamSession::class, 'session_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
