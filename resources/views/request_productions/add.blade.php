@extends('layouts.base')
@section('css')
<link rel="stylesheet" href="/assets/libs/select2/dist/css/select2.min.css">
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
                                <a class="text-muted text-decoration-none" href="{{ route('request_production.index') }}">Pengajuan Produksi</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Buat Pengajuan</li>
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
                    <h5 class="card-title fw-semibold mb-0">Pengajuan Produksi</h5>
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
                    <form action="{{ route('request_production.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Gunakan Bahan Baku</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-atom-2 fs-6"></i></span>
                                <div style="flex-grow:1">
                                    <select name="raw_material_id" id="raw_material_id" class="select2 form-select">
                                        <option value="">-- Pilih Bahan Baku --</option>
                                        @foreach ($raw_materials as $raw_material)
                                            <option value="{{$raw_material->id}}" {{$raw_material->id == old('raw_material_id', request()->get('rawid')) ? 'selected' : ''}}>{{$raw_material->nama}}</option>
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
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Untuk Membuat Produk</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-basket fs-6"></i></span>
                                <div style="flex-grow:1">
                                    <select name="product_id" id="product_id" class="select2 form-select">
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach ($products as $product)
                                            <option value="{{$product->id}}" {{$product->id == old('product_id', request()->get('productid')) ? 'selected' : ''}}>{{$product->nama}}</option>
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
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="is_custom_order" type="checkbox" value="1" id="is_custom_order-{{$raw_material->id}}" {{count($custom_orders) > 0 ? 'checked' : ''}} />
                                <label class="form-check-label" for="is_custom_order-{{$raw_material->id}}">Apakah Permintaan ini merujuk ke Pesanan Khusus ?</label>
                            </div>
                        </div>
                        <div class="mb-4 {{count($custom_orders) <= 0 ? 'd-none' : ''}}" id="custom-order-box">
                            <label class="form-label fw-semibold">Merujuk ke Custom Order</label>
                            <div class="input-group w-100">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-user-circle fs-6"></i></span>
                                <div style="flex-grow: 1">
                                    <select name="custom_order_id" id="custom_order_id" class="select2 form-control w-100">
                                        <option value="">-- Pilih Custom Order --</option>
                                        @forelse ($custom_orders as $custom_order)
                                            <option value="{{$custom_order->id}}" {{$custom_order->id == old('custom_order_id', request()->get('customid')) ? 'selected' : ''}}>{{$custom_order->code .' | '. $custom_order->nama}}</option>
                                        @empty
                                            <option value="">Belum ada Custom Order</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            @error('custom_order_id')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        @role(['admin', 'developer'])
                        <div class="mb-4 {{count($pics) <= 0 ? 'd-none' : ''}}" id="custom-order-box">
                            <label class="form-label fw-semibold">Dengan Penanggung Jawab</label>
                            <div class="input-group w-100">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-user-circle fs-6"></i></span>
                                <div style="flex-grow: 1">
                                    <select name="user_id" id="user_id" class="select2 form-control custom-select">
                                        <option value="">-- Pilih Penanggung Jawab --</option>
                                        <option value="{{auth()->user()->id}}">Saya Sendiri ({{auth()->user()->name}})</option>
                                        @forelse ($pics as $pic)
                                            <option value="{{$pic->id}}" {{$pic->id == old('user_id') ? 'selected' : ''}}>{{$pic->name.' ('.$pic->email.(!$pic->phone ? '': ' - '.$pic->phone).')'}}</option>
                                        @empty
                                            <option value="">Belum ada Penanggung Jawab</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        @endrole
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Produksi Sebanyak (Qty)</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-number fs-6"></i></span>
                                <input type="number" name="qty" class="form-control ps-2" value="{{old('qty', request()->get('qty'))}}" placeholder="Buat Produk pada permintaan produksi ini sebanyak ... pcs">
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
                                <input type="date" name="deadline" class="form-control ps-2" value="{{old('deadline', request()->get('deadline'))}}">
                            </div>
                            <p class="fs-2 mb-0 mt-1 text-danger">Selesaikan H-2 ({{\Carbon\Carbon::parse(request()->get('deadline'))->format('d-m-Y')}}) dari Deadline Pelanggan {{\Carbon\Carbon::parse(request()->get('deadline'))->addDays(2)->format('d-m-Y')}}</p>
                            @error('deadline')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Lampirkan Foto / File pendukung (Optional)</label>
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
                            <label class="form-label fw-semibold">Keterangan</label>
                            <div class="input-group">
                                <span class="input-group-text px-6" id="basic-addon1"><i
                                        class="ti ti-align-justified fs-6"></i></span>
                                <textarea class="form-control ps-2" name="description" id="description" cols="20" rows="5"
                                    placeholder="Keterangan untuk Pengajuan Produksi">{{old('description', request()->get('description'))}}</textarea>
                            </div>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Ajukan Produksi
                        </button>
                    </form>
                </div>
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

            $('input[name="total_purchase"]').on('input', function(){
              $(this).val(formatRupiah($(this).val()));
            })

            $('input[name="is_custom_order"]').on('change', function(){
                let check = $(this).is(':checked');
                if(check) {
                    $('#custom-order-box').removeClass('d-none');
                }else{
                    $('#custom-order-box').addClass('d-none');
                }
            })
        });
    </script>
@endsection
