<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRole extends Model
{
    /* Database information */
    protected $fillable = ['id', 'user_id', 'role_id'];

    protected $appends = [
        'user_with_type',
    ];

    public function getUserWithTypeAttribute()
    {
        $user = $this->user;
        if(!$user) return ['user' => new \stdClass(), 'user_type' => 'user'];
        $role = $this->role->name;
        $type = $role == 'Admin' ? 'user' : ($role == 'Sales Representative' ? 'sales_rep' : 'customer');
        return ['user' => ['label' => $user->name, 'value' => $user->id], 'user_type' => $type];
    }
    /* End of database information */

    /* Relationships information */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    /* End of relationships information */

    /* Model's additional functions */

    /**
     * Save the UserRole model.
     *
     * @param array $options
     * @return boolean
     */
    public function save(array $options = [])
    {
        $changes = $this->getDirty();
        if(!key_exists('user_with_type', $changes)) return parent::save($options);
        $user = json_decode($changes['user_with_type'], true);
        $changes['user_id'] = $user['user']['value'];
        $changes = array_diff_key($changes, array_flip(["user_with_type"]));
        $id = DB::table('user_roles')->where('id', $this->id)->first() ? DB::table('user_roles')->where('id', $this->id)->update($changes) : DB::table('user_roles')->insertGetId($changes);
        if(!$this->id) $this->id = $id;
        return true;
    }

    /* End of model's additional functions */
}
