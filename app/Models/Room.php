<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'type',
        'location',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
