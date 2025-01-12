@extends('layouts.base')
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Tambah Produk</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('product.index') }}">Produk</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="../assets/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 h-100 mb-3">
            <div id="placeholder-image"
                class="d-flex p-5 text-center align-items-center justify-content-center rounded-5 border-2 border-dashed"
                style="aspect-ratio:1/1">
                <div>
                    <div class="fs-4">If Image Selected, it will show (Preview)</div>
                </div>
            </div>
            <img src="" id="preview-image" alt="Product Image Preview" class="d-none rounded-4 shadow w-100"
                style="">
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="px-4 py-3 border-bottom">
                    <h5 class="card-title fw-semibold mb-0">Tambah Produk</h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Image Produk</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-photo fs-6"></i></span>
                                <input type="file" name="image" class="form-control ps-2">
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nama</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-text-caption fs-6"></i></span>
                                <input type="text" name="name" value="{{old('name')}}" class="form-control ps-2" placeholder="Name Product">
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-text-caption fs-6"></i></span>
                                <input type="text" name="slug" value="{{old('slug')}}" class="form-control ps-2" placeholder="Slug Product">
                            </div>
                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Keterangan</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-align-justified fs-6"></i></span>
                                <textarea class="form-control ps-2" name="description" id="description" cols="20" rows="5"
                                    placeholder="Description about this Product">{{old('description')}}</textarea>
                            </div>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-users fs-6"></i></span>
                                <input type="text" name="price" value="{{old('price')}}" class="form-control ps-2">
                            </div>
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category" class="form-label">Kategori</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id == old('category') ? 'selected' : ''}}>{{$category->nama}}</option>
                                @endforeach
                            </select>
                            <div class="d-flex align-items-center gap-2 mt-2">
                                Tidak menemukan kategori ? 
                                <button type="button" class="btn btn-sm text-primary bg-primary-subtle"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addProductCategoryModal"
                                >Tambah Kategori</button>
                            </div>
                        </div>
                        <div class="mb-4 rounded-3 p-3 bg-primary-subtle">
                            <label class="form-label fw-semibold">Stock Tersedia</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-shopping-cart fs-6"></i></span>
                                <input type="number" name="stock" value="{{old('stock')}}" class="form-control ps-2">
                            </div>
                            @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Tambah Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('products.addmodal', ['id' => 'addProductCategoryModal'])
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[type="file"][name="image"]');
            const placeholder = document.getElementById('placeholder-image');
            const previewImage = document.getElementById('preview-image');

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result; // Set preview image source
                        previewImage.classList.remove('d-none'); // Show the preview image
                        placeholder.classList.add('d-none'); // Hide the placeholder
                    };

                    reader.readAsDataURL(file);
                } else {
                    // Reset if no file or file is not an image
                    previewImage.src = '';
                    previewImage.classList.add('d-none');
                    placeholder.classList.remove('d-none');
                }
            });

            $('input[name="name"]').on('input', function() {
                const name = $(this).val();
                $('input[name="slug"]').val(makeSlug(name));
            });

            $('input[name="price"]').on('input', function() {
                $(this).val(formatRupiah($(this).val()));
            })
        });
    </script>
@endsection
