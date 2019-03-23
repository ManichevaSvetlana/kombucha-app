<?php

namespace App;

use App\Scope\CustomerScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends User
{
    /* Database information */
    protected $table = 'users';

    /* End of database information */

    /* Relationships information */
    public function prices()
    {
        return $this->hasMany(CustomerProductPrice::class, 'user_id');
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

        static::addGlobalScope(new CustomerScope);
    }

    /**
     * Save the User with role 'Customer'.
     *
     * @param array $options
     * @return boolean
     */
    public function save(array $options = [])
    {
        $changes = $this->getDirty();
        $user = DB::table('users')->where('id', $this->id)->first();
        $id = $user ? DB::table('users')->where('id', $this->id)->update($changes) : DB::table('users')->insertGetId($changes);
        if(!$this->id) $this->id = $id;
        UserRole::firstOrCreate(['user_id' => $this->id, 'role_id' => Role::getRole('Customer')->id]);
        return true;
    }

    /* End of model's additional functions */
}
