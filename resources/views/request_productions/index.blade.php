@extends('layouts.base')
@section('css')
@endsection
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pengajuan Produksi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Semua Pengajuan Produksi</li>
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
        <h1>Pengajuan Produksi</h1>
        <div style="aspect-ratio:1/1; width:3em; height:3em"
            class="bg-primary text-white d-flex align-items-center justify-content-center rounded-5 me-auto">
            {{ count($prequests) }}</div>
        <a href="{{ route('request_production.add') }}" class="btn btn-primary btn-al-primary">Buat Pengajuan</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{route('request_production.index')}}" method="GET">
                <div class="row align-items-end mb-3 flex-wrap">
                    <div class="col-md-4 mb-2">
                        <label for="search" class="form-label">Filter Kata</label>
                        <input type="text" class="form-control" placeholder="Cari Kode / Nama Product / Bahan Baku " name="search" value="{{$filter->q ?? ''}}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="field" class="form-label">Urutkan Berdasarkan</label>
                        <select name="field" id="field" class="form-select">
                            <option value="custom_order" {{$filter->field == 'custom_order' ? 'selected' : ''}}>Custom Order</option>
                            <option value="raw_material" {{$filter->field == 'raw_material' ? 'selected' : ''}}>Raw Material / Bahan Baku</option>
                            <option value="user" {{$filter->field == 'user' ? 'selected' : ''}}>Penanggung Jawab</option>
                            @foreach (getModelAttributes('RequestProduction', ['pesanan_khusus_id', 'bahan_baku_id', 'user_id']) as $atr)
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
                                <h6 class="fs-3 fw-semibold mb-0">Pengajuan Produksi</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Penanggung Jawab</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Status</h6>
                            </th>
                            <th>
                                <h6 class="fs-3 fw-semibold mb-0">Produk</h6>
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
                        @forelse ($prequests as $req)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column align-items-start" style="width:20em">
                                        <div class="fw-semibold fs-4">
                                            {{ $req->code }}
                                        </div>
                                        <div class="fw-semibold text-muted">
                                            {{ $req->qty }} Qty
                                        </div>
                                        <div class="fw-normal text-muted fs-2 line-clamp my-1 line-clamp-2"
                                                style="white-space:normal;">{{ $req->keterangan }}</div>
                                        <div class="mb-1 mt-2 fw-semibold badge bg-danger p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                                            style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <i class="ti ti-clock fs-4"></i> {{\Carbon\Carbon::parse($req->deadline)->format('d M Y')}}
                                        </div>
                                        <a href="{{$req->lampiran ? '/storage/'.$req->lampiran : '#'}}"  target="_blank"
                                            class="mb-1 mt-2 fw-semibold badge {{$req->lampiran ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger'}} p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                                            style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <i class="ti ti-file fs-4"></i> {{$req->lampiran ?? 'Tidak ada lampiran'}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" style="width:20em">
                                        <img src="{{ $req->pic->image ? asset('storage/' . $req->pic->image) : '/assets/images/profile/user-1.jpg' }}"
                                            class="rounded-2" alt="Raw Material Image {{ $req->pic->nama }}" style="width: 4em" />
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-1">{{ $req->pic->nama }}</h6>
                                            <div class="fw-normal line-clamp line-clamp-2"
                                                style="white-space:normal; font-size:13px; ">{{ $req->pic->email }}</div>
                                            <div class="fw-normal line-clamp line-clamp-2"
                                                style="white-space:normal; font-size:13px; ">{{ $req->pic->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="{{$req->status == 0 ? '' : 'd-none'}} badge bg-secondary rounded-3 fw-semibold fs-2">Menunggu</div>
                                    <div class="{{$req->status == 1 ? '' : 'd-none'}} badge bg-warning rounded-3 fw-semibold fs-2">Diproses</div>
                                    <div class="{{$req->status == 2 ? '' : 'd-none'}} badge bg-success rounded-3 fw-semibold fs-2">Selesai</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" style="width:20em">
                                        <img src="{{ $req->product->image ? asset('storage/' . $req->product->image) : '/assets/images/profile/user-1.jpg' }}"
                                            class="rounded-2" alt="Raw Material Image {{ $req->product->nama }}" style="width: 4em" />
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-1">{{ $req->product->nama }}</h6>
                                            <span class="fw-normal line-clamp line-clamp-2"
                                                style="white-space:normal; font-size:13px; ">{{ $req->product->keterangan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" style="width:20em">
                                        <img src="{{ $req->rawMaterial->image ? asset('storage/' . $req->rawMaterial->image) : '/assets/images/profile/user-1.jpg' }}"
                                            class="rounded-2" alt="Raw Material Image {{ $req->rawMaterial->nama }}" style="width: 4em" />
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-1">{{ $req->rawMaterial->nama }}</h6>
                                            <span class="fw-normal line-clamp line-clamp-2"
                                                style="white-space:normal; font-size:13px; ">{{ $req->rawMaterial->keterangan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-start gap-2">
                                        <div class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Updated
                                            at
                                            : {{ $req->updated_at }}</div>
                                        <div class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Created
                                            at
                                            : {{ $req->created_at }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if($req->status != 2)
                                            <li>
                                                <button type="button" class="dropdown-item d-flex {{$req->status == 0 ? 'text-warning' : 'text-success'}} align-items-center gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#processModal-{{$req->id}}"><i
                                                        class="fs-4 ti {{$req->status == 0 ? 'ti-loader-3' : 'ti-check'}}"></i>{{$req->status == 0 ? 'Proses Permintaan' : 'Selesaikan Permintaan'}}</button>
                                            </li>
                                            @endif
                                            <li>
                                                <a href="{{route('request_production.edit', $req->id)}}" class="dropdown-item d-flex align-items-center gap-3"><i
                                                        class="fs-4 ti ti-edit"></i>Edit</a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal-{{$req->id}}"><i
                                                        class="fs-4 ti ti-trash"></i>Delete</button>
                                            </li>
                                        </ul>
                                    </div>

                                    @if($req->status != 2)
                                    <!-- Process Modal -->
                                    <div class="modal fade" id="processModal-{{$req->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content {{$req->status == 0 ? 'bg-warning-subtle' : 'bg-success-subtle'}}">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        {{$req->status == 0 ? 'Proses Permintaan' : 'Selesaikan Permintaan'}} {{$req->code}}
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('request_production.process', $req->id) }}" method="POST">
                                                        @csrf
                                                        <p style="white-space: normal">Pastikan Keadaan lapangan sudah sesuai, dan dapat dipertanggung jawabkan dengan baik untuk <strong>{{$req->status == 0 ? 'Proses Permintaan' : 'Selesaikan Permintaan'}} dengan kode {{$req->code}}</strong></p>
                                                        <div class="d-flex gap-1 align-items-center justify-content-end">
                                                            <button type="button"
                                                                class="btn bg-danger-subtle text-danger  waves-effect text-start"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit"
                                                                class="btn {{$req->status == 0 ? 'btn-warning' : 'btn-success'}}">{{$req->status == 0 ? 'Proses Permintaan' : 'Selesaikan Permintaan'}}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Delete Modal -->
                                    <div id="deleteModal-{{$req->id}}" class="modal fade" tabindex="-1"
                                        aria-labelledby="danger-header-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                            <div class="modal-content p-3 modal-filled bg-danger">
                                                <div class="modal-header modal-colored-header text-white">
                                                    <h4 class="modal-title text-white" id="danger-header-modalLabel">
                                                        Yakin ingin menghapus Request Production ({{$req->code}}) ?
                                                    </h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="width: fit-content; white-space:normal">
                                                    <h5 class="mt-0 text-white">Request Production {{$req->code}} akan dihapus</h5>
                                                    <p class="text-white">Segala data yang berkaitan dengan Request Production tersebut juga akan dihapus secara permanen.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <form action="{{route('request_production.destroy', $req->id)}}" method="POST">
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

                            @if($req->customOrder)
                            <tr>
                                <td colspan="6">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light">
                                        <div class="">
                                            <div class="fs-2">Produksi untuk Pesanan Khusus</div>
                                            <div class="fs-3 text-primary">{{$req->customOrder->code}}</div>
                                        </div>
                                        <div>
                                            <a href="{{route('custom-order.payment.index', $req->customOrder->id)}}" class="btn btn-primary btn-sm">Lihat Detail</a>
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
@endsection
