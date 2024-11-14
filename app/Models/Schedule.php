<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'practicum_id',
        'room_id',
        'class',
        'day',
        'start_time',
        'end_time',
        'capacity',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function practicum()
    {
        return $this->belongsTo(Practicum::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function practicumAssistants()
    {
        return $this->hasMany(PracticumAssistant::class);
    }
}
