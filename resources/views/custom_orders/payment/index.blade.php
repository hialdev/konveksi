@extends('layouts.base')
@section('css')
@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Detail Pesanan Khusus</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            @role('pelanggan')
                            <a class="text-muted text-decoration-none" href="{{ route('custom-order.index') }}">Pesanan Khusus</a>
                            @else
                            <a class="text-muted text-decoration-none" href="{{ route('custom-order.index') }}">Pesanan Khusus</a>
                            @endrole
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Semua Pesanan Khusus</li>
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

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
          <div>
              <div class="d-flex flex-column align-items-start" style="width:20em">
                  <div class="fs-1 text-muted">Kode Pesanan</div>
                  <div class="fw-semibold fs-4 mb-1">
                      {{ $custom->code }}
                  </div>
                  <div class="fs-1 text-muted">Kuantiti Pesanan</div>
                  <div class="fw-semibold text-muted mb-1">
                      {{ $custom->qty }} Qty
                  </div>
                  <div class="fs-1 text-muted">Masa Tenggat / Deadline</div>
                  <div class="mb-1 mt-2 fw-semibold badge bg-danger p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                      style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      <i class="ti ti-clock fs-4"></i> {{\Carbon\Carbon::parse($custom->deadline)->format('d M Y')}}
                  </div>
                  <div class="fs-1 mt-1 text-muted">Lampiran Pesanan</div>
                  <a href="{{$custom->lampiran ? '/storage/'.$custom->lampiran : '#'}}"  target="_blank"
                      class="mb-1 mt-2 fw-semibold badge {{$custom->lampiran ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger'}} p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                      style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      <i class="ti ti-file fs-4"></i> {{$custom->lampiran ?? 'Tidak ada lampiran'}}
                  </a>
              </div>
          </div>
          <hr>
          <div>
              <div class="fs-1 mb-1 text-muted">Detail Bahan Baku yang digunakan</div>
              @if($custom->bahan_baku_id != null)
              <div class="d-flex align-items-center" style="width:20em">
                  <img src="{{ $custom->rawMaterial->image ? asset('storage/' . $custom->rawMaterial->image) : '/assets/images/profile/user-1.jpg' }}"
                      class="rounded-2" alt="Raw Material Image {{ $custom->rawMaterial->nama }}" style="width: 4em" />
                  <div class="ms-3">
                      <h6 class="fw-semibold mb-1">{{ $custom->rawMaterial->nama }}</h6>
                      <span class="fw-normal line-clamp line-clamp-3"
                          style="white-space:normal; font-size:13px; ">{{ $custom->rawMaterial->keterangan }}</span>
                  </div>
              </div>
              @else
              <div class="badge bg-primary fs-2 mb-2">Bahan dari Pelanggan</div>
              <div class="d-flex align-items-center" style="width:20em">
                  <img src="{{ $custom->lampiran_bahan ? asset('storage/' . $custom->lampiran_bahan) : '/assets/images/profile/user-1.jpg' }}"
                      class="rounded-2 me-3 {{!isImage($custom->lampiran_bahan) ? 'd-none' : ''}}" alt="Raw Material Image {{ $custom->rawMaterial?->nama }}" style="width: 4em" />
                  <div class="">
                      <h6 class="fw-semibold mb-1">{{ $custom->nama_bahan }}</h6>
                      <span class="fw-normal line-clamp line-clamp-3"
                          style="white-space:normal; font-size:13px; ">{{ $custom->keterangan_bahan }}</span>
                  </div>
              </div>
              <a href="{{$custom->lampiran_bahan ? '/storage/'.$custom->lampiran_bahan : '#'}}"  target="_blank"
                  class="mb-1 mt-2 fw-semibold badge {{$custom->lampiran_bahan ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger'}} p-1 px-2 fs-2 gap-1 d-inline-flex align-items-center text-truncate" 
                  style="max-width: 15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                  <i class="ti ti-file fs-4"></i> {{$custom->lampiran_bahan ?? 'Tidak ada lampiran'}}
              </a>
              @endif
          </div>
      </div>
      
      <div class="col-md-6">
          <div class="d-flex align-items-center gap-2">
              <div>
                  <div class="{{$custom->status == 0 ? '' : 'd-none'}} badge bg-light text-dark rounded-3 fw-semibold fs-2">Menunggu Harga</div>
                  <div class="{{$custom->status == 1 ? '' : 'd-none'}} badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Harga Ditetapkan</div>
                  <div class="{{$custom->status == 2 ? '' : 'd-none'}} badge bg-warning rounded-3 fw-semibold fs-2">Pengajuan Nego</div>
                  <div class="{{$custom->status == 3 ? '' : 'd-none'}} badge bg-danger rounded-3 fw-semibold fs-2">Tidak Sepakat</div>
                  <div class="{{$custom->status == 4 ? '' : 'd-none'}} badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Sepakat & Dikerjakan</div>
                  <div class="{{$custom->status == 5 ? '' : 'd-none'}} badge bg-success rounded-3 fw-semibold fs-2">Selesai</div>
              </div>
              <div>
                  <div class="{{$custom->production == null ? '' : 'd-none'}} badge bg-danger-subtle text-danger rounded-3 fw-semibold fs-2">Belum Diajukan Produksi</div>
                  <div class="{{$custom->production?->status == '0' ? '' : 'd-none'}} badge bg-light text-dark rounded-3 fw-semibold fs-2">Menunggu Produksi</div>
                  <div class="{{$custom->production?->status == 1 ? '' : 'd-none'}} badge bg-warning rounded-3 fw-semibold fs-2">Sedang Diproduksi</div>
                  <div class="{{$custom->production?->status == 2 ? '' : 'd-none'}} badge bg-success rounded-3 fw-semibold fs-2">Selesai Diproduksi</div>
              </div>
          </div>
          <hr>
          <div>
              <div class="d-flex align-items-start gap-2">
                  <div class="badge bg-success-subtle text-success rounded-3 fw-semibold fs-2">Updated
                      at
                      : {{ $custom->updated_at }}</div>
                  <div class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">Created
                      at
                      : {{ $custom->created_at }}</div>
              </div>
          </div>
          <hr>
          <div class="mt-2">
              <div class="fs-1 mb-1 text-muted">Penjelasan Produk yang akan dibuat</div>
              <div class="d-flex align-items-center" style="width:20em">
                  <img src="{{ $custom->product->image ? asset('storage/' . $custom->product->image) : '/assets/images/profile/user-1.jpg' }}"
                      class="rounded-2" alt="Raw Material Image {{ $custom->product->nama }}" style="width: 4em" />
                  <div class="ms-3">
                      <h6 class="fw-semibold mb-1">{{ $custom->product->nama }}</h6>
                      <span class="fw-normal line-clamp line-clamp-3"
                          style="white-space:normal; font-size:13px; ">{{ $custom->product->keterangan }}</span>
                  </div>
              </div>
              <div class="fw-normal fs-2"
                          style="white-space:normal;">{{ $custom->keterangan }}</div>
          </div>
          <hr>
          <div>
              <div class="d-flex align-items-center" style="width:20em">
                  <img src="{{ $custom->customer->image ? asset('storage/' . $custom->customer->image) : '/assets/images/profile/user-1.jpg' }}"
                      class="rounded-2" alt="Raw Material Image {{ $custom->customer->name }}" style="width: 4em" />
                  <div class="ms-3">
                      <h6 class="fw-semibold mb-1">{{ $custom->customer->name }}</h6>
                      <div class="fw-normal line-clamp line-clamp-3"
                          style="white-space:normal; font-size:13px; ">{{ $custom->customer->email }}</div>
                      <div class="fw-normal line-clamp line-clamp-3"
                          style="white-space:normal; font-size:13px; ">{{ $custom->customer->phone }}</div>
                  </div>
              </div>
          </div>
          <hr>
          <div class="d-flex align-items-center gap-3">
              @if($custom->status == '4')
                  <div class="mb-2">
                      <div class="fs-1">Total Harga</div>
                      <div class="fs-3 fw-bold text-primary">{{formatRupiah($custom->total_harga)}}</div>
                  </div>
                  <div class="mb-2">
                      <div class="fs-1">Dibayarkan</div>
                      <div class="fs-3 fw-bold text-success">{{formatRupiah($custom->total_harga)}}</div>
                  </div>
                  <div class="mb-2">
                      <div class="fs-1">Sisa</div>
                      <div class="fs-3 fw-bold text-danger">{{formatRupiah(0)}}</div>
                  </div>
              @else
                  <div class="text-danger fw-bold fs-2" style="max-width: 13em; white-space:normal">
                      Pembayaran tidak bisa dilakukan sebelum Harga Disepakati
                  </div>
              @endif
          </div>
      </div>
  </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="d-flex align-items-center gap-2">
      <h4 class="mb-0">Pembayaran</h4>
      <div class="d-flex rounded-circle align-items-center justify-content-center p-1 bg-primary text-white" style="aspect-ratio:1/1; width:2.4em; height:2.4em">
        3
      </div>
      <div class="d-flex align-items-center gap-2 ms-auto">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
          Tambah Pembayaran
        </button>

        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Tambah Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body pt-0" style="white-space:normal !important">
                <form action="{{route('custom-order.payment.store', $custom->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                      <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="total_dibayar" class="form-label">Tulis Nominal Pembayaran</label>
                        <input type="text" name="total_dibayar" id="total_dibayar" placeholder="Rp " class="input-rupiah form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tambah Pembayaran</button>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@if($custom->retur)
