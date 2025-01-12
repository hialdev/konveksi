<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RequestProduction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pengajuan_produksi';
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
            if ($model->lampiran) {
                Storage::disk('public')->delete($model->lampiran);
            }
        });
    }

    protected static function getCode()
    {
        $type = 'REQP'; // Purchase Raw Material Code
        $lastRecord = self::whereYear('created_at', '=', date('Y'))
            ->whereMonth('created_at', '=', date('n'))
            ->orderBy('created_at', 'desc')
            ->first();

        $lastNumber = $lastRecord ? intval(explode('/', $lastRecord->code)[1]) : 0;

        $newNumber = $lastNumber + 1;

        return generateCode($type, $newNumber); // Fungsi generateCode dengan nilai default
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customOrder()
    {
        return $this->belongsTo(CustomOrder::class, 'pesanan_khusus_id');
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'bahan_baku_id');
    }
}
