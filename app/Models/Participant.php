<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'full_name',
        'cedula',
        'email',
        'phone',
        'location'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}