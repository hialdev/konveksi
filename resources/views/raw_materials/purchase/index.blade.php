@extends('layouts.base')
@section('css')
@endsection
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pembelian Bahan Baku</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Semua Pembelian Bahan Baku</li>
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
        <h1>Purchase Bahan Baku</h1>
        <div style="aspect-ratio:1/1; width:3em; height:3em"
            class="bg-primary text-white d-flex align-items-center justify-content-center rounded-5 me-auto">
            {{ count($purchases) }}</div>
        <a href="{{ route('raw_material.purchase.add') }}" class="btn btn-primary btn-al-primary">Tambah</a>
        <a href="{{route('pdf.preview.blade', ['bladePath' => 'raw_materials.purchase.report'])}}" target="_blank" class="btn btn-danger"><i class="ti ti-file-download me-2"></i>Laporan Pembelian</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{route('raw_material.purchase.index')}}" method="GET">
                <div class="row align-items-end mb-3 flex-wrap">
                    <div class="col-md-4 mb-2">
                        <label for="search" class="form-label">Filter Kata</label>
                        <input type="text" class="form-control" placeholder="Cari Kode / Nama Supplier / Bahan Baku / Deskripsi" name="search" value="{{$filter->q ?? ''}}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="field" class="form-label">Urutkan Berdasarkan</label>
                        <select name="field" id="field" class="form-select">
                            <option value="supplier" {{$filter->field == 'supplier' ? 'selected' : ''}}>Supplier</option>
                            <option value="raw_material" {{$filter->field == 'raw_material' ? 'selected' : ''}}>Bahan Baku</option>
                            @foreach (getModelAttributes('PurchaseRawMaterial', ['supplier_id', 'bahan_baku_id', 'user_id']) as $atr)
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
                                <h6 class="fs-3 fw-semibold mb-0">Pembelian</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Supplier</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Bahan Baku</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Timestamp</h6>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchases as $purchase)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column align-items-start" style="width:20em">
                                        <div class="fw-semibold fs-4">
                                            {{ $purchase->code }}
                                        </div>
                                        <div class="fw-semibold text-muted">
                                            {{ formatRupiah($purchase->total_harga_beli) }}
                                        </div>
                                        <div class="fw-normal text-muted fs-2 line-clamp my-1 line-clamp-2"
                                                style="white-space:normal;">{{ $purchase->keterangan }}</div>
                                        <a href="/storage/{{$purchase->file_bukti}}"  target="_blank"
                                            class="mb-1 mt-2 fw-semibold badge bg-primary-subtle text-primary p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                                            style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <i class="ti ti-file fs-4"></i> {{$purchase->file_bukti}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold fs-3">
                                        {{ $purchase->supplier->nama }}</div>
                                        <p class="fs-2 text-muted mb-1">{{ $purchase->supplier->keterangan }}</p>
                                        <div class="badge bg-primary rounded-3 fw-semibold fs-2">
                                          {{ $purchase->supplier?->email ?? 'undefined' }}
                                        </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" style="width:20em">
                                        <img src="{{ $purchase->rawMaterial->image ? asset('storage/' . $purchase->rawMaterial->image) : '/assets/images/profile/user-1.jpg' }}"
                                            class="rounded-2" alt="Bahan Baku Image {{ $purchase->rawMaterial->nama }}" style="width: 4em" />
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-1">{{ $purchase->rawMaterial->nama }}</h6>
                                            <span class="fw-normal line-clamp line-clamp-2"
                                                style="white-space:normal; font-size:13px; ">{{ $purchase->rawMaterial->keterangan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-start gap-2">
                                        <div class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Updated
                                            at
                                            : {{ $purchase->updated_at }}</div>
                                        <div class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Created
                                            at
                                            : {{ $purchase->created_at }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a href="{{route('raw_material.purchase.edit', $purchase->id)}}" class="dropdown-item d-flex align-items-center gap-3"><i
                                                        class="fs-4 ti ti-edit"></i>Edit</a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal-{{$purchase->id}}"><i
                                                        class="fs-4 ti ti-trash"></i>Delete</button>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div id="deleteModal-{{$purchase->id}}" class="modal fade" tabindex="-1"
                                        aria-labelledby="danger-header-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                            <div class="modal-content p-3 modal-filled bg-danger">
                                                <div class="modal-header modal-colored-header text-white">
                                                    <h4 class="modal-title text-white" id="danger-header-modalLabel">
                                                        Yakin ingin menghapus Purchase Bahan Baku ({{$purchase->code}}) ?
                                                    </h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="width: fit-content; white-space:normal">
                                                    <h5 class="mt-0 text-white">Purchase Bahan Baku {{$purchase->code}} akan dihapus</h5>
                                                    <p class="text-white">Segala data yang berkaitan dengan Purchase Bahan Baku tersebut juga akan dihapus secara permanen.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <form action="{{route('raw_material.purchase.destroy', $purchase->id)}}" method="POST">
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
@endsection
