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
  <div class="card-body accordion-item">
    <div class="accordion-button border border-dashed border-primary rounded-3 p-2 px-3 d-flex align-items-center gap-2 justify-content-between" style="cursor: pointer">
        <div class="flex-grow-1">
            <div class="fs-1 text-muted">Kode Pesanan</div>
            <div class="fw-semibold fs-4 mb-0">
                {{ $custom->code }}
            </div>
        </div>
        <div class="fs-1 text-muted">Klik untuk melihat detail</div>
            <div class="d-flex align-items-center gap-2 ms-auto">
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
                <div>
                    <div class="{{$custom->remaining_payment == $custom->total_harga ? '' : 'd-none'}} border p-1 px-2 border-dark text-dark rounded-3 fw-semibold fs-2">Menunggu Pembayaran</div>
                    <div class="{{$custom->remaining_payment != 0 && $custom->remaining_payment < $custom->total_harga ? '' : 'd-none'}} border p-1 px-2 border-warning text-warning rounded-3 fw-semibold fs-2">Proses Pembayaran</div>
                    <div class="{{$custom->remaining_payment == 0 ? '' : 'd-none'}} border p-1 px-2 border-success text-success rounded-3 fw-semibold fs-2">Lunas</div>
                </div>
                <a href="{{route('pdf.preview', ['bladePath' => 'custom_orders.invoice' ,'type' => 'custom','id'=>$custom->id])}}" target="_blank" class="btn btn-danger d-flex align-items-center gap-2 rounded-pill">
                    <i class="fs-4 ti ti-file-invoice"></i>Report   
                </a>
            </div>
        </div>
        <div class="row accordion-content mt-3">
          <div class="col-md-6">
              <div>
                  <div class="d-flex flex-column align-items-start" style="width:20em">
                      
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
                  @if($custom->status > '4')
                      <div class="mb-2">
                          <div class="fs-1">Total Harga</div>
                          <div class="fs-3 fw-bold text-primary">{{formatRupiah($custom->total_harga)}}</div>
                      </div>
                      <div class="mb-2">
                          <div class="fs-1">Pembayaran Valid</div>
                          <div class="fs-3 fw-bold text-success">{{formatRupiah($custom->remaining_payment ? $custom->total_harga - $custom->remaining_payment : $custom->total_harga)}}</div>
                      </div>
                      <div class="mb-2">
                          <div class="fs-1">Sisa</div>
                          <div class="fs-3 fw-bold text-danger">{{formatRupiah($custom->remaining_payment)}}</div>
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
@endif

<div class="row mb-3">
  <div class="col-12">
    <div class="d-flex align-items-center gap-2">
      <h4 class="mb-0">Pembayaran</h4>
      <div class="d-flex rounded-circle align-items-center justify-content-center p-1 bg-primary text-white" style="aspect-ratio:1/1; width:2.4em; height:2.4em">
        {{count($custom->payments)}}
      </div>
      <div class="d-flex align-items-center gap-2 ms-auto">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
          Tambah Pembayaran
        </button>
        <button type="button" class="btn btn-primary-subtle btn-al-primary text-white" data-bs-toggle="modal" data-bs-target="#bankModal">
          List Rekening
        </button>
        <a href="{{route('pdf.preview', ['bladePath' => 'custom_orders.payment.kwitansi' ,'type' => 'custom','id'=>$custom->id])}}" target="_blank" class="btn btn-danger d-flex align-items-center gap-2 rounded-pill">
            <i class="fs-4 ti ti-file-invoice"></i>Kwitansi Pembayaran   
        </a>
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
                        <input type="text" name="total_dibayar" id="total_dibayar" placeholder="Sisa {{formatRupiah($custom->remaining_payment)}}" class="input-rupiah form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tambah Pembayaran</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="bankModal" tabindex="-1" aria-labelledby="bankModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="bankModalLabel">List Rekening untuk Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body pt-0" style="white-space:normal !important">
                @forelse ($banks as $bank)
                  <div class="d-flex align-items-center gap-4 p-3 rounded-4 border border-primary">
                    <img src="{{$bank->logo ? '/storage/'.$bank->logo : ''}}" alt="Bank {{$bank->nama_bank}} Logo" class="d-block rounded-3" style="aspect-ratio:3/2; object-fit:contain; height:5em;">
                    <div>
                      <div class="fs-4 fw-bold text-dark">{{$bank->nama_bank}}</div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="rekening-number" id="rekening-2">{{$bank->no_rekening}}</span>
                        <button class="btn btn-sm p-1 px-1 btn-light" onclick="copyToClipboard('#rekening-2')">
                          <i class="ti ti-copy"></i>
                        </button>
                      </div>
                      <div>a.n {{$bank->nama_rekening}}</div>
                    </div>
                  </div> 
                @empty
                  <div class="p-4 rounded-3 text-center border border-danger border-dashed">
                      Belum ada Rekening Bank, Konfirmasi Admin untuk Rekening Bank
                  </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@forelse($custom->payments as $pay)
