<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'meet_schedule';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
    
     public function times()
    {
        return $this->hasMany(Time::class, 'meet_schedule_id');
    }
}
