<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerProductPrice;
use Illuminate\Http\Request;

class CustomerProductPriceController extends Controller
{
    /** Create or Update customer-product-price entries
     *
     * @param Customer $customer
     * @param Request $request
     * @return string
     */
    public function store(Customer $customer, Request $request)
    {
        $price = new CustomerProductPrice();
        foreach ($request->products as $product)
        {
            $price->updateOrCreate(
                ['user_id' => $customer->id, 'product_id' => $product['id']],
                ['price' => $product['default_price'], 'active' => $product['active']]
            );
        }
        return json_encode(['status' =>'success', 'message' => 'Prices were created and updated.']);
    }
}
