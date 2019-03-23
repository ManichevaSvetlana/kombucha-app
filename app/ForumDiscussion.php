<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ForumDiscussion extends Model
{
    /* Database information */
    protected $table = 'chatter_discussion';

    protected $casts = ['content', 'user_name'];

    public function getContentAttribute()
    {
        $post = $this->posts()->whereUserId($this->user_id)->first();
        return $post ? $post->body : null;
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name.' '.$this->user->email : null;
    }
    /* End of database information */

    /* Relationships information */
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'chatter_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(ForumComment::class, 'chatter_discussion_id');
    }
    /* End of relationships information */

    /**
     * Save the Discussion with the post.
     *
     * @param array $options
     * @return boolean
     */
    public function save(array $options = [])
    {
        $changes = $this->getDirty();
        if(key_exists('content', $changes)){
            if($this->posts()->whereUserId($this->user_id)->first()) $this->posts()->whereUserId($this->user_id)->first()->update(['body' => $changes['content']]);
            unset($changes['content']);
            unset($this->content);
        }
        return parent::save($options);
    }
}