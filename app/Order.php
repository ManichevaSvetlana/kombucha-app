<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    /* Database information */
    protected $fillable = [
        'user_id', 'products'
    ];

    protected $appends = [
        'products_quantity'
    ];

    protected $casts = [
      'created_at' => 'datetime'
    ];

    public function getProductsQuantityAttribute()
    {
        return ['products' => $this->productsQuantity(), 'json_products' => $this->products];
    }
    /* End of database information */

    /* Relationships information */

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    /* End of relationships information */

    /* Model's additional functions */

    /**
     * Get the products list with quantity.
     *
     * @return mixed
     */
    public function productsQuantity()
    {
        $products = json_decode($this->products, true);
        $response = collect([]);
        foreach ($products ?? [] as $product => $quantity){
            $element = Product::findOrFail($product);
            $element->order_quantity = $quantity;
            $response->push($element);
        }
        return $response;
    }

    /**
     * Save the Account with sales_rep_id.
     *
     * @param array $options
     * @return boolean
     */
    public function save(array $options = [])
    {
        $changes = $this->getDirty();
        if(key_exists('products_quantity', $changes))
        {
            $changes['products'] = $changes['products_quantity'];
            $changes = array_diff_key($changes, array_flip(["products_quantity"]));
            $model = DB::table('orders')->where('id', $this->id)->first();
            $id = $model ? DB::table('orders')->where('id', $this->id)->update($changes) : DB::table('orders')->insertGetId($changes);
            if(!$this->id) $this->id = $id;
            return true;
        }
        return parent::save($options);
    }
    /* End of model's additional functions */
}
