<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Practicum extends Model
{
    protected $fillable = [
        'name',
        'semester',
        'academic_year',
        'status',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function practicumAssistants()
    {
        return $this->hasMany(PracticumAssistant::class);
    }
}
