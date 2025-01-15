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
                    <h4 class="fw-semibold mb-8">Etalase Product</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Etalase</li>
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
        <div class="col-12">
            <div>
                <form action="{{ route('product.etalase') }}" method="GET" class="w-100">
                    <div class="row align-items-end mb-3 flex-wrap">
                        <div class="col-md-4 mb-2 flex-grow-1">
                            <label for="search" class="form-label">Filter Produk</label>
                            <input type="text" class="form-control" placeholder="Cari Nama / Deskripsi" name="search"
                                value="{{ $filter->q ?? '' }}">
                        </div>
                        <div class="col-md-3 mb-2 flex-grow-1">
                            <label for="order" class="form-label">Urutkan dengan Harga</label>
                            <select name="order" id="order" class="form-select">
                                <option value="desc" {{ $filter->order == 'desc' ? 'selected' : '' }}>Terbesar</option>
                                <option value="asc" {{ $filter->order == 'asc' ? 'selected' : '' }}>Terkecil</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="d-flex align-items-center gap-1">
                                <button type="submit" class="btn btn-primary w-100"
                                    style="white-space: nowrap">Apply</button>
                                <a href="{{ url()->current() }}" class="btn btn-secondary" style="white-space: nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2v2a8 8 0 1 0 4.5 1.385V8h-2V2h6v2H18a9.99 9.99 0 0 1 4 8" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                        <div class="card rounded-4 overflow-hidden">
                            <div class="card-body p-0">
                                <img src="{{ $product->image ? '/storage/' . $product->image : '/storage/' . setting('site.logo') }}"
                                    alt="Image {{ $product->nama }}" class="d-block w-100 rounded-4 mb-2">
                                <div class="p-1 px-3">
                                    <div class="fs-3 text-primary fw-semibold line-clamp line-clamp-2">
                                        {{ formatRupiah($product->harga) }}</div>
                                    <a href="{{ route('product.show', $product->slug) }}"
                                        class="text-decoration-none text-dark fs-4">{{ $product->nama }}</a>
                                    <p class="fs-2 line-clamp line-clamp-2">{{ $product->keterangan }}</p>
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <a href="{{ route('product.show', $product->slug) }}"
                                            class="btn btn-sm btn-light"><i class="ti ti-eye"></i></a>
                                        <button type="submit"
                                            class="{{ isset($carts[$product->id]) ? '' : 'd-none' }} fs-3 px-3 w-100 text-center justify-content-center btn-sm btn btn-primary rounded-2 d-flex align-items-center gap-2"
                                            disabled>
                                            <i class="ti ti-shopping-cart-plus"></i>
                                            <span class="fs-2" style="white-space: nowrap">Sudah Ada</span>
                                        </button>
                                        <form action="{{ route('product.addCart') }}" method="POST"
                                            class="{{ isset($carts[$product->id]) ? 'd-none' : '' }}" style="flex-grow: 1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit"
                                                class="fs-3 px-3 w-100 text-center justify-content-center btn-sm btn btn-primary rounded-2 d-flex align-items-center gap-2">
                                                <i class="ti ti-shopping-cart-plus"></i>
                                                <span class="fs-2">Tambah</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="position-fixed bottom-0 end-0 m-3">
        <div class="d-flex align-items-center justify-content-center p-3 bg-white text-primary position-relative shadow rounded-circle border" style="aspect-ratio:1/1 !important; cursor:pointer"
          data-bs-toggle="modal" data-bs-target="#cartModal">
          <i class="ti ti-shopping-cart fs-6"></i>
          <div class="d-flex align-items-center justify-content-center p-1 rounded-circle bg-primary text-white position-absolute fs-2 top-0 end-0" style="aspect-ratio:1/1; width:20px; height:20px; margin-top:-3px; margin-right:-3px">
            {{count($carts)}}
          </div>
        </div>
    </div>
    <!-- Cart Small to Large Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1"
        aria-labelledby="vertical-center-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Keranjang Produk
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-white">
                        <div class="border border-2 border-dashed border-dark-subtle rounded-4 p-3">
                            @forelse ($carts as $item)
                                @php
                                    $cart = \App\Models\Product::find($item['id']);
                                    $subtotal = $cart->harga * $item['qty'];
                                    $totalPrice += $subtotal;
                                @endphp
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ $cart->image ? '/storage/' . $cart->image : 'https://placehold.co/300' }}"
                                        alt="Image Product {{ $cart->nama }} in Cart" class="d-block rounded-2"
                                        style="width: 5em; height:5em; object-fit:cover">
                                    <div>
                                        <div class="fs-3 fw-semibold line-clamp line-clamp-2">{{ $cart->nama }}</div>
                                        <div class="fs-2 line-clamp line-clamp-2">{{ formatRupiah($cart->harga) }}</div>
                                        <div class="d-flex mt-2 align-items-center gap-2">
                                            <input type="hidden" name="product_id" id="product_id_{{ $item['id'] }}" value="{{ $item['id'] }}">
                                            <button type="button" class="btn btn-sm btn-danger" onclick="updateQuantity('decrement', '{{ $item['id'] }}')">
                                                <i class="ti ti-minus"></i>
                                            </button>
                                            <input 
                                                type="number" 
                                                name="qty" 
                                                id="qty_{{ $item['id'] }}" 
                                                class="form-control form-control-sm" 
                                                value="{{ $item['qty'] }}" 
                                                onblur="updateQuantity('update', '{{ $item['id'] }}')">
                                            <button type="button" class="btn btn-sm btn-primary" onclick="updateQuantity('increment', '{{ $item['id'] }}')">
                                                <i class="ti ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 d-flex flex-column align-items-end gap-2 justify-content-between">
                                        <div class="fs-2 fw-semibold">Sub Total</div>
                                        <div class="fs-3 fw-bold" id="subtotal_{{ $item['id'] }}">{{ formatRupiah($subtotal) }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center fs-3 p-5 border border-2 border-dashed border-primary rounded-4">Keranjang
                                    Kosong</div>
                            @endforelse
                            <div class="pt-3 mt-3 border-top border-2">
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="fs-3 fw-semibold">Total</div>
                                    <div class="fs-4 fw-bold" id="totalPrice">{{ formatRupiah($totalPrice) }}</div>
                                </div>
                                <a href="{{ route('order.add') }}" class="btn btn-primary w-100 mt-2">Pesan Barang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
function updateQuantity(action, productId) {
    const qtyInput = document.getElementById(`qty_${productId}`);
    let qty = parseInt(qtyInput.value);

    if (action === 'decrement' && qty > 1) {
        qty -= 1;
    } else if (action === 'increment') {
        qty += 1;
    }

    // Update nilai input
    qtyInput.value = qty;

    // AJAX request untuk mengupdate kuantitas di server
    fetch("{{ route('product.updateQty') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ product_id: productId, qty: qty })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const price = parseFloat(data.product_price);
            const subtotalElement = document.querySelector(`#subtotal_${productId}`);
            const totalPriceElement = document.querySelector("#totalPrice");
            const finalPriceElement = document.querySelector("#finalPrice");
            const ppnPercentage = parseFloat("{{ setting('site.ppn') }}");

            // Update subtotal
            const subtotal = price * qty;
            subtotalElement.textContent = formatRupiah(subtotal);

            // Hitung ulang totalPrice
            let totalPrice = 0;
            data.cart.forEach(item => {
                totalPrice += item.harga * item.qty;
            });

            // Hitung PPN dan finalPrice
            const ppn = totalPrice * (ppnPercentage / 100);
            const finalPrice = totalPrice + ppn;

            // Update totalPrice dan finalPrice di UI
            totalPriceElement.textContent = formatRupiah(totalPrice);
            finalPriceElement.textContent = formatRupiah(finalPrice);
        } else {
            console.error("Gagal memperbarui jumlah produk:", data.message);
        }
    })
    .catch(error => {
        console.error("Terjadi kesalahan:", error);
    });
}
</script>
@endsection
