<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAvailability extends Model
{
    protected $fillable = [
        'staff_id',
        'day',
        'from',
        'to',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    // accessors
    public function getFromAttribute($value)
    {
        return $value ? substr($value, 0, 5) : null; // Extract HH:MM
    }

    public function getToAttribute($value)
    {
        return $value ? substr($value, 0, 5) : null; // Extract HH:MM
    }
}