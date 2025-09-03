<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasUuids; // untuk memberitahu ke laravel bahwa model ini menggunakan id yang tipenya (uuid)

    protected $table = 'vouchers';
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    // Kadang ada kasus dimana kita ingin menggunakan UUID pada kolom selain primary key
    // override yang unique id nya
    // Secara default, dia pengembalikan fields $primaryKey, kita bisa ubah jika kita mau
    public function uniqueIds(): array
    {
        return [$this->primaryKey, "voucher_code"];
    }
}
