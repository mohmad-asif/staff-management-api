<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'department_code',
    ];

    public function staffs()
    {
        return $this->belongsToMany(Staff::class, 'staff_departments')
            ->withTimestamps()
            ->using(StaffDepartment::class);
    }
}
