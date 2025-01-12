<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
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
        static::deleting(function ($model) {
            if($model->orders->count() <= 0 || $model->customOrders->count() <= 0) {
                $model->user->delete();
            }
        });
    }

    public function orders(){
        return $this->hasMany(Order::class, 'user_id');
    }

    public function customOrders() {
        return $this->hasMany(CustomOrder::class, 'user_id');
    }
}
