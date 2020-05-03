<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    protected $fillable = [
        'admin_id','machine_id','task_name','target_type','start_time','end_time',
        'start_date','end_date','qunatity_produce','qunatity_require','status','remark',
    ];
}
