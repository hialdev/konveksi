<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Review extends Model
{
    use HasFactory;
    protected $table = 'ulasan';
    protected $guarded = ['id'];

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Set UUID otomatis sebelum menyimpan data
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function product(){
        return $this->hasOne(Product::class, 'produk_id');
    }

    public function order(){
        return $this->hasOne(Order::class, 'pesanan_id');
    }

    public function customOrder(){
        return $this->hasOne(CustomOrder::class, 'pesanan_khusus_id');
    }
}
