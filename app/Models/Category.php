<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    // atributte yang dibutuhkan di model
    protected $table = 'categories'; // kita overide, refresintasi dari table nama table nya
    protected $primaryKey = 'id'; // kolom primaryKey nya Id
    protected $keyType = 'string'; // key type nya apa, kita kasih string
    public $incrementing = false; // apakah autoincrement?
    public $timestamps = false; // apakah ada timestamp?

    // relasi one to many
    public function products(): HasMany
    {
        // model waller, kolom 'customer_id' di table product, dan kolom 'id' di table product
        return $this->hasMany(Product::class, "category_id", "id");
    }

    // fillable attribute
    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    // override booted
    protected static function booted()
    {
        // setiap melakukan query apapun dari table category
        // maka akan selalu tambahkan scope IsActiveScope() ini
        parent::booted();
        self::addGlobalScope(new IsActiveScope());
    }

    // chepest/ relasi Has one of Many
    // ambil product paling murah
    public function cheapestProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->oldest('price');
    }

    // mos expensive
    // ambil product paling mahal
    public function mostExpensiveProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->latest('price');
    }

    protected $casts = [
        'created_at' => 'datetime:U'
    ];

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,
            Product::class,
            "category_id", // fk on products table
            "product_id", // fk on reviews table
            "id", // Pk on categories table
            "id" // Pk on products table
        );
    }
}