<div>
    <div colspan="8">
        <div class="accordion-item p-3 border border-danger rounded-3 border-dashed">
            <div class="accordion-button d-flex align-items-center justify-content-between gap-2" style="cursor: pointer">
                <div class="bg-danger p-1 px-2 h-100 rounded-2 text-white fw-bold d-inline-block">
                    <i class="ti ti-truck-return"></i>
                </div>
                <div class="flex-grow-1">
                    Pengembalian <span class="fs-1 text-muted ms-4">Klik untuk melihat detail</span>
                </div>
                <div class="{{$custom->retur->status == '0' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-light-subtle fs-2 rounded-2">Menunggu Pengembalian</div>
                <div class="{{$custom->retur->status == '1' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-danger text-white fs-2 rounded-2">Tidak Sah</div>
                <div class="{{$custom->retur->status == '2' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-success text-white fs-2 rounded-2">Terselesaikan</div>
            </div>
            <div class="accordion-content row mt-2" style="display: none;">
                <div class="col-md-6">
                    <div class="d-flex flex-column align-items-start gap-1 ">
                        <div class="fs-2 text-muted">Tanggapan Pengembalian</div>
                        <div class="fs-2 line-clamp line-clamp-2">{{$custom->retur->keterangan_aksi ?? 'Telah diterima dan diputuskan sesuai syarat dan ketentuan pengembalian'}}</div>
                        <a href="{{'/storage/'.$custom->retur->lampiran_aksi}}" target="_blank" class="btn btn-sm btn-light mt-2 fs-2 d-flex align-items-center gap-2">
                            <i class="ti ti-file"></i>
                            Lihat Bukti
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-end text-end flex-column gap-1">
                        <div class="fs-2 text-muted">Alasan Pengembalian</div>
                        <div class="fs-2 text-dark"><q>{{$custom->retur->keterangan}}</q></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



