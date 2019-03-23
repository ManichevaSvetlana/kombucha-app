<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /* Database information */
    protected $fillable = [
        'name', 'sku_number', 'description', 'default_price', 'active'
    ];
    /* End of database information */

    /* Relationships information */
    public function customerProductPrices()
    {
        return $this->hasMany(CustomerProductPrice::class);
    }
    /* End of relationships information */

    /* Model's additional functions */

    /* End of model's additional functions */
}
