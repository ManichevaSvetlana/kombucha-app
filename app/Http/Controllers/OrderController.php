<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Get the re-order link for the customer with auth credentials.
     *
     * @param $user
     * @return string
     */
    public static function getAuthLink($user)
    {
        $key = "x`^SZM928XAh{&fXK{P|n't/uVWHXq,>28DxWT7z(K{h7gY<d=P?UAs)gQUq:9a pW#R,U(gN>7|lYA0deRaGvma1Uq;{P0pR+.GhPRN?pjo33N?Dq[h5^#EpF:BcKh";
        $token = [
            'password' => $user->password,
            'email' => $user->email
        ];

        $token = JWT::encode($token, $key);
        return url('/order?auth='.$token);
    }

    /**
     * Show order page for the customer with login.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if(auth()->check()) return $this->showOrderPage();

        $token = $request->auth ?? false;
        if(!$token) return abort(403);

        $key = "x`^SZM928XAh{&fXK{P|n't/uVWHXq,>28DxWT7z(K{h7gY<d=P?UAs)gQUq:9a pW#R,U(gN>7|lYA0deRaGvma1Uq;{P0pR+.GhPRN?pjo33N?Dq[h5^#EpF:BcKh";
        $decoded = (array) JWT::decode($token, $key, array('HS256'));
        if(!key_exists('password', $decoded) || !key_exists('email', $decoded)) return abort(403);

        $user = User::where([['password', $decoded['password']], ['email', $decoded['email']]])->first();
        if(!$user) return abort(403);
        Auth::loginUsingId($user->id);
        return $this->showOrderPage();
    }

    /**
     * Create the order.
     *
     * @param Request $request
     * @return View
     */
    public function store(Request $request)
    {
        $products = [];
        foreach ($request->except('_token') as $key => $value){
            if(strrpos($key, "quantity-") !== false) $products[explode('-', $key)[1]] = $value;
        }
        $products = json_encode($products);
        Order::create(['user_id' => auth()->user()->id, 'products' => $products]);
        return view('app.order-page-success');
    }

    /**
     * Get the order page with all active products.
     *
     * @return View
     */
    private function showOrderPage()
    {
        $products = Product::whereActive(1)->get();
        return view('app.order-page', compact('products'));
    }
}
