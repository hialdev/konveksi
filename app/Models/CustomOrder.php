<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomOrder extends Model
{
    use HasFactory;
    protected $table = 'pesanan_khusus';
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
            if ($model->lampiran_bahan) {
                Storage::disk('public')->delete($model->lampiran_bahan);
            }
            if ($model->lampiran) {
                Storage::disk('public')->delete($model->lampiran);
            }
        });
    }

    protected static function getCode()
    {
        $type = 'CUSTOM'; // Purchase Raw Material Code
        $lastRecord = self::whereYear('created_at', '=', date('Y'))
            ->whereMonth('created_at', '=', date('n'))
            ->orderBy('created_at', 'desc')
            ->first();

        $lastNumber = $lastRecord ? intval(explode('/', $lastRecord->code)[1]) : 0;

        $newNumber = $lastNumber + 1;

        return generateCode($type, $newNumber); // Fungsi generateCode dengan nilai default
    }

    public static function calculateRevenue()
    {
        return self::where('status', '=', '5')->sum('total_harga');
    }

    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rawMaterial(){
        return $this->belongsTo(RawMaterial::class, 'bahan_baku_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'produk_id');
    }

    public function desain(){
        return $this->belongsTo(Desain::class, 'desain_id');
    }
    
    public function production(){
        return $this->hasOne(RequestProduction::class, 'pesanan_khusus_id');    
    }

    public function payments()
    {
        return $this->hasMany(CustomOrderPayment::class, 'pesanan_khusus_id');
    }

    public function getRemainingPaymentAttribute()
    {
        $totalDibayar = $this->payments()->where('status', '2')->sum('total_dibayar');
        return max($this->total_harga - $totalDibayar, 0);
    }

    public function retur(){
        return $this->hasOne(Retur::class, 'pesanan_khusus_id');
    }
}
