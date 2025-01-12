<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'produk';
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
        static::deleting(function ($model) {
            if ($model->image) {
                Storage::disk('public')->delete($model->image);
            }
            $model->stock->delete();
        });
    }

    public function stock(){
        return $this->hasOne(Stock::class, 'produk_id');
    }

    public function category(){
        return $this->belongsTo(ProductCategory::class, 'produk_kategori_id');
    }
}
