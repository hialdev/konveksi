<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengajuan Produksi</title>
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
<body>
    <h2>Laporan Pengajuan Produksi</h2>
    <h4 class="text-muted">Dicetak pada : {{\Carbon\Carbon::parse(now())->format('d M Y, H:i:s')}}</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produksi</th>
                <th>Bahan Baku</th>
                <th>Penanggung Jawab</th>
                <th>Status Produksi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $productions = \App\Models\RequestProduction::orderBy('code', 'ASC')->get();
            @endphp
            @foreach ($productions as $production)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>
                        <strong>{{ $production->code }}</strong><br/>
                        <hr>
                        <strong>{{ $production->product->nama }}</strong><br>
                        {{ $production->product->keterangan }}<br />
                        
                        @if($production->cek_pesanan_khusus)<hr><strong>{{ $production->customOrder->code }}</strong>@endif
                    </td>
                    <td>
                        <strong>{{ $production->rawMaterial->nama }}</strong><br>
                        {{ $production->rawMaterial->keterangan }}
                    </td>
                    <td>
                        <strong>{{ $production->pic->name }}</strong><br>
                        {{ $production->pic->email }}
                    </td>
                    <td>
                        <span class="text-muted">Kuantiti</span></br>
                        <strong>{{$production->qty}}</strong><br />
                        <span class="text-muted">Deadline</span></br>
                        <strong>{{\Carbon\Carbon::parse($production->deadline)->format('d M Y')}}</strong><br />
                        <span class="text-muted">Status</span></br>
                        <div class="{{$production->status == 0 ? '' : 'd-none'}} badge bg-secondary rounded-3 fw-semibold fs-2">Menunggu</div>
                        <div class="{{$production->status == 1 ? '' : 'd-none'}} badge bg-warning rounded-3 fw-semibold fs-2">Diproses</div>
                        <div class="{{$production->status == 2 ? '' : 'd-none'}} badge bg-success rounded-3 fw-semibold fs-2">Selesai</div>
                        <span class="text-muted">Lampiran</span></br>
                        <a href="{{'/storage/'.$production->lampiran}}" target="_blank">Lampiran Pengajuan produksi</a><br />
                    </td>
                    <td>{{ $production->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
