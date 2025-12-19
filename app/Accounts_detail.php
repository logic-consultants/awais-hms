<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts_detail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */


    protected $table = 'account_detail';
    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_type', 'id');
    }
}