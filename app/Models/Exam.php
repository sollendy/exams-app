<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'exam_date'];

     public function users()
    {
        return $this->belongsToMany(User::class, 'exams_users');
    }
}
