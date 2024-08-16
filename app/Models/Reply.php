<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['comment_id', 'name', 'comment'];

    // Relationship to the parent comment
     public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}