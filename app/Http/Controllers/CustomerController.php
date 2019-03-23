<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /** Get list of the customers
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        $name = $request->name ?? false;
        $phone = $request->phone ?? false;
        $email = $request->email ?? false;
        if($name) return Customer::where('first_name', 'like', "%$name%")->OrWhere('last_name', 'like', "%$name%")->take(10)->selectRaw('users.id as value, concat(users.first_name, " ", users.last_name, " - ", users.email) as label')->get();
        if($email) return Customer::where('email', 'like', "%$email%")->take(10)->selectRaw('users.id as value, concat(users.first_name, " ", users.last_name, " - ", users.email) as label')->get();
        if($phone) return Customer::where('customers.phone_number', 'like', "%$phone%")->take(10)->selectRaw('users.id as value, concat(users.first_name, " ", users.last_name, " - ", users.phone_number) as label')->get();
        return Customer::paginate(10);
    }

    /** Get specific customer with product prices list
     *
     *
     *
     * @param Customer $customer
     * @return string
     */
    public function get(Customer $customer)
    {
        $customer->prices = $customer->prices()->get();
        return $customer;
    }

    /** Get customer's [id, name] by email/ name
     *
     * @param string $name
     * @return string
     */
    public function getByEmailOrName($name)
    {
        $customers = Customer::where('email', 'like', "$name%")->OrWhereRaw("CONCAT(`first_name`, ' ', `last_name`) LIKE ?", ['%'.$name.'%']);
        if($customers->count() > 1) return json_encode(['result' => false, 'message' => 'There are too many customers with this email/phone number.', 'status' => 1]);
        else if($customers->count() < 1) return json_encode(['result' => false, 'message' => 'There are no customers with this email/phone number.', 'status' => 0]);
        else return json_encode(['result' => true, 'customer' => $customers->selectRaw('users.id, users.first_name, users.last_name')->first()]);
    }
}
