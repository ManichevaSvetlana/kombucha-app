<?php

namespace App;

use App\Nova\SalesRepresentative;
use App\Scope\AccountScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    /* Database information */
    protected $fillable = [
        'name', 'delivery_address', 'purchase_order_required', 'delivery_day', 'message', 'sales_rep_id'
    ];

    protected $appends = [
        'contact_1', 'contact_2', 'contact_3',
    ];

    protected $casts = [
        'delivery_day' => 'date'
     ];

    public function getAccountIdAttribute()
    {
        return $this->id;
    }

    public function getContact1Attribute()
    {
        return $this->contacts()->count() > 0 ? $this->getContactsArrays()[0] : $this->getEmptyContactsArray();
    }

    public function getContact2Attribute()
    {
        return $this->contacts()->count() > 1 ? $this->getContactsArrays()[1] : $this->getEmptyContactsArray();
    }

    public function getContact3Attribute()
    {
        return $this->contacts()->count() > 2 ? $this->getContactsArrays()[2] : $this->getEmptyContactsArray();
    }
    /* End of database information */

    /* Relationships information */
    public function salesRep()
    {
        return $this->belongsTo(SalesRepresentative::class, 'sales_rep_id');
    }

    public function contacts()
    {
        return $this->hasMany(AccountContact::class);
    }
    /* End of relationships information */

    /* Model's additional functions */

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AccountScope);
    }

    /**
     * Save the Account with sales_rep_id.
     *
     * @param array $options
     * @return boolean
     */
    public function save(array $options = [])
    {
        if(!auth()->check()) abort(403);
        $changes = $this->getDirty();
        $contacts = [$changes['contact_1'] ?? [], $changes['contact_2'] ?? [], $changes['contact_3'] ?? []];
        $changes['sales_rep_id'] = auth()->user()->id;
        $this->saveModel($changes);
        $this->saveAccountContacts($contacts);
        return true;
    }

    /**
     * Delete the Account with all contacts.
     *
     * @return mixed
     * @throws \Exception
     */
    public function delete()
    {
        $this->contacts()->delete();
        return parent::delete();
    }

    /**
     * Save the model entry to DB.
     *
     * @param array $changes
     * @return boolean
     */
    public function saveModel(array $changes)
    {
        $changes = array_diff_key($changes, array_flip(["contact_1", "contact_2", "contact_3"]));
        $model = DB::table('accounts')->where('id', $this->id)->first();
        $id = $model ? DB::table('accounts')->where('id', $this->id)->update($changes) : DB::table('accounts')->insertGetId($changes);
        if(!$this->id) $this->id = $id;
        return true;
    }

    /**
     * Delete array's element.
     *
     * @param string $key
     * @param array $array
     * @return void
     */
    public function unsetElement(string $key, array $array)
    {
        if(key_exists($key, $array)) unset($array[$key]);
    }

    /**
     * Save the Account Contacts.
     *
     * @param array $contacts
     * @return boolean
     */
    public function saveAccountContacts(array $contacts)
    {
        $this->contacts()->delete();
        foreach ($contacts as $k => $contact)
        {
            $contact = json_decode($contact, true);
            echo $this->validateContract($contact) ? 'validated' : 'no';
            if($this->validateContract($contact)) {
                DB::table('account_contacts')->updateOrInsert(['user_id' => $contact['customer_id'], 'account_id' => $this->id], ['reminder' => $contact['reminder'] ?? true, 'days_before_delivery' => $contact['days_before_delivery']]);
                $contactNumber = 'contact_'.$k;
                $this->$contactNumber = ['customer_id' => $contact['customer_id'], 'customer_name' => User::findOrFail($contact['customer_id'])->name, 'reminder' => $contact['reminder'], 'days_before_delivery' => $contact['days_before_delivery'] ];
            }
        }

        return true;
    }

    /**
     * Validate the contract array.
     *
     * @param mixed $contact
     * @return boolean
     */
    public function validateContract($contact)
    {
        echo $contact['customer_id'];
        if(!is_array($contact)) return false;
        try{
            if(!key_exists('customer_id', $contact) || !User::find($contact['customer_id'])) return false;
            if(!key_exists('days_before_delivery', $contact) || $contact['days_before_delivery'] < 0) return false;
            if($this->contacts()->where('user_id', $contact['customer_id'])->count() > 0) return false;
        } catch(\Exception $e) { return false; }
        return true;
    }

    /**
     * Get contacts array with no data.
     *
     * @return array
     */
    public function getEmptyContactsArray()
    {
        return ['customer_id' => '', 'customer_name' => '', 'reminder' => true, 'days_before_delivery' => ''];
    }

    /**
     * Get contacts arrays.
     *
     * @return array
     */
    public function getContactsArrays()
    {
        $contacts = [];
        foreach ($this->contacts as $contact){
            array_push($contacts, ['customer_id' => $contact->user_id, 'customer_name' => User::find($contact->user_id)->name ?? '' , 'reminder' => $contact->reminder, 'days_before_delivery' => $contact->days_before_delivery]);
        }
        return $contacts;
    }
    /* End of model's additional functions */
}
