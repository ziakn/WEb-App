<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminMachine extends Model
{
    protected $fillable = ['admin_id','machine_id'];

    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
}
