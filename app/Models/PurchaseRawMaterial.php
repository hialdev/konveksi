<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PurchaseRawMaterial extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pembelian_bahan_baku';
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
            if ($model->file_bukti) {
                Storage::disk('public')->delete($model->file_bukti);
            }
        });
    }

    protected static function getCode()
    {
        $type = 'PRM'; // Purchase Raw Material Code
        $lastRecord = self::whereYear('created_at', '=', date('Y'))
            ->whereMonth('created_at', '=', date('n'))
            ->orderBy('created_at', 'desc')
            ->first();

        $lastNumber = $lastRecord ? intval(explode('/', $lastRecord->code)[1]) : 0;

        $newNumber = $lastNumber + 1;

        return generateCode($type, $newNumber); // Fungsi generateCode dengan nilai default
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'bahan_baku_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
