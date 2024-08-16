<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $table = 'meeting_time';
    protected $guarded = [
         'created_at', 'updated_at'
    ];
    
      public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'meet_schedule_id');
    }
    
}
