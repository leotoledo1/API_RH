<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Department;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = ['name', 'description'];

    public function employees(){
        return $this->hasMany(
            Employee::class,
            'department_id',
            'id'
        );
    }
}
