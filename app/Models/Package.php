<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{   
    protected $table = 'package';
    protected $guarded = [
        'id','created_at','updated_at', 
    ];
}