<div class="card">
  <div class="card-body">
    <div class="d-flex align-items-center gap-4">
      <a href="{{$pay->bukti_pembayaran ? '/storage/'.$pay->bukti_pembayaran : '#'}}" target="_blank" class="p-2 bg-primary-subtle gap-2 border border-primary text-primary rounded-2 d-flex align-items-center justify-content-center">
        <i class="ti ti-file fs-5"></i>
        Bukti Pembayaran
      </a>
      <div>
        <div class="{{$pay->status == '0' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-light-subtle fs-2 rounded-2">Menunggu Konfirmasi</div>
        <div class="{{$pay->status == '1' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-danger text-white fs-2 rounded-2">Tidak Sah</div>
        <div class="{{$pay->status == '2' ? '' : 'd-none'}} ms-auto p-1 px-2 bg-success text-white fs-2 rounded-2">Terkonfirmasi</div>
      </div>
      <div class="ms-auto text-end">
        <div class="fs-2 text-muted">Total Pembayaran</div>
        <div class="fs-5 mb-0 fw-bold text-primary">{{formatRupiah($pay->total_dibayar)}}</div>
        <div class="fs-2 {{$pay->status == '0' ? '' : 'd-none'}} text-danger">dari sisa {{formatRupiah($custom->remaining_payment)}}</div>
      </div>
      <div class="dropdown dropstart">
          <a href="#" class="text-muted" id="dropdownMenuButton"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="ti ti-dots fs-5"></i>
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              @role(['admin', 'employee', 'developer'])
                @if($pay->status == 0)
                <li>
                    <button type="button" class="dropdown-item text-success d-flex align-items-center gap-3"
                            data-bs-toggle="modal" data-bs-target="#approveModal-{{$pay->id}}"
                    >
                      <i class="fs-4 ti ti-check"></i>Verifikasi
                    </bUtton>
                </li>
                <li>
                    <button type="button" class="dropdown-item text-danger d-flex align-items-center gap-3"
                        data-bs-toggle="modal" data-bs-target="#rejectModal-{{$pay->id}}"><i
                            class="fs-4 ti ti-credit-card-off"></i>Pembayaran Invalid</button>
                </li>
                @endif
              @endrole
              <li>
                  <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                    data-bs-toggle="modal" data-bs-target="#editModal-{{$pay->id}}"
                  ><i
                          class="fs-4 ti ti-edit"></i>Edit</bUtton>
              </li>
              <li>
                  <button type="button" class="dropdown-item d-flex align-items-center gap-3"
                      data-bs-toggle="modal" data-bs-target="#deleteModal-{{$pay->id}}"><i
                          class="fs-4 ti ti-trash"></i>Delete</button>
              </li>
          </ul>
      </div>

    </div>
  </div>
</div>

