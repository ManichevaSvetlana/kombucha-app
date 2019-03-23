<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountContact extends Model
{
    /* Database information */
    protected $fillable = ['account_id', 'user_id', 'reminder', 'days_before_delivery'];
    /* End of database information */

    /* Relationships information */
    public function user()
    {
        $this->belongsTo(Customer::class, 'user_id');
    }

    public function account()
    {
        $this->belongsTo(Account::class);
    }

    /* End of relationships information */

    /* Model's additional functions */


    /* End of model's additional functions */

}
