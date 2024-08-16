<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostReaction extends Model
{
    protected $fillable = ['post_id', 'user_id', 'reaction_type'];

    // Optionally, define relationships if needed
}
