<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    public function student_info(){
    	return $this->belongsTo('App\Student','payee_payer_id');
    }

    public function invoice() {
        return $this->belongsTo('App\Invoice', 'invoice_id');
    }


    public function feeType()
{
    return $this->belongsTo(FeeType::class, 'chart_id', 'id');
}
}