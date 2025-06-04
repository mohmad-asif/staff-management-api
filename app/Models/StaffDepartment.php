<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StaffDepartment extends Pivot
{
    protected $table = 'staff_departments';
    public $timestamps = true;
}
