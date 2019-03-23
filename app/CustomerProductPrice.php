<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProductPrice extends Model
{
    /* Database information */
    protected $fillable = [
        'user_id', 'product_id', 'price', 'active'
    ];

    /* End of database information */

    /* Relationships information */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    /* End of relationships information */

    /* Model's additional functions */


    /* End of model's additional functions */
}
