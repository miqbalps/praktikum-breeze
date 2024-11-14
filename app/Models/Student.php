<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'nrp',
        'department',
        'batch',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function assistant()
    {
        return $this->hasOneThrough(Assistant::class, User::class, 'id', 'user_id', 'user_id');
    }
}
