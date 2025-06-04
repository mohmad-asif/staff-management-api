<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'designation',
        'joining_date',
        'status',
    ];

    public function availabilities()
    {
        return $this->hasMany(StaffAvailability::class)->orderByRaw(
            "FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')"
        );
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'staff_departments')
            ->withTimestamps()
            ->using(StaffDepartment::class);
    }
}
