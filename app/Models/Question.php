<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'options' => 'array',
    ];


    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
