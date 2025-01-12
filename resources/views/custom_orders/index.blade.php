@extends('layouts.base')
@section('css')
@endsection
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pesanan Khusus</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Semua Pesanan Khusus</li>
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
        <h1>Pesanan Khusus</h1>
        <div style="aspect-ratio:1/1; width:3em; height:3em"
            class="bg-primary text-white d-flex align-items-center justify-content-center rounded-5 me-auto">
            {{ count($custom_orders) }}</div>
        <a href="{{ route('custom-order.add') }}" class="btn btn-primary btn-al-primary">Buat Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{route('custom-order.index')}}" method="GET">
                <div class="row align-items-end mb-3 flex-wrap">
                    <div class="col-md-4 mb-2">
                        <label for="search" class="form-label">Filter Kata</label>
                        <input type="text" class="form-control" placeholder="Cari Kode / Pelanggan" name="search" value="{{$filter->q ?? ''}}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="field" class="form-label">Urutkan Berdasarkan</label>
                        <select name="field" id="field" class="form-select">
                            @foreach (getModelAttributes('CustomOrder', ['bahan_baku_id', 'lampiran', 'lampiran_bahan', 'cek_bahan_dari_pelanggan', 'produk_id', 'user_id']) as $atr)
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
                                <h6 class="fs-3 fw-semibold mb-0">Pesanan Khusus</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Bahan Baku</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Produk yang Dibuat</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Pelanggan</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Status</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Status Produksi</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Pembayaran</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Timestamp</h6>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($custom_orders as $corder)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column align-items-start" style="width:20em">
                                        <div class="fw-semibold fs-4">
                                            {{ $corder->code }}
                                        </div>
                                        <div class="fw-semibold text-muted">
                                            {{ $corder->qty }} Qty
                                        </div>
                                        
                                        <div class="mb-1 mt-2 fw-semibold badge bg-danger p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                                            style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <i class="ti ti-clock fs-4"></i> {{\Carbon\Carbon::parse($corder->deadline)->format('d M Y')}}
                                        </div>
                                        <a href="{{$corder->lampiran ? '/storage/'.$corder->lampiran : '#'}}"  target="_blank"
                                            class="mb-1 mt-2 fw-semibold badge {{$corder->lampiran ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger'}} p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                                            style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <i class="ti ti-file fs-4"></i> {{$corder->lampiran ?? 'Tidak ada lampiran'}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @if($corder->bahan_baku_id != null)
                                    <div class="d-flex align-items-center" style="width:20em">
                                        <img src="{{ $corder->rawMaterial->image ? asset('storage/' . $corder->rawMaterial->image) : '/assets/images/profile/user-1.jpg' }}"
                                            class="rounded-2" alt="Raw Material Image {{ $corder->rawMaterial->nama }}" style="width: 4em" />
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-1">{{ $corder->rawMaterial->nama }}</h6>
                                            <span class="fw-normal line-clamp line-clamp-3"
                                                style="white-space:normal; font-size:13px; ">{{ $corder->rawMaterial->keterangan }}</span>
                                        </div>
                                    </div>
                                    @else
                                    <div class="badge bg-primary fs-2 mb-2">Bahan dari Pelanggan</div>
                                    <div class="d-flex align-items-center" style="width:20em">
                                        <img src="{{ $corder->lampiran_bahan ? asset('storage/' . $corder->lampiran_bahan) : '/assets/images/profile/user-1.jpg' }}"
                                            class="rounded-2 me-3 {{!isImage($corder->lampiran_bahan) ? 'd-none' : ''}}" alt="Raw Material Image {{ $corder->rawMaterial?->nama }}" style="width: 4em" />
                                        <div class="">
                                            <h6 class="fw-semibold mb-1">{{ $corder->nama_bahan }}</h6>
                                            <span class="fw-normal line-clamp line-clamp-3"
                                                style="white-space:normal; font-size:13px; ">{{ $corder->keterangan_bahan }}</span>
                                        </div>
                                    </div>
                                    <a href="{{$corder->lampiran_bahan ? '/storage/'.$corder->lampiran_bahan : '#'}}"  target="_blank"
                                        class="mb-1 mt-2 fw-semibold badge {{$corder->lampiran_bahan ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger'}} p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                                        style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <i class="ti ti-file fs-4"></i> {{$corder->lampiran_bahan ?? 'Tidak ada lampiran'}}
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" style="width:20em">
                                        <img src="{{ $corder->product->image ? asset('storage/' . $corder->product->image) : '/assets/images/profile/user-1.jpg' }}"
                                            class="rounded-2" alt="Raw Material Image {{ $corder->product->nama }}" style="width: 4em" />
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-1">{{ $corder->product->nama }}</h6>
                                            <span class="fw-normal line-clamp line-clamp-3"
                                                style="white-space:normal; font-size:13px; ">{{ $corder->product->keterangan }}</span>
                                        </div>
                                    </div>
                                    <div class="fw-normal text-muted fs-2 line-clamp my-1 line-clamp-3"
                                                style="white-space:normal;">{{ $corder->keterangan }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" style="width:20em">
                                        <img src="{{ $corder->customer->image ? asset('storage/' . $corder->customer->image) : '/assets/images/profile/user-1.jpg' }}"
                                            class="rounded-2" alt="Raw Material Image {{ $corder->customer->name }}" style="width: 4em" />
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-1">{{ $corder->customer->name }}</h6>
                                            <div class="fw-normal line-clamp line-clamp-3"
                                                style="white-space:normal; font-size:13px; ">{{ $corder->customer->email }}</div>
                                            <div class="fw-normal line-clamp line-clamp-3"
                                                style="white-space:normal; font-size:13px; ">{{ $corder->customer->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="{{$corder->status == 0 ? '' : 'd-none'}} badge bg-light text-dark rounded-3 fw-semibold fs-2">Menunggu Harga</div>
                                    <div class="{{$corder->status == 1 ? '' : 'd-none'}} badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Harga Ditetapkan</div>
                                    <div class="{{$corder->status == 2 ? '' : 'd-none'}} badge bg-warning rounded-3 fw-semibold fs-2">Pengajuan Nego</div>
                                    <div class="{{$corder->status == 3 ? '' : 'd-none'}} badge bg-danger rounded-3 fw-semibold fs-2">Tidak Sepakat</div>
                                    <div class="{{$corder->status == 4 ? '' : 'd-none'}} badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Sepakat & Dikerjakan</div>
                                    <div class="{{$corder->status == 5 ? '' : 'd-none'}} badge bg-success rounded-3 fw-semibold fs-2">Selesai</div>
                                </td>
                                <td>
                                    <div class="{{$corder->production == null ? '' : 'd-none'}} badge bg-danger-subtle text-danger rounded-3 fw-semibold fs-2">Belum Diajukan Produksi</div>
                                    <div class="{{$corder->production?->status == '0' ? '' : 'd-none'}} badge bg-light text-dark rounded-3 fw-semibold fs-2">Menunggu Produksi</div>
                                    <div class="{{$corder->production?->status == 1 ? '' : 'd-none'}} badge bg-warning rounded-3 fw-semibold fs-2">Sedang Diproduksi</div>
                                    <div class="{{$corder->production?->status == 2 ? '' : 'd-none'}} badge bg-success rounded-3 fw-semibold fs-2">Selesai Diproduksi</div>
                                </td>
                                <td>
                                    @if($corder->status == '4')
                                        <div class="mb-2">
                                            <div class="fs-1">Total Harga</div>
                                            <div class="fs-3 fw-bold text-primary">{{formatRupiah($corder->total_harga)}}</div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="fs-1">Pembayaran Valid</div>
                                            <div class="fs-3 fw-bold text-success">{{formatRupiah($corder->remaining_payment ? $corder->total_harga - $corder->remaining_payment : $corder->total_harga)}}</div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="fs-1">Sisa</div>
                                            <div class="fs-3 fw-bold text-danger">{{formatRupiah($corder->remaining_payment)}}</div>
                                        </div>
                                    @else
                                        <div class="text-danger fw-bold fs-2" style="max-width: 13em; white-space:normal">
                                            Pembayaran tidak bisa dilakukan sebelum Harga Disepakati
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-start gap-2">
                                        <div class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Updated
                                            at
                                            : {{ $corder->updated_at }}</div>
                                        <div class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Created
                                            at
                                            : {{ $corder->created_at }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if($corder->status == 0)
                                            <li>
                                                <button type="button" class="dropdown-item d-flex text-primary align-items-center gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#putPriceModal-{{$corder->id}}"><i
                                                        class="fs-4 ti ti-tag"></i>Tetapkan Harga</button>
                                            </li>
                                            @endif

                                            @if($corder->status == '5')
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center text-success gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#verifReturModal-{{$corder->id}}">
                                                    <i class="fs-4 ti ti-receipt-refund"></i>Verifikasi & Selesaikan Pengembalian
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center text-danger gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#rejectReturModal-{{$corder->id}}">
                                                    <i class="fs-4 ti ti-truck-return"></i>Invalid / Tolak Pengembalian
                                                </button>
                                            </li>
                                            @endif

                                            <li>
                                                <a href="{{route('custom-order.payment.index', $corder->id)}}" class="dropdown-item d-flex text-primary align-items-center gap-3"><i
                                                        class="fs-4 ti ti-credit-card"></i>Pembayaran</a>
                                            </li>
                                            <li>
                                                <a href="{{route('custom-order.edit', $corder->id)}}" class="dropdown-item d-flex align-items-center gap-3"><i
                                                        class="fs-4 ti ti-edit"></i>Edit</a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal-{{$corder->id}}"><i
                                                        class="fs-4 ti ti-trash"></i>Delete</button>
                                            </li>
                                        </ul>
                                    </div>

                                    @if($corder->status != 2)
                                    <!-- Process Modal -->
                                    <div class="modal fade" id="processModal-{{$corder->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content {{$corder->status == 0 ? 'bg-warning-subtle' : 'bg-success-subtle'}}">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        {{$corder->status == 0 ? 'Proses Permintaan' : 'Selesaikan Permintaan'}} {{$corder->code}}
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Put Price Modal -->
                                    <div class="modal fade" id="putPriceModal-{{$corder->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        Tetapkan Harga
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0" style="white-space:normal !important">
                                                    <p>Tetapkan harga untuk Pesanan Khusus <strong>{{ $corder->code }}, Pastikan harga tersebut adalah harga keseluruhan untuk memproduksi Pesanan Khusus</strong></p>
                                                    <form action="{{route('custom-order.putPrice', $corder->id)}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="harga" class="form-label">Harga</label>
                                                            <input type="text" name="harga" id="harga" class="form-control input-rupiah" placeholder="Rp ">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keterangan" class="form-label">Keterangan</label>
                                                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary w-100">Tetapkan Harga</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete Modal -->
                                    <div id="deleteModal-{{$corder->id}}" class="modal fade" tabindex="-1"
                                        aria-labelledby="danger-header-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                            <div class="modal-content p-3 modal-filled bg-danger">
                                                <div class="modal-header modal-colored-header text-white">
                                                    <h4 class="modal-title text-white" id="danger-header-modalLabel">
                                                        Yakin ingin menghapus Pesanan Khusus ({{$corder->code}}) ?
                                                    </h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="width: fit-content; white-space:normal">
                                                    <h5 class="mt-0 text-white">Pesanan Khusus {{$corder->code}} akan dihapus</h5>
                                                    <p class="text-white">Segala data yang berkaitan dengan Pesanan Khusus tersebut juga akan dihapus secara permanen.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <form action="{{route('custom-order.destroy', $corder->id)}}" method="POST">
                                                      @csrf
                                                      @method('delete')
                                                      <button type="submit" class="btn btn-dark">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->

                                        @if($corder->retur)
                                        <!-- Verifikasi Retur Modal -->
                                        <div class="modal fade" id="verifReturModal-{{$corder->id}}" tabindex="-1"
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
                                                        <form action="{{route('retur.approve', $corder->retur->id)}}" method="post" enctype="multipart/form-data">
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
                                        <div class="modal fade" id="rejectReturModal-{{$corder->id}}" tabindex="-1"
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
                                                        <p>Tetapkan pesanan dengan kode <strong>{{$corder->code}} sebagai Tidak Valid / Tolak, Pastikan semua telah di cek dengan baik.</strong></p>
                                                        <form action="{{route('retur.rejected', $corder->retur->id)}}" method="post" enctype="multipart/form-data">
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
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="8">
                                    <div class="bg-light p-3 rounded-3">
                                        <div class="d-flex align-items-center gap-4">
                                            <div>
                                                <h6 class="fs-3 mb-0">Penentuan Harga</h6>
                                                <p class="fs-2 text-muted mb-0" style="max-width: 20em; white-space:normal">Pesanan khusus membutuhkan perhitungan harga dan kesepakatan harga</p>
                                            </div>
                                            <div class="">
                                                <div class="fs-4 fw-bold text-primary mb-2">{{formatRupiah($corder->total_harga)}}</div>
                                                <button class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#negoModal-{{$corder->id}}"
                                                >Lihat Penetapan Harga</button>
                                                
                                            
                                                <!-- Detail Nego Harga Modal -->
                                                <div class="modal fade" id="negoModal-{{$corder->id}}" tabindex="-1"
                                                    aria-labelledby="vertical-center-modal" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header d-flex align-items-center">
                                                                <h4 class="modal-title" id="myLargeModalLabel">
                                                                    Detail Negoisasi / Penetapan Harga
                                                                </h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body pt-0" style="white-space:normal !important">
                                                                <div class="p-3 mb-2 border border-primary rounded-3 border-dashed">
                                                                    <div class="fs-1 text-muted">Penetapan dari Konveksi</div>
                                                                    <div class="fs-4 fw-bold text-primary">{{formatRupiah($corder->total_harga)}}</div>
                                                                    <div class="fs-2">{{$corder->keterangan_konveksi ?? 'Tidak ada keterangan'}}</div>
                                                                </div>
                                                                <div class="p-3 border border-secondary rounded-3 border-dashed">
                                                                    <div class="fs-1 text-muted">Tanggapan Pelanggan</div>
                                                                    <div class="fs-2">{{$corder->keterangan_pelanggan ?? 'Belum ada keterangan'}}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($corder->status == '4')
                                                <div>
                                                    <a href="{{route('custom-order.payment.index', $corder->id)}}" class="d-flex mb-1 btn-sm align-items-center gap-2 btn btn-primary btn-al-primary">
                                                        <i class="fs-4 ti ti-credit-card"></i>Kelola Pembayaran
                                                    </a>
                                                    @role(['admin', 'developer', 'pegawai'])
                                                    <a href="{{route('request_production.add', ['rawid' => $corder->bahan_baku_id ?? '' ,'customid' => $corder->id, 'productid' => $corder->produk_id, 'qty' => $corder->qty, 'deadline' => $corder->deadline, 'description' => $corder->keterangan])}}" class="d-flex btn-sm align-items-center gap-2 btn btn-primary">
                                                        <i class="fs-4 ti ti-wand"></i>Ajukan Produksi
                                                    </a>
                                                    @endrole
                                                </div>
                                            @endif

                                            <div class="bg-primary" style="width:1px !important; height: 3em;">
                                            </div>

                                            <div class="d-flex align-items-center gap-2">
                                                @role(['admin', 'developer', 'employee'])
                                                <button type="button" class="d-flex btn-sm align-items-center gap-2 btn btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#putPriceModal-{{$corder->id}}"><i
                                                        class="fs-4 ti ti-tag"></i>Tetapkan Harga</button>
                                                @endrole
                                                @role(['pelanggan', 'developer'])
                                                <button type="button" class="d-flex btn-sm align-items-center gap-2 btn btn-warning"
                                                    data-bs-toggle="modal" data-bs-target="#negoHargaModal-{{$corder->id}}"><i
                                                        class="fs-4 ti ti-tag"></i>Nego Harga</button>
                                                @endrole
                                                <button type="button" class="d-flex btn-sm align-items-center gap-2 btn btn-success"
                                                    data-bs-toggle="modal" data-bs-target="#okModal-{{$corder->id}}"><i
                                                        class="fs-4 ti ti-check"></i>Sepakat & Produksi</button>
                                                <button type="button" class="d-flex btn-sm align-items-center gap-2 btn btn-outline-danger"
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal-{{$corder->id}}"><i
                                                        class="fs-4 ti ti-file-off"></i>Tolak</button>
                                            </div>
                                        </div>
                                    </div>

                                    @role(['pelanggan', 'developer'])
                                    <!-- Nego Modal -->
                                    <div class="modal fade" id="negoHargaModal-{{$corder->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        Nego Harga
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0" style="white-space:normal !important">
                                                    <p>Negoisasi harga Pesanan Khusus <strong>{{ $corder->code }}, Bijaklah dalam menentukan harga. Tulis semuanya di kolum keterangan</strong></p>
                                                    <div class="fs-4 fw-bold text-primary mb-2">Harga Terkini {{formatRupiah($corder->total_harga)}}</div>
                                                    <form action="{{route('custom-order.nego', $corder->id)}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="keterangan" class="form-label">Keterangan</label>
                                                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-warning w-100">Negoisasi Harga</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endrole

                                    <!-- Sepakat Modal -->
                                    <div class="modal fade" id="okModal-{{$corder->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        Sepakati Harga
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0" style="white-space:normal !important">
                                                    <p>Sepakati harga sebesar {{formatRupiah($corder->total_harga)}} untuk Pesanan Khusus ini ({{$corder->code}}) ?</p>
                                                    <form action="{{route('custom-order.approve', $corder->id)}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success w-100">Sepakat</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal-{{$corder->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        Tolak Penetapan Harga
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0" style="white-space:normal !important">
                                                    <p>Tolak penetapan harga sebesar {{formatRupiah($corder->total_harga)}} untuk Pesanan Khusus ini ({{$corder->code}}) ?</p>
                                                    <form action="{{route('custom-order.rejected', $corder->id)}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger w-100">Tolak Penetapan Harga</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            @if($corder->retur)
                            <tr>
                                <td colspan="8">
                                    <div class="accordion-item p-3 border border-danger rounded-3 border-dashed">
                                        <div class="accordion-button d-flex align-items-center justify-content-between gap-2" style="cursor: pointer">
                                            <div class="bg-danger p-1 px-2 h-100 rounded-2 text-white fw-bold d-inline-block">
                                                <i class="ti ti-truck-return"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                Pengembalian <span class="fs-1 text-muted ms-4">Klik untuk melihat detail</span>
                                            </div>
                                            <div class="{{$corder->retur->status == '0' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-light-subtle fs-2 rounded-2">Menunggu Pengembalian</div>
                                            <div class="{{$corder->retur->status == '1' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-danger text-white fs-2 rounded-2">Tidak Sah</div>
                                            <div class="{{$corder->retur->status == '2' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-success text-white fs-2 rounded-2">Terselesaikan</div>
                                        </div>
                                        <div class="accordion-content row mt-2" style="display: none;">
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column align-items-start gap-1 ">
                                                    <div class="fs-2 text-muted">Tanggapan Pengembalian</div>
                                                    <div class="fs-2 line-clamp line-clamp-2">{{$corder->retur->keterangan_aksi ?? 'Telah diterima dan diputuskan sesuai syarat dan ketentuan pengembalian'}}</div>
                                                    <a href="{{'/storage/'.$corder->retur->lampiran_aksi}}" target="_blank" class="btn btn-sm btn-light mt-2 fs-2 d-flex align-items-center gap-2">
                                                        <i class="ti ti-file"></i>
                                                        Lihat Bukti
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-end text-end flex-column gap-1">
                                                    <div class="fs-2 text-muted">Alasan Pengembalian</div>
                                                    <div class="fs-2 text-dark"><q>{{$corder->retur->keterangan}}</q></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif

                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
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
