@extends('layouts.base')
@section('css')
<link rel="stylesheet" href="/assets/libs/select2/dist/css/select2.min.css">
@endsection
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pesan Pesanan Khusus</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('custom-order.index') }}">Pesan Pesanan Khusus</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Buat Pesanan Khusus</li>
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
            <div id="placeholder-raw" class="mb-4 d-none">
                <h6>Preview Lampiran Bahan Baku</h6>
                <div id="placeholder-image-raw"
                    class="d-flex p-5 text-center align-items-center justify-content-center rounded-5 border-2 border-dashed"
                    style="aspect-ratio:1/1">
                    <div>
                        <div class="fs-4">If Image / File Selected, it will show (Preview)</div>
                    </div>
                </div>
                <img src="" id="preview-image-raw" alt="Bahan Baku Image Preview" class="d-none rounded-4 shadow w-100"
                    style="">
                <div id="preview-file-raw" class="d-none">
                    <a href="" id="preview-file-link-raw" class="d-flex align-items-center gap-2 p-2 rounded-2 border border-al-primary" target="_blank">
                        <i class="ti ti-file fs-6"></i>
                        <div id="preview-file-text-raw" class="fs-2 line-clamp line-clamp-2">File Name</div>
                    </a>
                    <embed id="preview-file-embed-raw" src="" class="rounded-4 overflow-hidden mt-3" width="100%" height="600px" type="application/pdf">
                </div>
            </div>
            <div class="">
                <h6>Preview Lampiran</h6>
                <div id="placeholder-image"
                    class="d-flex p-5 text-center align-items-center justify-content-center rounded-5 border-2 border-dashed"
                    style="aspect-ratio:1/1">
                    <div>
                        <div class="fs-4">If Image / File Selected, it will show (Preview)</div>
                    </div>
                </div>
                <img src="" id="preview-image" alt="Bahan Baku Image Preview" class="d-none rounded-4 shadow w-100"
                    style="">
                <div id="preview-file" class="d-none">
                    <a href="" id="preview-file-link" class="d-flex align-items-center gap-2 p-2 rounded-2 border border-al-primary" target="_blank">
                        <i class="ti ti-file fs-6"></i>
                        <div id="preview-file-text" class="fs-2 line-clamp line-clamp-2">File Name</div>
                    </a>
                    <embed id="preview-file-embed" src="" class="rounded-4 overflow-hidden mt-3" width="100%" height="600px" type="application/pdf">
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="px-4 py-3 border-bottom">
                    <h5 class="card-title fw-semibold mb-0">Pesan Pesanan Khusus</h5>
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
                    <form action="{{ route('custom-order.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="raw_from_customer" type="checkbox" value="1" id="raw_from_customer" />
                                <label class="form-check-label" for="raw_from_customer">Apakah Bahan Baku dari Anda Sendiri ?</label>
                            </div>
                        </div>
                        <div id="raw-from-owner" class="p-4 bg-light rounded-4">
                            <label class="form-label fw-semibold">Gunakan Bahan Baku</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-atom-2 fs-6"></i></span>
                                <div style="flex-grow:1">
                                    <select name="raw_material_id" id="raw_material_id" class="select2 form-select">
                                        <option value="">-- Pilih Bahan Baku --</option>
                                        @foreach ($raw_materials as $raw_material)
                                            <option value="{{$raw_material->id}}" {{$raw_material->id == old('raw_material_id') ? 'selected' : ''}}>{{$raw_material->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('raw_material_id')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        {{-- Bahan Dari Pelanggan --}}
                        <div id="raw-from-customer" class="d-none p-4 rounded-4 bg-light">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Nama Bahan Baku yang anda Bawa</label>
                                <div class="input-group">
                                    <span class="input-group-text px-6" id="basic-addon1"><i
                                            class="ti ti-text-caption fs-6"></i></span>
                                    <input type="text" name="raw_name" class="form-control bg-white ps-2" value="{{old('raw_name')}}" placeholder="Nama Bahan Baku">
                                </div>
                                @error('raw_name')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Jelaskan Bahan Baku yang Anda Bawa</label>
                                <div class="input-group">
                                    <span class="input-group-text px-6" id="basic-addon1"><i
                                            class="ti ti-align-justified fs-6"></i></span>
                                    <textarea class="form-control bg-white ps-2" name="raw_description" id="raw_description" cols="20" rows="5"
                                        placeholder="Jelaskan Bahan Baku milik Anda yang akan digunakan">{{old('raw_description')}}</textarea>
                                </div>
                                @error('raw_description')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-semibold">Lampirkan Foto / File Bahan Baku Anda</label>
                                <div class="input-group">
                                    <span class="input-group-text px-6" id="basic-addon1"><i
                                            class="ti ti-file fs-6"></i></span>
                                    <input type="file" name="raw_attachment" class="form-control bg-white ps-2">
                                </div>
                                @error('raw_attachment')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="my-3">
                            <label class="form-label fw-semibold">Buat Produk Seperti</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-atom-2 fs-6"></i></span>
                                <div style="flex-grow:1">
                                    <select name="product_id" id="product_id" class="select2 form-select">
                                        <option value="">-- Pilih Produk --</option>
                                        <option value="">- Produk Lainnya -</option>
                                        @foreach ($products as $product)
                                            <option value="{{$product->id}}" {{$product->id == old('product_id') ? 'selected' : ''}}>{{$product->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('product_id')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="my-4">
                            <label class="form-label fw-semibold">Jelaskan Pesanan Khusus</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-align-justified fs-6"></i></span>
                                <textarea class="form-control ps-2" name="description" id="description" cols="20" rows="5"
                                    placeholder="Jelaskan Pesanan Khusus Seperti apa yang anda ingin buat dengan lengkap">{{old('description')}}</textarea>
                            </div>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Lampirkan Foto / File Contoh Pesanan Khusus</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-file fs-6"></i></span>
                                <input type="file" name="attachment" class="form-control ps-2">
                            </div>
                            @error('attachment')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Produksi Sebanyak (Qty)</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-number fs-6"></i></span>
                                <input type="number" name="qty" class="form-control ps-2" value="{{old('qty')}}" placeholder="Buat Produk pada permintaan produksi ini sebanyak ... pcs">
                            </div>
                            @error('qty')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Deadline / Batas Waktu Produksi</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-calendar-event fs-6"></i></span>
                                <input type="date" name="deadline" class="form-control ps-2" value="{{old('deadline')}}">
                            </div>
                            @error('deadline')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        @role(['admin', 'developer', 'employee'])
                        <div class="my-3">
                            <label class="form-label fw-semibold">Kaitkan Pesanan ke Pelanggan</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-user-circle fs-6"></i></span>
                                <div style="flex-grow:1">
                                    <select name="customer_id" id="customer_id" class="select2 form-select">
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{$customer->id}}" {{$customer->id == old('customer_id') ? 'selected' : ''}}>{{$customer->name .' | '.$customer->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('customer_id')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex mb-3 align-items-center gap-2 mt-2">
                            Tidak menemukan pelanggan ? 
                            <button type="button" class="btn btn-sm text-primary bg-primary-subtle"
                                data-bs-toggle="modal"
                                data-bs-target="#addCustomerModal"
                            >Tambah Pelanggan</button>
                        </div>
                        @endrole

                        <button type="submit" class="btn btn-primary">
                            Buat Pesanan Khusus
                        </button>
                    </form>
                </div>
                
                @include('customers.addmodal', ['id' => 'addCustomerModal'])
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="/assets/js/forms/select2.init.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[type="file"][name="attachment"]');
            const placeholder = document.getElementById('placeholder-image');
            const previewImage = document.getElementById('preview-image');
            const previewFile = document.getElementById('preview-file');
            const previewFileLink = document.getElementById('preview-file-link');
            const previewFileEmbed = document.getElementById('preview-file-embed');
            const previewFileName = document.getElementById('preview-file-text');

            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];

                if (file) {
                    if (file.type.startsWith('image/')) {
                        // Preview image
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewImage.src = e.target.result;
                            previewImage.classList.remove('d-none'); // Show image preview
                            previewFile.classList.add('d-none'); // Hide file preview
                            placeholder.classList.add('d-none'); // Hide placeholder
                        };
                        reader.readAsDataURL(file);
                    } else {
                        // Preview file
                        previewFileName.textContent = file.name;
                        previewFileEmbed.src = URL.createObjectURL(file); // Temporary file link
                        previewFileLink.href = URL.createObjectURL(file); // Temporary file link
                        previewFile.classList.remove('d-none'); // Show file preview
                        previewImage.classList.add('d-none'); // Hide image preview
                        placeholder.classList.add('d-none'); // Hide placeholder
                    }
                } else {
                    // Reset previews
                    previewImage.src = '';
                    previewImage.classList.add('d-none');
                    previewFile.classList.add('d-none');
                    placeholder.classList.remove('d-none'); // Show placeholder
                }
            });

            // RAW
            const rawfileInput = document.querySelector('input[type="file"][name="raw_attachment"]');
            const rawplaceholder = document.getElementById('placeholder-image-raw');
            const rawpreviewImage = document.getElementById('preview-image-raw');
            const rawpreviewFile = document.getElementById('preview-file-raw');
            const rawpreviewFileLink = document.getElementById('preview-file-link-raw');
            const rawpreviewFileEmbed = document.getElementById('preview-file-embed-raw');
            const rawpreviewFileName = document.getElementById('preview-file-text-raw');

            rawfileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];

                if (file) {
                    if (file.type.startsWith('image/')) {
                        // Preview image
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            rawpreviewImage.src = e.target.result;
                            rawpreviewImage.classList.remove('d-none'); // Show image preview
                            rawpreviewFile.classList.add('d-none'); // Hide file preview
                            rawplaceholder.classList.add('d-none'); // Hide placeholder
                        };
                        reader.readAsDataURL(file);
                    } else {
                        // Preview file
                        rawpreviewFileName.textContent = file.name;
                        rawpreviewFileEmbed.src = URL.createObjectURL(file); // Temporary file link
                        rawpreviewFileLink.href = URL.createObjectURL(file); // Temporary file link
                        rawpreviewFile.classList.remove('d-none'); // Show file preview
                        rawpreviewImage.classList.add('d-none'); // Hide image preview
                        rawplaceholder.classList.add('d-none'); // Hide placeholder
                    }
                } else {
                    // Reset previews
                    rawpreviewImage.src = '';
                    rawpreviewImage.classList.add('d-none');
                    rawpreviewFile.classList.add('d-none');
                    rawplaceholder.classList.remove('d-none'); // Show placeholder
                }
            });

            $('input[name="total_purchase"]').on('input', function(){
              $(this).val(formatRupiah($(this).val()));
            })

            $('input[name="raw_from_customer"]').on('change', function(){
                let check = $(this).is(':checked');
                if(check) {
                    $('#raw-from-customer').removeClass('d-none');
                    $('#raw-from-owner').addClass('d-none');
                    $('#placeholder-raw').removeClass('d-none');
                }else{
                    $('#raw-from-customer').addClass('d-none');
                    $('#raw-from-owner').removeClass('d-none');
                    $('#placeholder-raw').addClass('d-none');
                }
            })
        });
    </script>
@endsection
