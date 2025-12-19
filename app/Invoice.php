<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $table = 'invoices';

    public function invoice_item(){
    	return $this->hasMany('\App\InvoiceItem','invoice_id');
    }
    public function student(){
    	return $this->belongsTo('\App\Student','student_id');
    }
}