@role(['admin', 'developer', 'employee'])
<div class="modal fade" id="approveModal-{{$pay->id}}" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approveModalLabel">Konfirmasi / Verifikasi Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0" style="white-space:normal !important">
          <p>Verifikasi Pembayaran sejumlah {{formatRupiah($pay->total_dibayar)}} pada Pesanan Khusus ini ({{$custom->code}}) ?</p>
          <form action="{{route('custom-order.payment.approve', ['id' => $custom->id, 'pay_id' => $pay->id])}}" method="post" enctype="multipart/form-data">
              @csrf
              <button type="submit" class="btn btn-success w-100">Ya, Konfirmasi Diterima</button>
          </form>
      </div>
    </div>
  </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal-{{$pay->id}}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Tidak Sah-kan Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0" style="white-space:normal !important">
          <p>Tetapkan sebagai Tidak Sah untuk Pembayaran sejumlah {{formatRupiah($pay->total_dibayar)}} pada Pesanan Khusus ini ({{$custom->code}}) ?</p>
          <form action="{{route('custom-order.payment.rejected', ['id' => $custom->id, 'pay_id' => $pay->id])}}" method="post" enctype="multipart/form-data">
              @csrf
              <button type="submit" class="btn btn-danger w-100">Tetapkan Tidak Sah</button>
          </form>
      </div>
    </div>
  </div>
</div>
@endrole

<div class="modal fade" id="editModal-{{$pay->id}}" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Perbarui Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0" style="white-space:normal !important">
        <form action="{{route('custom-order.payment.update', ['id' => $custom->id, 'pay_id' => $pay->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <a href="{{'/storage/'.$pay->bukti_pembayaran}}" target="_blank" class="p-2 mb-2 rounded-2 px-3 d-flex align-items-center bg-primary-subtle text-primary gap-3 line-clamp line-clamp-2" style="white-space: normal">
              <i class="ti ti-file"></i>
              {{ $pay->bukti_pembayaran }}
            </a>
            <div class="mb-3">
              <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
              <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control">
            </div>
            <div class="mb-3">
                <label for="total_dibayar" class="form-label">Tulis Nominal Pembayaran</label>
                <input type="text" name="total_dibayar" id="total_dibayar" placeholder="Sisa {{formatRupiah($custom->remaining_payment)}}" class="input-rupiah form-control" value="{{formatRupiah($pay->total_dibayar)}}">
            </div>
            <button type="submit" class="btn btn-secondary w-100">Perbarui Pembayaran</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal-{{$pay->id}}" class="modal fade" tabindex="-1"
    aria-labelledby="danger-header-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content p-3 modal-filled bg-danger">
            <div class="modal-header modal-colored-header text-white">
                <h4 class="modal-title text-white" id="danger-header-modalLabel">
                    Yakin ingin menghapus Pembayaran pada Pesanan ({{$custom->code}}) ?
                </h4>
                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="width: fit-content; white-space:normal">
                <h5 class="mt-0 text-white">Pembayaran sebesar {{formatRupiah($pay->total_dibayar)}} pada Pesanan Khusus {{$custom->code}} akan dihapus</h5>
                <p class="text-white">Segala data yang berkaitan dengan Pembayaran tersebut juga akan dihapus secara permanen.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Close
                </button>
                <form action="{{route('custom-order.payment.destroy', ['id' => $custom->id, 'pay_id' => $pay->id])}}" method="POST">
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
@empty
<div class="d-flex align-items-center justify-content-center p-4 rounded-4 border border-dashed border-primary">
  Silahkan lakukan Pembayaran, apabila harga telah diSepakati
</div>
@endforelse


@endsection
@section('scripts')
<script>
$(document).ready(function() {
    window.copyToClipboard = function(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();

      alert('Rekening berhasil di copy');
    }

    $('.accordion-content').hide();
    // Menangani klik pada setiap tombol accordion dalam loop
    $('.accordion-button').click(function() {
        // Cari konten yang terkait dengan tombol yang diklik
        const content = $(this).closest('.accordion-item').find('.accordion-content');
        content.slideToggle();
    });
    
});
</script>
@endsection