<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian Bahan Baku</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Pembelian Bahan Baku</h2>
    <table>
        <thead>
            <tr>
                <th>Tgl Pembelian</th>
                <th>Bahan Baku</th>
                <th>Supplier</th>
                <th>Penanggung Jawab</th>
                <th>Total Harga Beli</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $purchases = \App\Models\PurchaseRawMaterial::orderBy('tgl_pembelian')->get();
            @endphp
            @foreach ($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->tgl_pembelian }}</td>
                    <td>
                        <strong>{{ $purchase->rawMaterial->nama }}</strong><br>
                        {{ $purchase->rawMaterial->keterangan }}
                    </td>
                    <td>
                        <strong>{{ $purchase->supplier->nama }}</strong><br>
                        {{ $purchase->supplier->email }}<br/>
                        {{ $purchase->supplier->keterangan }}
                    </td>
                    <td>
                        <strong>{{ $purchase->user->name }}</strong><br>
                        {{ $purchase->user->email }}
                    </td>
                    <td>{{ formatRupiah($purchase->total_harga_beli) }}</td>
                    <td>{{ $purchase->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
