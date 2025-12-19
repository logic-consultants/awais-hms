<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSession extends Model
{
    protected $table = 'student_sessions';

   public function AssignFees()
    {
        return $this->hasMany('App\StudentFeeAssign', 'student_id', 'student_id');
    }
}
