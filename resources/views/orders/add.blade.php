@extends('layouts.base')
@section('css')
<link rel="stylesheet" href="/assets/libs/select2/dist/css/select2.min.css">
@endsection
@section('content')
@php
  $carts = session()->get('cart', []);
  $totalPrice = 0;
@endphp
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pesan Produk</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('product.index') }}">Produk</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Pesan Produk</li>
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

    <div>
      <h5 class="mb-3">Buat Pesanan pada Keranjang</h5>
      <div class="border border-2 border-dashed border-dark-subtle rounded-4 p-3">
          @forelse ($carts as $item)
          @php
              $cart = \App\Models\Product::find($item['id']);
              $subtotal = $cart->harga * $item['qty'];
              $totalPrice += $subtotal;
              $finalPrice = $totalPrice + ($totalPrice * (int) setting('site.ppn') / 100);
          @endphp
          <div class="row align-items-center mb-2">
            <div class="col-md-6">
              <div class="d-flex align-items-center gap-2 mb-2">
                <img src="{{$cart->image ? '/storage/'.$cart->image : 'https://placehold.co/300'}}" alt="Image Product {{$cart->nama}} in Cart" class="d-block rounded-2" style="width: 5em; height:5em; object-fit:cover">
                <div>
                  <div class="fs-3 fw-semibold line-clamp line-clamp-2">{{$cart->nama}}</div>
                  <div class="fs-2 line-clamp line-clamp-2">{{formatRupiah($cart->harga)}}</div>
                  <div class="d-flex mt-2 align-items-center gap-2">
                    <form action="{{route('product.minQty')}}" method="POST">
                      @csrf
                      <input type="hidden" name="product_id" value="{{$cart->id}}">
                      <button type="submit" class="btn btn-sm btn-danger"><i class="ti ti-minus"></i></button>
                    </form>
                    <input type="number" name="qty" disabled id="qty" class="form-control form-control-sm" value="{{$item['qty']}}">
                    <form action="{{route('product.addQty')}}" method="POST">
                      @csrf
                      <input type="hidden" name="product_id" value="{{$cart->id}}">
                      <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-plus"></i></button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="text-end">
                <div class="fs-2 fw-semibold">Sub Total</div>
                <div class="fs-3 fw-bold">{{formatRupiah($subtotal)}}</div>
              </div>
            </div>
          </div>
          
          @empty
          <div class="text-center fs-3 p-5 border border-2 border-dashed border-primary rounded-4">Keranjang Kosong</div>
          @endforelse
          <div class="pt-3 mt-3 bg-light p-3 rounded-4 position-sticky bottom-0">
            <div class="d-flex align-items-center gap-2 justify-content-between">
              <div class="fs-3 fw-semibold">Total</div>
              <div class="fs-3 fw-bold">{{formatRupiah($totalPrice)}}</div>
            </div>
            <div class="d-flex text-primary align-items-center gap-2 justify-content-between">
              <div class="fs-3 fw-semibold">PPN</div>
              <div class="fs-3 fw-bold">{{setting('site.ppn')}}%</div>
            </div>
            <div class="d-flex align-items-center gap-2 justify-content-between rounded-2 border border-primary p-2 px-3 text-primary mt-2">
              <div class="fs-3 fw-semibold">Total Akhir</div>
              <div class="fs-3 fw-bold">{{formatRupiah($finalPrice)}}</div>
            </div>
            <form action="{{route('order.checkout')}}" method="POST">
              @csrf
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
              <div class="d-flex align-items-center gap-2 mt-2">
                  Tidak menemukan pelanggan ? 
                  <button type="button" class="btn btn-sm text-primary bg-primary-subtle"
                      data-bs-toggle="modal"
                      data-bs-target="#addCustomerModal"
                  >Tambah Pelanggan</button>
              </div>
              @endrole
              <button type="submit" class="btn btn-primary w-100 mt-2">Buat Pesanan</button>
            </form>
          </div>

          @include('customers.addmodal', ['id' => 'addCustomerModal'])
      </div>
    </div>
@endsection
@section('scripts')
    <script src="/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="/assets/js/forms/select2.init.js"></script>
@endsection
