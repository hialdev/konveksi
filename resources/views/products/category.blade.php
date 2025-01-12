@extends('layouts.base')
@section('css')
@endsection
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Kategori Produk</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Semua Kategori</li>
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
        <h1>Kategori Produk</h1>
        <div style="aspect-ratio:1/1; width:3em; height:3em"
            class="bg-primary text-white d-flex align-items-center justify-content-center rounded-5 me-auto">
            {{ count($categories) }}</div>
        <button class="btn btn-primary btn-al-primary"
            data-bs-toggle="modal" data-bs-target="#addCategoryModal"
        >Tambah</button>

        @include('products.addmodal', ['id' => 'addCategoryModal'])
    </div>

    <div class="table-responsive">
        <table class="table border text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-3 fw-semibold mb-0">Kategori</h6>
                    </th>
                    <th>
                        <h6 class="fs-3 fw-semibold mb-0">Total Produk</h6>
                    </th>
                    <th>
                        <h6 class="fs-3 fw-semibold mb-0">Timestamp</h6>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>
                            <div class="badge bg-primary rounded-3 fw-semibold fs-2">
                                {{ $category->nama }}</div>
                        </td>
                        <td>
                            <div class="badge bg-success rounded-3 fw-semibold fs-2">
                                {{ $category?->products?->count() ?? 'undefined' }}</div>
                        </td>
                        <td>
                            <div class="d-flex flex-column align-items-start gap-2">
                                <div class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Updated
                                    at
                                    : {{ $category->updated_at }}</div>
                                <div class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Created
                                    at
                                    : {{ $category->created_at }}</div>
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
                                        <a href="{{route('product.index', $category->stock?->id)}}" class="dropdown-item d-flex align-items-center gap-3"><i
                                                class="fs-4 ti ti-eye"></i>View</a>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                            data-bs-toggle="modal" data-bs-target="#editModal-{{$category->id}}"><i
                                                class="fs-4 ti ti-pencil"></i>Edit Category</button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal-{{$category->id}}"><i
                                                class="fs-4 ti ti-trash"></i>Delete</button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal-{{$category->id}}" tabindex="-1"
                                aria-labelledby="vertical-center-modal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myLargeModalLabel">
                                                Perbarui Kategori {{$category->nama}}
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('category.update', $category->id) }}" method="POST">
                                                @csrf
                                                <label for="name" class="form-label">Nama</label>
                                                <input type="text" name="name" class="form-control mb-2"
                                                    value="{{ old('name', $category->nama) }}"
                                                    placeholder="Terkini : {{ $category->nama }}">
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
                            <div id="deleteModal-{{$category->id}}" class="modal fade" tabindex="-1"
                                aria-labelledby="danger-header-modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content p-3 modal-filled bg-danger">
                                        <div class="modal-header modal-colored-header text-white">
                                            <h4 class="modal-title text-white" id="danger-header-modalLabel">
                                                Yakin ingin menghapus product ?
                                            </h4>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="width: fit-content; white-space:normal">
                                            <h5 class="mt-0 text-white">Product {{$category->title}} akan dihapus</h5>
                                            <p class="text-white">Segala data yang berkaitan dengan product tersebut juga akan dihapus secara permanen.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <form action="{{route('product.destroy', $category->id)}}" method="POST">
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
    <!-- Modal for QR Code Preview -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Preview QR Code -->
                    <img id="qrCodeImage" src="" class="img-fluid rounded" alt="QR Code Preview">
                    <a id="downloadLink" href="#" class="btn btn-primary mt-3" download="qr_code.png">Download QR
                        Code</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
