<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountContact;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class TaskController extends Controller
{
    public $user, $email, $phone, $account, $delivery_day;

    /**
     * Send emails and messages to customers about re-order.
     *
     * @return void
     */
    public function reminder()
    {
        $contacts = AccountContact::where('reminder', 1)->get();
        foreach ($contacts as $contact)
        {
            $this->setInitialVariables($contact);
            $now = (new Carbon());
            $deliveryDay = (new Carbon($this->delivery_day))->subDays($contact->days_before_delivery);
            echo $contact->days_before_delivery.' ; '.$deliveryDay->format('d').' = '.$now->format('d').'  =   ';
            echo '<br>';
            echo '<br>';
            if($now->format('d') == $deliveryDay->format('d')) {
                try{
                    $this->sendMessage();
                    $this->sendSMS();
                } catch(ConfigurationException $e) {} catch(\Exception $e) {}
            }
        }
    }

    /**
     * Send emails to the customer.
     *
     * @return void
     */
    private function sendMessage()
    {
        $user = $this->user;
        $user->order_message = $this->account->message;
        Mail::send('emails.reminder', ['url' => OrderController::getAuthLink($user), 'user' => $user], function ($m) use ($user) {
            $m->from('support@wrapcrowd.com', 'Kombucha');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });
    }

    /**
     * Send sms to the customer.
     *
     * @return void
     *
     * @throws ConfigurationException
     */
    private function sendSMS()
    {
        $user = $this->user;
        $sid    = "AC3491390c87938158dc14c96873a0eb5f";
        $token  = "1663a8c1fcda843bd5a2fb25c341457b";
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create($user->phone_number,
                array(
                    "body" => $this->account->message.' '.OrderController::getAuthLink($user),
                    "from" => "+15183337776"
                )
            );
    }

    /**
     * Set user, user email, user phone, account, delivery day variables from the AccountContact.
     *
     * @param $contact
     * @return void
     */
    private function setInitialVariables($contact)
    {
        $user = User::find($contact->user_id);
        $this->user = $user;
        $this->email = $user->email;
        $this->phone = $user->phone_number;
        $this->account = Account::find($contact->account_id);
        $this->delivery_day = $this->account->delivery_day;
    }
}
