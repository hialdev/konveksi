@extends('layouts.base')
@section('css')
@endsection
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pesanan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Semua Pesanan</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="/assets/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 d-flex align-items-center gap-2 justify-content-between">
        <h1>Pesanan</h1>
        <div style="aspect-ratio:1/1; width:3em; height:3em"
            class="bg-primary text-white d-flex align-items-center justify-content-center rounded-5 me-auto">
            {{ count($orders) }}</div>
        <a href="{{ route('product.etalase') }}" class="btn btn-primary btn-al-primary">Buat Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{route('order.index')}}" method="GET">
                <div class="row align-items-end mb-3 flex-wrap">
                    <div class="col-md-4 mb-2">
                        <label for="search" class="form-label">Filter Kata</label>
                        <input type="text" class="form-control" placeholder="Cari Kode / Pelanggan" name="search" value="{{$filter->q ?? ''}}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="field" class="form-label">Urutkan Berdasarkan</label>
                        <select name="field" id="field" class="form-select">
                            @foreach (getModelAttributes('Order', ['Pesanan_kategori_id', 'image', 'slug', 'user_id', 'produk']) as $atr)
                            <option value="{{$atr}}" {{$filter->field == $atr ? 'selected' : ''}}>{{toPascalCase($atr)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="order" class="form-label">Dengan urutan</label>
                        <select name="order" id="order" class="form-select">
                            <option value="newest" {{$filter->order == 'desc' ? 'selected' : ''}}>Terbaru / Terbesar</option>
                            <option value="oldest" {{$filter->order == 'asc' ? 'selected' : ''}}>Terlama / Terkecil</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="d-flex align-items-center gap-1">
                            <button type="submit" class="btn btn-primary w-100" style="white-space: nowrap">Apply</button>
                            <a href="{{url()->current()}}" class="btn btn-secondary" style="white-space: nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2v2a8 8 0 1 0 4.5 1.385V8h-2V2h6v2H18a9.99 9.99 0 0 1 4 8" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table border text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Pesanan</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Pelanggan</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Produk Di Pesan</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Total Harga</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Status</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Timestamp</h6>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column align-items-start" style="width:20em">
                                        <div class="fw-semibold fs-4">
                                            {{ $order->code }}
                                        </div>
                                        <div class="fw-normal text-muted fs-2 line-clamp my-1 line-clamp-2"
                                                style="white-space:normal;">{{ $order->keterangan }}</div>
                                        @if( $order->bukti_pembayaran )
                                        <a href="/storage/{{$order->bukti_pembayaran}}"  target="_blank"
                                            class="mb-1 mt-2 fw-semibold badge bg-primary-subtle text-primary p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                                            style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <i class="ti ti-file fs-4"></i> {{$order->bukti_pembayaran}}
                                        </a>
                                        @else
                                        <a href="{{route('order.payment', $order->id)}}" 
                                            class="mb-1 mt-2 fw-semibold badge bg-danger-subtle text-danger p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                                            style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <i class="ti ti-file fs-4"></i> Upload Bukti Pembayaran
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{$order->customer->image ? '/storage/'.$order->customer->image : '/assets/images/profile/user-2.jpg'}}" class="rounded-circle" width="40"
                                            height="40" />
                                        <div class="ms-3">
                                            <h6 class="fs-4 fw-semibold mb-0">{{$order->customer->name}}</h6>
                                            <span class="fw-normal">{{$order->customer->email}}</span>
                                        </div>
                                    </div>
                                </td>
                                @php
                                    $produks = json_decode($order->produk, true);
                                    $totalPrice = 0;
                                @endphp
                                <td>
                                    <div data-bs-toggle="modal" data-bs-target="#productModal-{{$order->id}}" class="btn btn-primary d-inline-flex align-items-center gap-2 p-1 px-3 rounded-3">
                                        <i class="ti ti-shopping-cart"></i>
                                        {{count($produks)}} Produk
                                    </div>
                                    <!-- Delete Modal -->
                                    <div id="productModal-{{$order->id}}" class="modal fade" tabindex="-1"
                                        aria-labelledby="danger-header-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                            <div class="modal-content p-3 modal-filled">
                                                <div class="modal-header modal-colored-header">
                                                    <h4 class="modal-title" id="danger-header-modalLabel">
                                                        Produk yang Dibeli
                                                    </h4>
                                                    <button type="button" class="btn-close btn-close-light"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body w-100" style="width: fit-content; white-space:normal">
                                                    @foreach ($produks as $item)
                                                        @php
                                                            $produk = \App\Models\Product::find($item['id']);
                                                            $subtotal = $produk->harga * $item['qty'];
                                                            $totalPrice += $subtotal;
                                                            $finalPrice = $totalPrice + ($totalPrice * (int) setting('site.ppn') / 100);
                                                        @endphp
                                                        <div class="d-flex align-items-center justify-content-between gap-3 w-100">
                                                            <img src="{{$produk->image ? '/storage/'.$produk->image : 'https://placehold.co/400'}}" alt="Image Cart of produk {{$produk->title}}" class="d-block rounded-3" style="aspect-ratio:1/1;height:5em">
                                                            <div>
                                                                <h6>{{$produk->nama}}</h6>
                                                                <div class="fw-bold text-primary fs-3 rounded-2">
                                                                    {{formatRupiah($produk->harga)}}
                                                                </div>
                                                            </div>
                                                            <div class="ms-auto fw-bold fs-2 d-inline-flex p-1 px-2 text-right bg-primary-subtle">
                                                                {{ $item['qty'] }} Qty
                                                            </div>
                                                        </div>
                                                        <div class="py-2 d-flex justify-content-between">
                                                            Subtotal
                                                            <div class="fw-bold">
                                                                {{ formatRupiah($subtotal) }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="py-2 d-flex justify-content-between">
                                                        PPN
                                                        <div class="fw-bold">
                                                            {{ setting('site.ppn') }}%
                                                        </div>
                                                    </div>
                                                    <div class="py-2 d-flex justify-content-between">
                                                        Total
                                                        <div class="fw-bold">
                                                            {{ formatRupiah($totalPrice) }}
                                                        </div>
                                                    </div>
                                                    <div class="p-2 rounded-2 bg-primary text-white px-3 d-flex justify-content-between">
                                                        Total
                                                        <div class="fw-bold">
                                                            {{ formatRupiah($finalPrice) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </td>
                                <td>
                                    {{ formatRupiah($order->total_harga) }}    
                                </td>
                                <td>
                                    @switch($order->status)
                                        @case('1')
                                            <div class="p-1 px-2 bg-primary text-white fs-2 rounded-2 d-inline-block">Dibayar</div>
                                            @break
                                        @case('2')
                                            <div class="p-1 px-2 bg-warning text-white fs-2 rounded-2 d-inline-block">Valid - Diproses</div>
                                            <a class="d-block text-dark fs-2">Pelanggan Konfirmasi & Ulas</a>
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
                                            <a href="{{route('order.payment', $order->id)}}" class="d-block text-primary fs-2 text-decoration-underline">Bayar dan Upload</a>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-start gap-2">
                                        <div class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Updated
                                            at
                                            : {{ $order->updated_at }}</div>
                                        <div class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Created
                                            at
                                            : {{ $order->created_at }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if($order->status == '0')
                                            <li>
                                                <a href="{{route('order.payment', $order->id)}}" class="dropdown-item d-flex align-items-center gap-3 text-primary">
                                                    <i class="fs-4 ti ti-credit-card"></i>Bayar & Upload   
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center text-success gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#approveModal-{{$order->id}}">
                                                    <i class="fs-4 ti ti-check"></i>Valid / Proses
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center text-danger gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal-{{$order->id}}">
                                                    <i class="fs-4 ti ti-file-off"></i>Invalid / Tolak
                                                </button>
                                            </li>
                                            @endif
                                            @if($order->status == '1' || $order->status == '3')
                                            <li>
                                                <a href="{{route('order.payment', $order->id)}}" class="dropdown-item d-flex align-items-center gap-3 text-primary">
                                                    <i class="fs-4 ti ti-upload"></i>Beli / Upload Ulang   
                                                </a>
                                            </li>
                                            @endif
                                            

                                            @if($order->status == '5')
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center text-success gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#verifReturModal-{{$order->id}}">
                                                    <i class="fs-4 ti ti-receipt-refund"></i>Verifikasi & Selesaikan Pengembalian
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center text-danger gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#rejectReturModal-{{$order->id}}">
                                                    <i class="fs-4 ti ti-truck-return"></i>Invalid / Tolak Pengembalian
                                                </button>
                                            </li>
                                            @endif
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal-{{$order->id}}">
                                                    <i class="fs-4 ti ti-trash"></i>Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Approve Modal -->
                                    <div class="modal fade" id="approveModal-{{$order->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        Tetapkan Valid / Approve
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0" style="white-space:normal !important">
                                                    <p>Tetapkan pesanan dengan kode <strong>{{$order->code}} sebagai Valid / Approve, Pastikan pembayaran telah diterima dengan baik.</strong></p>
                                                    <form action="{{route('order.approve', $order->id)}}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Approve</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- reject Edit Modal -->
                                    <div class="modal fade" id="rejectModal-{{$order->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        Tetapkan Tidak Valid / Reject
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0" style="white-space:normal !important">
                                                    <p>Tetapkan pesanan dengan kode <strong>{{$order->code}} sebagai Tidak Valid / Tolak, Pastikan semua telah di cek dengan baik.</strong></p>
                                                    <form action="{{route('order.rejected', $order->id)}}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Reject</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($order->retur)
                                    <!-- Verifikasi Retur Modal -->
                                    <div class="modal fade" id="verifReturModal-{{$order->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        Tetapkan Valid / Approve Pengembalian
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0" style="white-space:normal !important">
                                                    <p>Jika pengembalian disetujui, <strong>pastikan solusi pengembalian sudah diterima dengan baik oleh Pelanggan seperti Refund atau Tukar Barang</strong>.</p>
                                                    <form action="{{route('retur.approve', $order->retur->id)}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="lampiran" class="form-label">Lampirkan Bukti Approve Pengembalian</label>
                                                            <input type="file" name="lampiran" id="lampiran" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keterangan" class="form-label">Keterangan</label>
                                                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Setujui dan Selesaikan Pengembalian</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- reject Retur Modal -->
                                    <div class="modal fade" id="rejectReturModal-{{$order->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        Tetapkan Pengembalian Tidak Valid / Reject
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0" style="white-space:normal !important">
                                                    <p>Tetapkan pesanan dengan kode <strong>{{$order->code}} sebagai Tidak Valid / Tolak, Pastikan semua telah di cek dengan baik.</strong></p>
                                                    <form action="{{route('retur.rejected', $order->retur->id)}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="lampiran" class="form-label">Lampirkan Bukti Penolakan</label>
                                                            <input type="file" name="lampiran" id="lampiran" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keterangan" class="form-label">Keterangan Penolakan</label>
                                                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger">Reject / Invalid Pengembalian</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Delete Modal -->
                                    <div id="deleteModal-{{$order->id}}" class="modal fade" tabindex="-1"
                                        aria-labelledby="danger-header-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                            <div class="modal-content p-3 modal-filled bg-danger">
                                                <div class="modal-header modal-colored-header text-white">
                                                    <h4 class="modal-title text-white" id="danger-header-modalLabel">
                                                        Yakin ingin menghapus order ?
                                                    </h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="width: fit-content; white-space:normal">
                                                    <h5 class="mt-0 text-white">Order {{$order->code}} akan dihapus</h5>
                                                    <p class="text-white">Segala data yang berkaitan dengan order tersebut juga akan dihapus secara permanen.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <form action="{{route('order.destroy', $order->id)}}" method="POST">
                                                      @csrf
                                                      @method('delete')
                                                      <button type="submit" class="btn btn-dark">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </td>
                            </tr>

                            @if($order->reviews->count() > 0)
                            <tr>
                                <td colspan="6">
                                    @php
                                        $rating = 0;
                                    @endphp
                                    @foreach ($order->reviews as $review)
                                        @php
                                        $rating += $review->rating;
                                        $avgRating = $rating / $order->reviews->count();
                                        @endphp
                                    @endforeach
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-warning p-1 px-2 h-100 rounded-2 text-white fw-bold">
                                            <i class="ti ti-star"></i>
                                        </div>
                                        <i class="ti ti-star fs-6 text-warning"></i>
                                        Rata Rata Penilaian : {{number_format($avgRating,2)}}
                                        <q class="d-block ms-auto fs-3 line-clamp line-clamp-3 text-italic">{{$order->reviews[0]->keterangan}}</q>
                                    </div>
                                </td>
                            </tr>
                            @endif

                            @if($order->retur)
                            <tr>
                                <td colspan="6">
                                    <div class="accordion-item p-3 border border-danger rounded-3 border-dashed">
                                        <div class="accordion-button d-flex align-items-center justify-content-between gap-2" style="cursor: pointer">
                                            <div class="bg-danger p-1 px-2 h-100 rounded-2 text-white fw-bold d-inline-block">
                                                <i class="ti ti-truck-return"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                Pengembalian <span class="fs-1 text-muted ms-4">Klik untuk melihat detail</span>
                                            </div>
                                            <div class="{{$order->retur->status == '0' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-light-subtle fs-2 rounded-2">Menunggu Pengembalian</div>
                                            <div class="{{$order->retur->status == '1' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-danger text-white fs-2 rounded-2">Tidak Sah</div>
                                            <div class="{{$order->retur->status == '2' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-success text-white fs-2 rounded-2">Terselesaikan</div>
                                        </div>
                                        <div class="accordion-content row mt-2" style="display: none;">
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column align-items-start gap-1 ">
                                                    <div class="fs-2 text-muted">Tanggapan Pengembalian</div>
                                                    <div class="fs-2 line-clamp line-clamp-2">{{$order->retur->keterangan_aksi ?? 'Telah diterima dan diputuskan sesuai syarat dan ketentuan pengembalian'}}</div>
                                                    <a href="{{'/storage/'.$order->retur->lampiran_aksi}}" target="_blank" class="btn btn-sm btn-light mt-2 fs-2 d-flex align-items-center gap-2">
                                                        <i class="ti ti-file"></i>
                                                        Lihat Bukti
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-end text-end flex-column gap-1">
                                                    <div class="fs-2 text-muted">Alasan Pengembalian</div>
                                                    <div class="fs-2 text-dark"><q>{{$order->retur->keterangan}}</q></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    // Menangani klik pada setiap tombol accordion dalam loop
    $('.accordion-button').click(function() {
        // Cari konten yang terkait dengan tombol yang diklik
        const content = $(this).closest('.accordion-item').find('.accordion-content');
        content.slideToggle();
    });
});
</script>
@endsection
