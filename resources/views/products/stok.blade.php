<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Stok Produk</h2>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @php
                $products = \App\Models\Product::with('stock')->get();
                $sortedProducts = $products->sortBy(fn($product) => $product->stock->stok ?? 0);
            @endphp
            @foreach ($sortedProducts as $product)
                <tr>
                    <td>
                        <strong>{{ $product->nama }}</strong><br>
                        {{ $product->keterangan }}
                    </td>
                    <td>{{ $product->stock->stok }}</td>
                    <td>{{ formatRupiah($product->harga) }}</td>
                    <td>
                        Dibuat: {{ $product->created_at->format('d-m-Y H:i') }} <br>
                        Diperbarui: {{ $product->stock->updated_at->format('d-m-Y H:i') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
