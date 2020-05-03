<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'admin_id','machine_id','name','make','model','description',
    ];

    public function machine()
    {
        return $this->belongsTo('App\User','machine_id');
    }
}
