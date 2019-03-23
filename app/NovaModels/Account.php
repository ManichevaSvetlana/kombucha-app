<?php

namespace App\NovaModels;

use Illuminate\Database\Eloquent\Model;

class Account extends \App\Account
{
    /* Database information */
    protected $table = 'accounts';

    /* End of database information */

    /* Relationships information */
    public function salesRepresentative()
    {
        return $this->belongsTo(SalesRepresentative::class, 'sales_rep_id');
    }
    /* End of relationships information */

    /* Model's additional functions */
    /**
     * Save the Account with Contacts.
     *
     * @param array $options
     * @return boolean
     */
    public function save(array $options = [])
    {
        $changes = $this->getDirty();
        $contacts = [$changes['contact_1'] ?? [], $changes['contact_2'] ?? [], $changes['contact_3'] ?? []];
        $this->saveModel($changes);
        $this->saveAccountContacts($contacts);
        return true;
    }
    /* End of model's additional functions */
}
