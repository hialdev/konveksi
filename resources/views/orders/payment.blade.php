@extends('layouts.base')
@section('content')
@php
  $carts = session()->get('cart', []);
  $totalPrice = 0;
@endphp
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Bayar Pesanan dan Upload Bukti Pembayaran</h4>
                    <div class="fs-3">Kode Pesanan : {{$order->code}}</div>
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
      <div class="col-12">
        @if($order->status == 1)
        <div class="card bg-warning-subtle">
          <div class="card-body">
            <div style="max-width:40em" class="mx-auto d-flex flex-column align-items-center">
              <div class="d-flex mb-3 align-items-center justify-content-center gap-3" style="max-width: 25em">
                <i class="ti ti-clock text-warning" style="font-size: 6rem"></i>
                <h4 class="text-warning mb-0">Terimakasih telah melakukan pembayaran!</h4>
              </div>
              <p class="text-center">Kami akan memverifikasi terlebih dahulu Bukti Pembayaran anda, biasanya hanya dalam beberapa jam saja</p>
            </div>
          </div>
        </div>
        @endif

        @if($order->status == 2)
        <div class="card bg-success-subtle">
          <div class="card-body">
            <div style="max-width:40em" class="mx-auto d-flex flex-column align-items-center">
              <div class="d-flex mb-3 align-items-center justify-content-center gap-3" style="max-width: 25em">
                <i class="ti ti-check text-success" style="font-size: 6rem"></i>
                <h4 class="text-success mb-0">Pesanan anda Disetujui dan Segera Diproses!</h4>
              </div>
              <p class="text-center">Bukti pembayaran anda valid, kami akan segera memproses pesanan anda secepatnya.</p>
            </div>
          </div>
        </div>
        @endif

        @if($order->status == 3)
        <div class="card bg-danger-subtle">
          <div class="card-body">
            <div style="max-width:40em" class="mx-auto d-flex flex-column align-items-center">
              <div class="d-inline-flex mb-3 align-items-center justify-content-center gap-3" style="max-width: 25em">
                <i class="ti ti-shopping-cart-off text-danger" style="font-size: 6rem"></i>
                <h4 class="text-danger mb-0">Pesanan anda Bermasalah atau Kadaluarsa!</h4>
              </div>
              <p class="text-center">Bukti Pembayaran yang anda lampirkan tidak valid / tidak terverifikasi / Kadaluarsa, Beli Ulang atau Upload bukti pembayaran ulang yang sesuai dan silahkan hubungi admin untuk masalah lebih lanjut</p>
            </div>
          </div>
        </div>
        @endif
      </div>
      <div class="col-md-7">

        <div class="card {{$order->status != 0 ? 'd-none' : ''}}">
          <div class="card-body">
            <div class="text-center">
              <div class="fs-3">Bayar Sebesar</div>
              <div class="fs-6 fw-bold mb-4">{{formatRupiah($order->total_harga)}}</div>
              <div class="p-4 rounded-4 bg-primary-subtle">
                <div class="fs-3">Bayar dan Upload Bukti Pembayaran dalam waktu</div>
                <div id="countdown" class="fs-6 fw-bold text-primary"></div>
                <div class="fs-2">atau pesanan akan dihapus secara otomatis</div>
              </div>
            </div>
          </div>
        </div>

        @if ($order->status == '3')
        <div class="card">
          <div class="card-body">
            <h5>Beli Ulang Pesanan</h5>
            <div>
              <p>Pesanan anda invalid dikarenakan bukti pembayaran yang tidak sah atau pesanan telah kadaluarsa. Klik tombol Beli Ulang untuk membuat pesanan baru dengan detail pesanan produk yang sama.</p>
              <form action="{{route('order.reorder', $order->id)}}" method="POST">
                @csrf
                <button class="btn btn-primary w-100">Beli Ulang</button>
              </form>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div data-target="#produk" class="accordion-button d-flex align-items-center justify-content-between gap-3" style="cursor: pointer">
              <h5 class="mb-0">Rincian Barang yang dibeli</h5>
              @php
                  $produk = json_decode($order->produk, true);
              @endphp
              <div class="d-flex align-items-center justify-content-center p-2 rounded-circle bg-primary text-white fw-bold" style="width:2.5em;height:2.5em">
                {{count($produk)}}
              </div>

              <div class="flex-grow-1 d-flex justify-content-end">
                <div class="d-flex align-items-center border border-primary justify-content-center p-2 rounded-circle bg-primary-subtle text-primary fw-bold" style="width:2.5em;height:2.5em; cursor:pointer">
                  <i class="ti ti-arrow-down"></i>
                </div>
              </div>
            </div>

            <div id="produk" class="accordion-content-box my-4">
              @foreach ($produk as $item)
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
                        <div class="d-inline-block p-1 px-2 fs-1 mt-2 rounded-3 bg-primary-subtle text-dark">{{$item['qty']}} Qty</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex flex-column mb-3 align-items-end gap-2 justify-content-between">
                      <div class="fs-2 fw-semibold">Sub Total</div>
                      <div class="fs-3 fw-bold">{{formatRupiah($subtotal)}}</div>
                    </div>
                  </div>
                </div>
              @endforeach
              <div class="pt-3 mt-3 bg-light p-3 rounded-4">
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
              </div>
            </div>
          </div>
        </div>
        @else
        <div class="card">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Upload Bukti Pembayaran</h5>
            <hr>
            <div class="mb-3">
              @if(isPdf($order->bukti_pembayaran))
              <div id="placeholder-file" class="">
                  <a href="{{$order->bukti_pembayaran ? '/storage/'.$order->bukti_pembayaran : '#'}}" target="_blank" id="preview-file-link" class="d-flex align-items-center gap-2 p-2 rounded-2 border border-al-primary" target="_blank">
                      <i class="ti ti-file fs-6"></i>
                      <div id="preview-file-text" class="fs-2 line-clamp line-clamp-2">{{$order->bukti_pembayaran}}</div>
                  </a>
                  <embed src="{{ asset('storage/' . $order->bukti_pembayaran) }}" class="rounded-4 overflow-hidden mt-3" width="100%" height="600px" type="application/pdf">
              </div>
              @elseif(isImage($order->bukti_pembayaran))
              <img src="{{$order->bukti_pembayaran ? '/storage/'.$order->bukti_pembayaran : '#'}}" id="placeholder-file" alt="Raw Material Image Preview" class="rounded-4 w-100"
                  style="">
              @else
              
              @endif
              <img src="" id="preview-image" alt="Raw Material Image Preview" class="d-none rounded-4 w-100"
                  style="">
              <div id="preview-file" class="d-none">
                  <a href="" id="preview-file-link" class="d-flex align-items-center gap-2 p-2 rounded-2 border border-al-primary" target="_blank">
                      <i class="ti ti-file fs-6"></i>
                      <div id="preview-file-text" class="fs-2 line-clamp line-clamp-2">File Name</div>
                  </a>
                  <embed id="preview-file-embed" src="" class="rounded-4 overflow-hidden mt-3" width="100%" height="600px" type="application/pdf">
              </div>
            </div>
            <div class="position-sticky bottom-0 py-3 bg-white">
              @if($order->status == 0 || $order->status == 1)
              <form action="{{route('order.paid', $order->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-semibold">Lampirkan Bukti Pembayaran </label>
                    <div class="input-group">
                        <span class="input-group-text px-6" id="basic-addon1"><i
                                class="ti ti-file fs-6"></i></span>
                        <input type="file" name="bukti_pembayaran" class="form-control ps-2">
                    </div>
                    @error('attachment')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <button class="btn btn-primary w-100">Upload Bukti</button>
              </form>
              @endif
              @if($order->status == 1 && auth()->user()->getRoleNames()[0] != 'pelanggan')
              <div class="p-4 rounded-4 mt-3 bg-primary-subtle">
                <form action="{{route('order.approve', $order->id)}}" method="POST">
                  @csrf
                  <p>Sebagai admin / pegawai anda dapat mengaprove pesanan ini, namun <strong>pastikan pembayaran telah diterima</strong></p>
                  <button class="btn btn-success w-100">Approve Pesanan</button>
                </form>
              </div>
              @endif
            </div>
          </div>
        </div>
        @endif

      </div>
      <div class="col-md-5">
        <div class="card">
          <div class="card-body">
            <div data-target="#rekening" class="accordion-button d-flex align-items-center justify-content-between gap-3" style="cursor: pointer">
              <h5 class="mb-0">Bayar Ke Rekening</h5>
              <div class="flex-grow-1 d-flex justify-content-end">
                <div class="d-flex align-items-center border border-primary justify-content-center p-2 rounded-circle bg-primary-subtle text-primary fw-bold" style="width:2.5em;height:2.5em; cursor:pointer">
                  <i class="ti ti-arrow-down"></i>
                </div>
              </div>
            </div>

            <div id="rekening" class="accordion-content-box my-4">
              <div class="row">
                <div class="col-12">
                  @forelse ($banks as $bank)
                    <div class="d-flex align-items-center gap-4 p-4 rounded-4 border border-primary">
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

        @if($order->status != '3')
        <div class="card">
          <div class="card-body">
            <div data-target="#produk" class="accordion-button d-flex align-items-center justify-content-between gap-3" style="cursor: pointer">
              <h5 class="mb-0">Rincian Barang yang dibeli</h5>
              @php
                  $produk = json_decode($order->produk, true);
              @endphp
              <div class="d-flex align-items-center justify-content-center p-2 rounded-circle bg-primary text-white fw-bold" style="width:2.5em;height:2.5em">
                {{count($produk)}}
              </div>

              <div class="flex-grow-1 d-flex justify-content-end">
                <div class="d-flex align-items-center border border-primary justify-content-center p-2 rounded-circle bg-primary-subtle text-primary fw-bold" style="width:2.5em;height:2.5em; cursor:pointer">
                  <i class="ti ti-arrow-down"></i>
                </div>
              </div>
            </div>

            <div id="produk" class="accordion-content-box my-4">
              @foreach ($produk as $item)
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
                        <div class="d-inline-block p-1 px-2 fs-1 mt-2 rounded-3 bg-primary-subtle text-dark">{{$item['qty']}} Qty</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex flex-column mb-3 align-items-end gap-2 justify-content-between">
                      <div class="fs-2 fw-semibold">Sub Total</div>
                      <div class="fs-3 fw-bold">{{formatRupiah($subtotal)}}</div>
                    </div>
                  </div>
                </div>
              @endforeach
              <div class="pt-3 mt-3 bg-light p-3 rounded-4">
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
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
    
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            window.copyToClipboard = function(element) {
              var $temp = $("<input>");
              $("body").append($temp);
              $temp.val($(element).text()).select();
              document.execCommand("copy");
              $temp.remove();

              alert('Rekening berhasil di copy');
            }
            
            const fileInput = document.querySelector('input[type="file"][name="bukti_pembayaran"]');
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

            let remainingTime = {{ $remainingTime }}; // Sisa waktu dalam detik
            console.log(remainingTime);
            function startCountdown() {
                let countdownElement = document.getElementById('countdown');

                let timer = setInterval(function () {
                    let hours = Math.floor(remainingTime / 3600);
                    let minutes = Math.floor((remainingTime % 3600) / 60);
                    let seconds = remainingTime % 60;

                    countdownElement.innerText = `${hours}h ${minutes}m ${seconds}s`;

                    remainingTime--;

                    if (remainingTime < 0) {
                        clearInterval(timer);
                        countdownElement.innerText = 'Pesanan Kadaluarsa';
                    }
                }, 1000);
            }

            startCountdown();

            let btnAccordion = $('.accordion-button');
            let contentAccordion = $('.accordion-content-box');
            contentAccordion.hide();
            $('#rekening').show();
            btnAccordion.click(function () {
                let id = $(this).data('target');
                $(id).slideToggle();
            });

        });
    </script>
@endsection
