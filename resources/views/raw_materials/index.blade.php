@extends('layouts.base')
@section('css')
@endsection
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Bahan Baku</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Semua Bahan Baku</li>
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
        <h1>Bahan Baku</h1>
        <div style="aspect-ratio:1/1; width:3em; height:3em"
            class="bg-primary text-white d-flex align-items-center justify-content-center rounded-5 me-auto">
            {{ count($raw_materials) }}</div>
        <a href="{{ route('raw_material.add') }}" class="btn btn-primary btn-al-primary">Tambah</a>
        <a href="{{ route('raw_material.purchase.index') }}" class="btn text-primary border-al-primary">Purchase</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{route('raw_material.index')}}" method="GET">
                <div class="row align-items-end mb-3 flex-wrap">
                    <div class="col-md-4 mb-2">
                        <label for="search" class="form-label">Filter Kata</label>
                        <input type="text" class="form-control" placeholder="Cari Nama / Deskripsi" name="search" value="{{$filter->q ?? ''}}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="field" class="form-label">Urutkan Berdasarkan</label>
                        <select name="field" id="field" class="form-select">
                            @foreach (getModelAttributes('RawMaterial', ['image']) as $atr)
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
                            <a href="{{route('raw_material.index')}}" class="btn btn-secondary" style="white-space: nowrap">
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
                                <h6 class="fs-3 fw-semibold mb-0">Bahan Baku</h6>
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
                        @forelse ($raw_materials as $raw_material)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center" style="width:20em">
                                        <img src="{{ $raw_material->image ? asset('storage/' . $raw_material->image) : '/assets/images/profile/user-1.jpg' }}"
                                            class="rounded-2" alt="Bahan Baku Image {{ $raw_material->nama }}" style="width: 4em" />
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-1">{{ $raw_material->nama }}</h6>
                                            <span class="fw-normal line-clamp line-clamp-2"
                                                style="white-space:normal; font-size:13px; ">{{ $raw_material->keterangan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex rounded-3 badge {{ $raw_material->cek_tersedia ? 'bg-primary' : 'bg-danger'}}">
                                        {{ $raw_material->cek_tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-start gap-2">
                                        <div class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Updated
                                            at
                                            : {{ $raw_material->updated_at }}</div>
                                        <div class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Created
                                            at
                                            : {{ $raw_material->created_at }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @role(['admin', 'developer'])
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#availableModal-{{$raw_material->id}}"><i
                                                        class="fs-4 ti ti-check"></i>Atur Ketersediaan</button>
                                            </li>
                                            @endrole
                                            <li>
                                                <a href="{{route('raw_material.edit', $raw_material->id)}}" class="dropdown-item d-flex align-items-center gap-3"><i
                                                        class="fs-4 ti ti-edit"></i>Edit</a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal-{{$raw_material->id}}"><i
                                                        class="fs-4 ti ti-trash"></i>Delete</button>
                                            </li>
                                        </ul>
                                    </div>

                                    @role(['admin', 'developer'])
                                    <!-- Set Status Available Modal -->
                                    <div class="modal fade" id="availableModal-{{$raw_material->id}}" tabindex="-1"
                                        aria-labelledby="vertical-center-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myLargeModalLabel">
                                                        Atur Status {{$raw_material->nama}}
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('raw_material.available', $raw_material->id) }}" method="POST">
                                                        @csrf
                                                        <div class="form-check form-switch mb-3">
                                                            <input class="form-check-input" name="is_available" type="checkbox" value="1" id="is_available-{{$raw_material->id}}" {{ $raw_material->cek_tersedia ? 'checked' : ''}} />
                                                            <label class="form-check-label" for="is_available-{{$raw_material->id}}">Jadikan status Bahan Baku (Bahan Baku) ini tersedia</label>
                                                        </div>
                                                        <div class="d-flex gap-1 align-items-center justify-content-end">
                                                            <button type="button"
                                                                class="btn bg-danger-subtle text-danger  waves-effect text-start"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit"
                                                                class="btn btn-primary btn-al-primary">Perbarui</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endrole

                                    <!-- Delete Modal -->
                                    <div id="deleteModal-{{$raw_material->id}}" class="modal fade" tabindex="-1"
                                        aria-labelledby="danger-header-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                            <div class="modal-content p-3 modal-filled bg-danger">
                                                <div class="modal-header modal-colored-header text-white">
                                                    <h4 class="modal-title text-white" id="danger-header-modalLabel">
                                                        Yakin ingin menghapus Bahan Baku ?
                                                    </h4>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="width: fit-content; white-space:normal">
                                                    <h5 class="mt-0 text-white">Bahan Baku {{$raw_material->title}} akan dihapus</h5>
                                                    <p class="text-white">Segala data yang berkaitan dengan Bahan Baku tersebut juga akan dihapus secara permanen.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <form action="{{route('raw_material.destroy', $raw_material->id)}}" method="POST">
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
