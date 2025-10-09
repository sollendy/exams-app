<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['title', 'exam_date', 'vote', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
