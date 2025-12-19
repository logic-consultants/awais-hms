<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account_types';

    public function masterAccount()
    {
        return $this->belongsTo(MasterAccount::class, 'master_account', 'id');
    }
}