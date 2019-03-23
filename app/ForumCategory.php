<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $table = 'chatter_categories';

    protected $fillable = ['parent_id', 'order', 'name', 'color', 'slug'];

    public function discussion()
    {
        return $this->hasMany(ForumDiscussion::class, 'chatter_category_id');
    }
}
