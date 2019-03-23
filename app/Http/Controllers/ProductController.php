<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** Get list of the products
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
       $name = $request->name ?? false;
       return !$name ? Product::whereActive(1)->get() : Product::where('name', 'like', "%$name%")->whereActive(1)->take(10)->get();
    }
}
