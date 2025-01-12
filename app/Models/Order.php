<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Set UUID otomatis sebelum menyimpan data
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
            $model->code = static::getCode();
        });
        static::deleting(function ($model) {
            if ($model->bukti_pembayaran) {
                Storage::disk('public')->delete($model->bukti_pembayaran);
            }
        });
    }

    protected static function getCode()
    {
        $type = 'ORDER'; // Purchase Raw Material Code
        $lastRecord = self::whereYear('created_at', '=', date('Y'))
            ->whereMonth('created_at', '=', date('n'))
            ->orderBy('created_at', 'desc')
            ->first();

        $lastNumber = $lastRecord ? intval(explode('/', $lastRecord->code)[1]) : 0;

        $newNumber = $lastNumber + 1;

        return generateCode($type, $newNumber); // Fungsi generateCode dengan nilai default
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stok_id');
    }

    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'pesanan_id');
    }

    public function retur(){
        return $this->hasOne(Retur::class, 'pesanan_id');
    }
}
