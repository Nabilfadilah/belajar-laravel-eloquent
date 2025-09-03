<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Date;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false; // default nya adalah true

    // relasi one to one
    public function wallet(): HasOne
    {
        // model waller, kolom 'customer_id' di table waller, dan kolom 'id' di table customer
        return $this->hasOne(Wallet::class, "customer_id", "id");
    }

    // Has One
    public function virtualAccount(): HasOneThrough
    {
        return $this->hasOneThrough(VirtualAccount::class, Wallet::class, "customer_id", "wallet_id", "id", "id");
    }

    // Has Many Through
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, "customer_id", "id");
    }

    // Many to Many
    public function likeProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, "table_customers_likes_products", "customer_id", "product_id")
            ->withPivot("created_at"); // Untuk mendapatkan informasi dari Intermediate Table, kita bisa menggunakan attribute
        // ->using(Like::class);
    }

    // ambil data barang/products yang like oleh customer, tapi 1 minggu yang lalu
    public function likeProductsLastWeek(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, "table_customers_likes_products", "customer_id", "product_id")
            ->withPivot("created_at") // Untuk mendapatkan informasi dari Intermediate Table, kita bisa menggunakan attribute
            ->wherePivot("created_at", ">=", Date::now()->addDays(-7)); // pake wherePivot sulusinya.
        // ->using(Like::class);
    }

    // public function image(): MorphOne
    // {
    //     return $this->morphOne(Image::class, "imageable");
    // }
}
