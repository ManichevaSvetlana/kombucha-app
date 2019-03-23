<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    /* Database information */
    protected $table = 'chatter_post';

    protected $fillable = [
        'chatter_discussion_id', 'user_id', 'body'
    ];

    protected $appends = ['user_name'];

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    /* End of database information */

    /* Relationships information */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function discussion()
    {
        return $this->belongsTo('App\ForumDiscussion', 'chatter_discussion_id');
    }
    /* End of relationships information */
}
