<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // atributte yang dibutuhkan di model
    protected $table = 'categories'; // kita overide, refresintasi dari table nama table nya
    protected $primaryKey = 'id'; // kolom primaryKey nya Id
    protected $keyType = 'string'; // key type nya apa, kita kasih string
    public $incrementing = false; // apakah autoincrement?
    public $timestamps = false; // apakah ada timestamp?

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
}
