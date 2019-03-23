<?php

namespace App;

use App\Scope\UserScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /* Database information */
    protected $table = 'users';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone_number', 'id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'name'
    ];

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
    /* End of database information */

    /* Relationships information */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id');
    }
    /* End of relationships information */

    /* Model's additional functions */
    /**
     * Check if the user has role.
     *
     * @param string $role
     * @return boolean
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if the user has role 'Sales Representative'.
     *
     * @return boolean
     */
    public function salesRep()
    {
        return $this->roles()->where('name', 'Sales Representative')->exists();
    }

    /**
     * Check if the user has role 'Customer'.
     *
     * @return boolean
     */
    public function customer()
    {
        return $this->roles()->where('name', 'Customer')->exists();
    }
    /* End of model's additional functions */

}
