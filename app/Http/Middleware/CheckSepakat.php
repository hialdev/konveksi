<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\CustomOrder;

class CheckSepakat
{
    public function handle($request, Closure $next)
    {
        $id = $request->route('id');
        $customOrder = CustomOrder::find($id);

        if (!$customOrder || $customOrder->status != '4') {
            return redirect()->back()->with('error', 'Pesanan Khusus harus berstatus Sepakat');
        }

        return $next($request);
    }
}
