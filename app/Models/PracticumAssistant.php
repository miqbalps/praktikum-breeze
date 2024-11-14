<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticumAssistant extends Model
{
    protected $fillable = [
        'schedule_id',
        'assistant_id',
    ];

    public function practicum()
    {
        return $this->belongsTo(Practicum::class);
    }

    public function assistant()
    {
        return $this->belongsTo(Assistant::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
