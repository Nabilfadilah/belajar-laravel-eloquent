<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    protected $table = 'wallets';
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false; // default nya adalah true

    // model kw 2, pake belongsTo 
    public function customer(): BelongsTo
    {
        // model customer, kolom 'customer_id' di table wallet, dan kolom 'id' di table customer
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }
}
