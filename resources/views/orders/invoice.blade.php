<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            width: 100%;
            border: 1px solid #000;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .info-table, .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td, .product-table th, .product-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .info-table th {
            background-color: #f0f0f0;
        }
        .product-table th {
            background-color: #dcdcdc;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>

<div class="">
    <div class="header">
        <h1>Invoice</h1>
        <p>Pesanan: <strong>{{$data->code}}</strong></p>
        <p>Kepada: <strong>{{$data->customer->name}} - {{$data->customer->email}}</strong></p>
        <p style="font-size: 12px"><a href="{{env('APP_URL')}}">Butik Rahmat Collection</a></p>
    </div>

    <!-- Info Pesanan -->
    <table class="info-table">
        <tr>
            <th>Status</th>
            <td>
              @switch($data->status)
                @case('1')
                    <div class="p-1 px-2 bg-primary text-white fs-2 rounded-2 d-inline-block">Dibayar</div>
                    @break
                @case('2')
                    <div class="p-1 px-2 bg-warning text-white fs-2 rounded-2 d-inline-block">Valid - Diproses</div>
                    @break
                @case('3')
                    <div class="p-1 px-2 bg-danger text-white fs-2 rounded-2 d-inline-block mb-1">Invalid</div>
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
        <tr>
            <th>Timestamp</th>
            <td>
                Terakhir diperbarui pada {{\Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i:s')}}<br>
                Dibuat pada {{\Carbon\Carbon::parse($data->created_at)->format('d M Y H:i:s')}}
            </td>
        </tr>
    </table>

    <!-- Produk yang Dibeli -->
    <h4>Produk yang Dibeli</h4>
    <table class="product-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $produks = json_decode($data->produk);
                $totalPrice = 0;
            @endphp
            @foreach ($produks as $item)
            <tr>
                @php
                    $produk = \App\Models\Product::find($item->id);
                    $subtotal = $produk ? $produk->harga * $item->qty : 0;
                    $totalPrice += $subtotal;
                    $finalPrice = $totalPrice + ($totalPrice * (int) setting('site.ppn') / 100);
                @endphp
                @if($produk)
                  <td>
                      <div>{{$produk->nama}}</div>
                  </td>
                  <td class="fw-bold text-primary fs-3 rounded-2">
                      {{formatRupiah($produk->harga)}}
                  </td>
                  <td class="d-flex align-items-center justify-content-between gap-3 w-100">
                      {{ $item->qty }}
                  </td>
                  <td class="py-2 d-flex justify-content-between">
                      <div class="fw-bold">
                          {{ formatRupiah($subtotal) }}
                      </div>
                  </td>
                @endif
            </tr>
            @endforeach            
        </tbody>
        <tfoot>
            <tr class="py-2 d-flex justify-content-between">
                <td colspan="3">PPN</td>
                <td class="fw-bold">
                    {{ setting('site.ppn') }}%
                </td>
            </tr>
            <tr class="py-2 d-flex justify-content-between">
                <td colspan="3">Total</td>
                <td class="fw-bold">
                    {{ formatRupiah($totalPrice) }}
                </td>
            </tr>
            <tr class="p-2 rounded-2 bg-primary text-white px-3 d-flex justify-content-between">
                <td colspan="3">Grand Total</td>
                <td class="fw-bold">
                    {{ formatRupiah($finalPrice) }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Terima kasih telah berbelanja!</p>
    </div>
</div>

</body>
</html>
