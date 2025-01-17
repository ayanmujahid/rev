<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingAffiliation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'parent_id',
        'status',
        'distribut_amount',
        'affiliated_code',
        'amount',
    ];


    public function main_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
