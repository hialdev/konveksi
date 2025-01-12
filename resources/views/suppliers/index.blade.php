@extends('layouts.base')
@section('css')
@endsection
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Suppliers</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Manage Suppliers</li>
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
        <h1>Suppliers</h1>
        <div style="aspect-ratio:1/1; width:3em; height:3em"
            class="bg-primary text-white d-flex align-items-center justify-content-center rounded-5 me-auto">
            {{ count($suppliers) }}</div>
        <button class="btn btn-primary btn-al-primary"
            data-bs-toggle="modal" data-bs-target="#addSupplierModal"
        >Tambah</button>

        <!-- Tambah Supplier modal -->
        <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="vertical-center-modal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            Tambah Supplier
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('supplier.store') }}" method="POST">
                            @csrf

                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control mb-2" value="{{ old('name') }}"
                              placeholder="Nama Supplier" required>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control mb-2" value="{{ old('email') }}"
                              placeholder="supplier@mail.com" required>
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control mb-2" placeholder="Keterangan supplier">{{ old('description') }}</textarea>

                            <div class="d-flex gap-1 align-items-center justify-content-end">
                                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start"
                                    data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary btn-al-primary">Tambah Supplier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table border text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-3 fw-semibold mb-0">Supplier</h6>
                    </th>
                    <th>
                        <h6 class="fs-3 fw-semibold mb-0">Email</h6>
                    </th>
                    <th>
                        <h6 class="fs-3 fw-semibold mb-0">Timestamp</h6>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        <td>
                            <div class="fw-semibold fs-3">
                                {{ $supplier->nama }}</div>
                            <p class="fs-2 text-muted mb-0">{{ $supplier->keterangan }}</p>
                        </td>
                        <td>
                            <div class="badge bg-primary rounded-3 fw-semibold fs-2">
                                {{ $supplier?->email ?? 'undefined' }}</div>
                        </td>
                        <td>
                            <div class="d-flex flex-column align-items-start gap-2">
                                <div class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Updated
                                    at
                                    : {{ $supplier->updated_at }}</div>
                                <div class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Created
                                    at
                                    : {{ $supplier->created_at }}</div>
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
                                        <a href="{{route('supplier.index', $supplier->stock?->id)}}" class="dropdown-item d-flex align-items-center gap-3"><i
                                                class="fs-4 ti ti-eye"></i>View</a>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                            data-bs-toggle="modal" data-bs-target="#editModal-{{$supplier->id}}"><i
                                                class="fs-4 ti ti-pencil"></i>Edit Supplier</button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal-{{$supplier->id}}"><i
                                                class="fs-4 ti ti-trash"></i>Delete</button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal-{{$supplier->id}}" tabindex="-1"
                                aria-labelledby="vertical-center-modal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myLargeModalLabel">
                                                Perbarui Supplier {{$supplier->nama}}
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                                                @csrf
                                                <label for="name" class="form-label">Nama</label>
                                                <input type="text" name="name" class="form-control mb-2" value="{{ old('name', $supplier->nama) }}"
                                                  placeholder="Nama Supplier" required>
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control mb-2" value="{{ old('email', $supplier->email) }}"
                                                  placeholder="supplier@mail.com" required>
                                                <label for="description" class="form-label">Keterangan</label>
                                                <textarea name="description" id="description" cols="30" rows="5" class="form-control mb-2">{{ old('description', $supplier->keterangan) }}</textarea>

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

                            <!-- Delete Modal -->
                            <div id="deleteModal-{{$supplier->id}}" class="modal fade" tabindex="-1"
                                aria-labelledby="danger-header-modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content p-3 modal-filled bg-danger">
                                        <div class="modal-header modal-colored-header text-white">
                                            <h4 class="modal-title text-white" id="danger-header-modalLabel">
                                                Yakin ingin menghapus supplier ?
                                            </h4>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="width: fit-content; white-space:normal">
                                            <h5 class="mt-0 text-white">Supplier {{$supplier->title}} akan dihapus</h5>
                                            <p class="text-white">Segala data yang berkaitan dengan supplier tersebut juga akan dihapus secara permanen.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <form action="{{route('supplier.destroy', $supplier->id)}}" method="POST">
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
    
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
        });
    </script>
@endsection
