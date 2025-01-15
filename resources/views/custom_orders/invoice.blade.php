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
                <div style="{{$data->status == 0 ? '' : 'display:none'}}">Menunggu Harga</div>
                <div style="{{$data->status == 1 ? '' : 'display:none'}}">Harga Ditetapkan</div>
                <div style="{{$data->status == 2 ? '' : 'display:none'}}">Pengajuan Nego</div>
                <div style="{{$data->status == 3 ? '' : 'display:none'}}">Tidak Sepakat</div>
                <div style="{{$data->status == 4 ? '' : 'display:none'}}">Sepakat & Dikerjakan</div>
                <div style="{{$data->status == 5 ? '' : 'display:none'}}">Selesai</div>
            </td>
        </tr>
        <tr>
            <th>Status Produksi</th>
            <td>
                <div style="{{$data->production == null ? '' : 'display:none'}}">Belum Diajukan Produksi</div>
                <div style="{{$data->production?->status == '0' ? '' : 'display:none'}}">Menunggu Produksi</div>
                <div style="{{$data->production?->status == 1 ? '' : 'display:none'}}">Sedang Diproduksi</div>
                <div style="{{$data->production?->status == 2 ? '' : 'display:none'}}">Selesai Diproduksi</div>
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

    <!-- Detail Permintaan -->
    <h4>Detail Permintaan</h4>
    <table class="product-table">
        <tr>
            <th>Bahan Baku</th>
            <td>
                @if($data->cek_bahan_dari_pelanggan)
                    <p style="font-size: 12px"><a href="{{'/storage/'.$data->lampiran_bahan}}">{{$data->lampiran_bahan ?? 'Tidak ada lampiran bahan'}}</a></p>
                    <div>{{$data->nama_bahan}}</div>
                    <div>{{$data->keterangan_bahan}}</div>
                @else
                    <div>{{$data->rawMaterial->nama}}</div>
                    <div>{{$data->rawMaterial->merek}}</div>
                    <div>{{$data->rawMaterial->warna}}</div>
                    <div>{{$data->rawMaterial->ketrangan}}</div>
                @endif
            </td>
        </tr>
        <tr>
            <th>Produk yang akan dibuat</th>
            <td>
                <div>{{$data->product->nama}}</div>
                <div>{{$data->product->keterangan}}</div>
            </td>      
        </tr>
        <tr>
            <th>Konsep / Desain Produk</th>
            <td>
                <p style="font-size: 12px"><a href="{{'/storage/'.$data->lampiran}}">{{$data->lampiran ?? 'Tidak ada lampiran konsep desain'}}</a></p>
                <div>{{$data->desain->nama}}</div>
                <div>{{$data->desain->keterangan}}</div>
            </td>      
        </tr>
        <tr>
            <th>Sebanyak (Qty)</th>
            <td>
                <div>{{$data->qty}}</div>
            </td>      
        </tr>
        <tr>
            <th>Masa Tenggat (Deadline)</th>
            <td>
                <div>{{$data->deadline}}</div>
            </td>      
        </tr>
        <tr class="p-2 rounded-2 bg-primary text-white px-3 d-flex justify-content-between">
            <th>Total</th>
            <td class="fw-bold">
                {{ $data->total_harga ? formatRupiah($data->total_harga) : 'Belum ditentukan' }}
            </td>
        </tr>
    </table>
    
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

    <div class="footer">
        <p>Terima kasih telah mempercayai kami!</p>
    </div>
</div>

</body>
</html>
