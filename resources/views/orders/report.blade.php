<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pesanan Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, h4 { text-align: center; }
        .text-muted { color: #7c7c7c; font-size: 10px}
        .d-none {display: none}
    </style>
</head>
@php
    $start = request()->start;
    $end = request()->end;

    $query = \App\Models\Order::orderBy('code', 'ASC');
    if ($start && $end) {
        $query->whereBetween('created_at', [$start, $end]);
    }
    $orders = $query->get();
@endphp
<body>
    <h2>Laporan Pesanan Barang</h2>
    @if($start && $end)<h3 class="text-center" style="text-align: center;">{{\Carbon\Carbon::parse($start)->format('d F Y')}} s.d {{\Carbon\Carbon::parse($end)->format('d F Y')}}</h3>@endif
    <h4 class="text-muted">Dicetak pada : {{\Carbon\Carbon::parse(now())->format('d M Y, H:i:s')}}</h4>
    <table>
        <thead>
            <tr>
                <th>Tgl Pembelian</th>
                <th>Kode</th>
                <th>Produk</th>
                <th>Total Harga (+PPN)</th>
                <th>Pembeli</th>
                <th>Status Produksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>
                        {{\Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i:s')}}
                    </td>
                    <td>
                        <strong>{{ $order->code }}</strong><br/>
                        <a href="/storage/{{$order->bukti_pembayaran}}"  target="_blank"
                            class="" 
                            style="">
                            Bukti Pembayaran
                        </a>
                    </td>
                    <td>
                        @php
                            $products = (object) json_decode($order->produk);    
                        @endphp
                        @foreach ($products as $item)
                        @php
                            $product = \App\Models\Product::find($item->id);    
                        @endphp
                        <strong>{{ $product->nama }}</strong> x {{$item->qty}}<br>
                        @endforeach
                    </td>
                    <td>
                        <strong>{{ formatRupiah($order->total_harga) }}</strong><br>
                    </td>
                    <td>
                        <strong>{{ $order->customer->name }}</strong><br>
                        {{ $order->customer->email }}
                    </td>
                    <td>
                        <span class="text-muted">Status</span></br>
                        @switch($order->status)
                            @case('1')
                                <div class="p-1 px-2 bg-primary text-white fs-2 rounded-2 d-inline-block">Dibayar</div>
                                @break
                            @case('2')
                                <div class="p-1 px-2 bg-warning text-white fs-2 rounded-2 d-inline-block">Valid - Diproses</div>
                                @break
                            @case('3')
                                <div class="p-1 px-2 bg-danger text-white fs-2 rounded-2 d-inline-block mb-1">Invalid</div>
                                <a href="{{route('order.payment', $order->id)}}" class="d-block text-primary fs-2 text-decoration-underline">Beli / Upload Ulang</a>
                                @break
                            @case('4')
                                <div class="p-1 px-2 bg-success text-white fs-2 rounded-2 d-inline-block">Selesai</div>
                                @break
                            @case('5')
                                <div class="p-1 px-2 bg-danger text-white fs-2 rounded-2 d-inline-block mb-1">Pengembalian</div>
                                @break
                            @default
                                <div class="p-1 px-2 bg-light-subtle fs-2 rounded-2 mb-2">Menunggu Pembayaran</div>
                        @endswitch
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data yang dapat ditampilkan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