{{-- Modal --}}

<!-- Buat Pembayaran Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1"
    aria-labelledby="vertical-center-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Nego Harga
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0" style="white-space:normal !important">
                <p>Negoisasi harga Pesanan Khusus <strong>{{ $custom->code }}, Bijaklah dalam menentukan harga. Tulis semuanya di kolum keterangan</strong></p>
                <div class="fs-4 fw-bold text-primary mb-2">Harga Terkini {{formatRupiah($custom->total_harga)}}</div>
                <form action="{{route('custom-order.nego', $custom->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Negoisasi Harga</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Sepakat Modal -->
<div class="modal fade" id="okModal-{{$custom->id}}" tabindex="-1"
    aria-labelledby="vertical-center-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Sepakati Harga
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0" style="white-space:normal !important">
                <p>Sepakati harga sebesar {{formatRupiah($custom->total_harga)}} untuk Pesanan Khusus ini ({{$custom->code}}) ?</p>
                <form action="{{route('custom-order.approve', $custom->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">Sepakat</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal-{{$custom->id}}" tabindex="-1"
    aria-labelledby="vertical-center-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Tolak Penetapan Harga
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0" style="white-space:normal !important">
                <p>Tolak penetapan harga sebesar {{formatRupiah($custom->total_harga)}} untuk Pesanan Khusus ini ({{$custom->code}}) ?</p>
                <form action="{{route('custom-order.rejected', $custom->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">Tolak Penetapan Harga</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('scripts')
@endsection