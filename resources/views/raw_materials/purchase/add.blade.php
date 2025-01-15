@extends('layouts.base')
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pembelian Bahan Baku</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('raw_material.purchase.index') }}">Pembelian Bahan Baku</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Tambah Pembelian</li>
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
        <div class="col-md-8">
            <div class="card">
                <div class="px-4 py-3 border-bottom">
                    <h5 class="card-title fw-semibold mb-0">Pembelian Bahan Baku</h5>
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
                    <form action="{{ route('raw_material.purchase.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tanggal Pembelian (Purchase)</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-calendar-event fs-6"></i></span>
                                <input type="date" name="date" class="form-control ps-2" value="{{old('date')}}">
                            </div>
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Bahan Baku</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-atom-2 fs-6"></i></span>
                                <select name="raw_material_id" id="raw_material_id" class="form-select">
                                    <option value="">-- Pilih Bahan Baku --</option>
                                    @foreach ($raw_materials as $raw_material)
                                        <option value="{{$raw_material->id}}" {{$raw_material->id == old('raw_material_id') ? 'selected' : ''}}>{{$raw_material->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('raw_material_id')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Ke Supplier</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-user-circle fs-6"></i></span>
                                <select name="supplier_id" id="supplier_id" class="form-select">
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{$supplier->id}}" {{$supplier->id == old('supplier_id') ? 'selected' : ''}}>{{$supplier->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('supplier_id')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="is_available" type="checkbox" value="1" id="is_available" checked />
                                <label class="form-check-label" for="is_available">Jadikan status Bahan Baku (Bahan Baku) ini tersedia</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Bukti Purchase (Mutasi / Struk / Invoice)</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-file fs-6"></i></span>
                                <input type="file" name="proof_file" class="form-control ps-2">
                            </div>
                            @error('proof_file')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Total Harga Purchase</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-tag fs-6"></i></span>
                                <input type="text" name="total_purchase" class="form-control ps-2" value="{{old('total_purchase') ? formatRupiah(old('total_purchase')) : ''}}" placeholder="Rp ">
                            </div>
                            @error('total_purchase')
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
                                    placeholder="Description about this Bahan Baku">{{old('description')}}</textarea>
                            </div>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Tambah Pembelian Bahan Baku
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[type="file"][name="proof_file"]');
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

            $('input[name="total_purchase"]').on('input', function(){
              $(this).val(formatRupiah($(this).val()));
            })
        });
    </script>
@endsection
