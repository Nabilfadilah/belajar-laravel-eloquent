<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true; // default nya adalah true

    // kita bisa membuat default value untuk attributes di Model, sehingga ketika pertama kali dibuat object Model nya, 
    // secara otomatis default value nya mengikuti yang sudah kita tetapkan.
    protected $attributes = [
        'title' => 'Sample Title',
        'comment' => 'Sample Comment',
    ];
}
