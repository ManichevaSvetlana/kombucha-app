<?php

namespace App\NovaModels;

use App\Role;
use App\Scope\SalesRepTypeScope;
use App\UserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalesRepresentative extends \App\User
{
    /* Model's additional functions */

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SalesRepTypeScope);
    }

    /**
     * Save the User with role 'Sales Representative'.
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
        UserRole::firstOrCreate(['user_id' => $this->id, 'role_id' => Role::getRole('Sales Representative')->id]);
        return true;
    }

    /* End of model's additional functions */


}
