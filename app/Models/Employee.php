<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Department;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['cpf', 'name', 'pis', 'adress', 'department_id'];

    public function department(){
        return $this->belongsTo(
            Department::class,
            'department_id',
            'id'
        );
    }
}
