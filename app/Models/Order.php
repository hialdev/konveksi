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

    public static function getTopRevenueProducts($limit = 5)
    {
        $orders = self::where('status', 2)->get(); // Hanya pesanan valid
        $productRevenues = [];

        foreach ($orders as $order) {
            $products = json_decode($order->produk, true); // Decode JSON produk
            
            foreach ($products as $productId => $productData) {
                $qty = $productData['qty'];
                $revenue = ($order->total_harga / array_sum(array_column($products, 'qty'))) * $qty;

                if (!isset($productRevenues[$productId])) {
                    $productRevenues[$productId] = [
                        'id' => $productId,
                        'qty' => $qty,
                        'total_revenue' => $revenue,
                    ];
                } else {
                    $productRevenues[$productId]['qty'] += $qty;
                    $productRevenues[$productId]['total_revenue'] += $revenue;
                }
            }
        }

        usort($productRevenues, fn($a, $b) => $b['total_revenue'] <=> $a['total_revenue']);
        return array_slice($productRevenues, 0, $limit);
    }

    public static function calculateRevenueByStatus($status)
    {
        return self::where('status', '>=', $status)->where('status', '!=', '3')->where('status', '!=', '5')->sum('total_harga');
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
