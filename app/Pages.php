<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $fillable = [
        "production_overview",
        "manage_user",
        "checklist_or_create",
        "scan_or_document",
        "setting",
        "user_role",
        
    ];
}
