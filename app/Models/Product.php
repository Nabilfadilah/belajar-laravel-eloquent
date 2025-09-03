<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false; // default nya adalah true

    // relasi one to one
    public function category(): BelongsTo
    {
        // model product, kolom 'customer_id' di table product, dan kolom 'id' di table customer
        return $this->belongsTo(Category::class, "category_id", "id");
    }

    // Has Many Through
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, "product_id", "id");
    }

    // Many to Many
    public function likedByCustomers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, "table_customers_likes_products", "product_id", "customer_id")
            ->withPivot("created_at")  // Untuk mendapatkan informasi dari Intermediate Table, kita bisa menggunakan attribute
            ->using(Like::class);
    }

    // One to One Polymorphic
    public function image(): MorphOne
    {
        // ambil ke model image, dari nama kolom "imageable"
        return $this->morphOne(Image::class, "imageable");
    }

    // public function comments(): MorphMany
    // {
    //     return $this->morphMany(Comment::class, "commentable");
    // }

    // public function latestComment(): MorphOne
    // {
    //     return $this->morphOne(Comment::class, "commentable")
    //         ->latest("created_at");
    // }

    // public function oldestComment(): MorphOne
    // {
    //     return $this->morphOne(Comment::class, "commentable")
    //         ->oldest("created_at");
    // }

    // public function tags(): MorphToMany
    // {
    //     return $this->morphToMany(Tag::class, "taggable");
    // }
}
