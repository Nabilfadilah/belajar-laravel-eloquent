<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Voucher extends Model
{
    // untuk memberitahu ke laravel bahwa model ini menggunakan id yang tipenya (uuid)
    // dan softdeletes 
    use HasUuids, SoftDeletes;

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

    // scoped local
    public function scopeActive(Builder $builder): void
    {
        $builder->where("is_active", true);
    }

    public function scopeNonActive(Builder $builder): void
    {
        $builder->where("is_active", false);
    }

    // one to many
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, "commentable");
    }

    // public function tags(): MorphToMany
    // {
    //     return $this->morphToMany(Tag::class, "taggable");
    // }
}
