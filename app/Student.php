<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Student extends Model
{
	public function Assign_fees(){
        return $this->hasMany('App\StudentFeeAssign','student_id','id');
    }

    /**
     * Get all of the comments for the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'student_id', 'id');
    }
	
}
