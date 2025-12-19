<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $table = 'invoice_items';

    public function feetypename(){
    	return $this->belongsTo('\App\FeeType','fee_id');
    }
    public function account_detail()
    {
        return $this->belongsTo('\App\Accounts_detail', 'fee_id');
    }
	
    public function invoice()
{
    return $this->belongsTo(\App\Invoice::class);
}

}