<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function category(): BelongsTo {
        return $this->belongsTo(ProductCategory::class);
    }

    public function carts() {
        return $this->hasMany(Cart::class);
    }

    public function getImage()
    {
        $imagePath = $this->image;
        if (file_exists(public_path($imagePath))) {
            return $imagePath; // Return the original image path if it exists
        } else {
            return 'frontend/images/logo.svg'; // Return a default image path if the original image doesn't exist
        }
    }
}
