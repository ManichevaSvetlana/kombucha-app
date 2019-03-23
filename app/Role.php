<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /* Database information */
    protected $fillable = ['id', 'name', 'active'];
    /* End of database information */

    /* Relationships information */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
    /* End of relationships information */

    /* Model's additional functions */
    public static function getRole($roleName)
    {
        return Role::where('name', $roleName)->first();
    }
    /* End of model's additional functions */
}
