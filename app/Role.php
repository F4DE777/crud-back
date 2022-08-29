<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];

    public function permission(){
        return $this->hasMany(Permission::class,'role_id');
    }
}
