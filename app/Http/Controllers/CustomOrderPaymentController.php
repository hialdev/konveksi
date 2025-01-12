<?php

namespace App\Http\Controllers;

use App\Models\CustomOrder;
use App\Models\CustomOrderPayment;
use Illuminate\Http\Request;

class CustomOrderPaymentController extends Controller
{

    public function index($id){
        $custom = CustomOrder::find($id);
        return view('custom_orders.payment.index', compact('custom'));
    }

    public function store(Request $request, $id){
        $custom = CustomOrder::find($id);
        $request->merge([
            'total_dibayar' => parseRupiah($request->get('total_dibayar'))
        ]);
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:png,webp,jpg,jpeg,jfif,pdf,docx,doc,pptx|max:10240',
            'total_dibayar' => 'required|numeric|min:0|max:'.$custom->remaining_payment,
        ]);
        try {
            $pay = new CustomOrderPayment();
            $pay->save();
            return redirect()->route('custom-order.payment.index', $id)->with('success', 'Pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pembayaran, Error: '.$e->getMessage());
        }
    }

    public function update(Request $request, $id, $pay_id){
        
    }

    public function destroy($id, $pay_id){
        try {
            $pay = CustomOrderPayment::find($pay_id);
            $pay->delete();
            return redirect()->route('custom-order.payment.index', $id)->with('success', 'Pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pembayaran, Error: '.$e->getMessage());
        }
    }
}
