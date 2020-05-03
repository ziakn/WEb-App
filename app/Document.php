<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'admin_id','title','barcode','description','file_src',
    ];
}
