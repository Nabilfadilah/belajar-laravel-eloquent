<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
