<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
