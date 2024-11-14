<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assistant extends Model
{
    protected $fillable = [
        'user_id',
        'student_id',
        'type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->hasOneThrough(Student::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function practicumAssistants()
    {
        return $this->hasMany(PracticumAssistant::class);
    }
}
