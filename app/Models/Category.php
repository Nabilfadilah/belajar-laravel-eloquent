<?php

namespace App\Models;

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
}
