<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRolePivot extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
