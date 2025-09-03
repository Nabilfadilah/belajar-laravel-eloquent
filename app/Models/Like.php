<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Like extends Pivot
{
    protected $table = "table_customers_likes_products";
    protected $foreignKey = "customer_id";
    protected $relatedKey = "product_id";
    public $timestamps = false;

    public function usesTimestamps(): bool
    {
        // paksa jadi false
        return false;
    }

    // relasi ke costomer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }

    // relasi ke product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
