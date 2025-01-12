<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'produk_kategori';

    public function products(){
        return $this->hasMany(Product::class, 'produk_kategori_id');
    }
}
