<?php

namespace App\Models;

class Messages extends BaseModel
{
    protected $table = 'messages';

    public function user()
    {
        return $this->belongsTo('App/Models/Users', 'user_id', 'id');
    }
}
