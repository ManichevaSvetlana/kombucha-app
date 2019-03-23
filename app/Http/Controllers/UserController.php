<?php

namespace App\Http\Controllers;

use App\Customer;
use App\NovaModels\SalesRepresentative;
use App\NovaModels\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** Get list of the users by type
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        $user = $request->user ?? false;
        $customer = $request->customer ?? false;
        $sales_rep = $request->sales_rep ?? false;

        $model = false;
        $str = '';

        if($user) {
            $model = new User();
            $str = $user;
        }
        if($customer)
        {
            $model = new Customer();
            $str = $customer;
        }
        if($sales_rep)
        {
            $model = new SalesRepresentative();
            $str = $sales_rep;
        }

        return !$model ? \App\User::paginate(10) : $model->where('email', 'like', "%$str%")->orWhere('phone_number', 'like', "%$str%")->orWhereRaw("CONCAT(`first_name`, ' ', `last_name`) LIKE ?", ['%'.$str.'%'])->take(10)->selectRaw('users.id as value, concat(users.first_name, " ", users.last_name, " - ", users.email) as label')->get();
    }
}
