<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran {{$data->code}}</title>
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
        .d-none{
            display: none;
        }
    </style>
</head>
<body>

<div class="">
    <div class="header">
        <h1>Kwitansi Pembayaran</h1>
        <p>Pesanan: <strong>{{$data->code}}</strong></p>
        <p>Kepada: <strong>{{$data->customer->name}} - {{$data->customer->email}}</strong></p>
        <p style="font-size: 12px"><a href="{{env('APP_URL')}}">Butik Rahmat Collection</a></p>
    </div>
    
    <h4>Status Pembayaran</h4>
    <table class="product-table">
    @if((int) $data->status >= 4)
        <tr class="mb-2">
            <th class="fs-1">Total Harga</th>
            <td class="fs-3 fw-bold text-primary">{{formatRupiah($data->total_harga)}}</td>
        </tr>
        <tr class="mb-2">
            <th class="fs-1">Pembayaran Valid</th>
            <td class="fs-3 fw-bold text-success">{{formatRupiah($data->remaining_payment ? $data->total_harga - $data->remaining_payment : $data->total_harga)}}</td>
        </tr>
        <tr class="mb-2">
            <th class="fs-1">Sisa</th>
            <td class="fs-3 fw-bold text-danger">{{formatRupiah($data->remaining_payment)}}</td>
        </tr>
    @else
        <tr class="text-danger fw-bold fs-2" style="max-width: 13em; white-space:normal">
            <td colspan="3">
            Pembayaran tidak bisa dilakukan sebelum Harga Disepakati
            </td>
        </tr>
    @endif
    </table>

    <h4>Detail Pembayaran</h4>
    <table class="product-table">
    @if((int) $data->status >= 4)
        <tr class="mb-2">
            <th class="fs-1">Tgl Pembayaran</th>
            <th class="fs-1">Bukti Pembayaran</th>
            <th class="fs-1">Total Pembayaran</th>
            <th class="fs-1">Status</th>
        </tr>
        @foreach ($data->payments as $payment)
            <tr class="mb-2">
                <td class="fs-3">{{date('d-m-Y', strtotime($payment->created_at))}}</td>
                <td class="fs-3"><a href="{{asset('storage/'. $payment->bukti_pembayaran)}}" target="_blank">Lihat Bukti</a></td>
                <td class="fs-3">
                  {{formatRupiah($payment->total_dibayar)}}
                </td>
                <td>
                  <div class="{{$payment->status == '0' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-light-subtle fs-2 rounded-2">Menunggu Konfirmasi</div>
                  <div class="{{$payment->status == '1' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-danger text-white fs-2 rounded-2">Tidak Sah</div>
                  <div class="{{$payment->status == '2' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-success text-white fs-2 rounded-2">Terkonfirmasi</div>
                </td>
            </tr>
        @endforeach
    @else
        <tr class="text-danger fw-bold fs-2" style="max-width: 13em; white-space:normal">
            <td colspan="3">
            Belum ada pembayaran yang dilakukan
            </td>
        </tr>
    @endif
    </table>

    <div class="footer">
        <p>Terima kasih telah mempercayai kami!</p>
    </div>
</div>

</body>
</html>
