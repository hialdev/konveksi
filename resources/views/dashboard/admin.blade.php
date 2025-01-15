@extends ('layouts.base')
@section('css')
    <link rel="stylesheet" href="/assets/libs/owl.carousel/dist/assets/owl.carousel.min.css" />
@endsection
@section('content')
    <section>
        <div class="card w-100 bg-primary-subtle overflow-hidden shadow-none">
            <div class="card-body position-relative">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="d-flex align-items-center mb-7">
                            <div class="rounded-circle overflow-hidden me-6">
                                <img src="{{ auth()->user()->image ? '/storage/'.auth()->user()->image : '/assets/images/profile/user-1.jpg'}}" alt="" width="40"
                                    height="40">
                            </div>
                            <h5 class="fw-semibold mb-0 fs-5">Selamat Datang {{auth()->user()->name}}!</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="border-end pe-4 border-muted border-opacity-10">
                                <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                                    {{formatRupiah(\App\Models\Order::calculateRevenueByStatus('2') + \App\Models\CustomOrder::calculateRevenue())}}
                                </h3>
                                <p class="mb-0 text-dark">Total Pendapatan</p>
                            </div>
                            <div class="ps-4">
                                <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                                    {{\App\Models\Order::where('status', '2')->orWhere('status', '4')->count() + \App\Models\Order::where('status','>', '3')->count()}}
                                </h3>
                                <p class="mb-0 text-dark">Total Pemesanan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="welcome-bg-img mb-n7 text-end">
                            <img src="/assets/images/backgrounds/welcome-bg.svg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="row">
            <!-- Column -->
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div
                                class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-success">
                                <i class="ti ti-credit-card fs-6"></i>
                            </div>
                            <div class="ms-3 align-self-center">
                                <h4 class="mb-0 fs-5">Pesanan Barang</h4>
                                <span class="text-muted">Total Pendapatan Valid</span>
                            </div>
                            <div class="ms-auto align-self-center">
                                <h2 class="fs-7 fw-bold mb-0" style="white-space: nowrap">
                                    {{ formatRupiah(\App\Models\Order::calculateRevenueByStatus('2')) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div
                                class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-info">
                                <i class="ti ti-credit-card fs-6"></i>
                            </div>
                            <div class="ms-3 align-self-center">
                                <h4 class="mb-0 fs-5">Pesanan Khusus</h4>
                                <span class="text-muted">Total Pendapatan Valid</span>
                            </div>
                            <div class="ms-auto align-self-center">
                                <h2 class="fs-7 fw-bold mb-0" style="white-space: nowrap">
                                    {{ formatRupiah(\App\Models\CustomOrder::calculateRevenue()) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
    </section>

    <section>
        <!--  Owl carousel -->
        <div class="owl-carousel counter-carousel owl-theme">
            <div class="item">
                <a href="{{route('user.index')}}" class="card border-0 zoom-in bg-primary-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="/assets/images/svgs/icon-user-male.svg" width="50" height="50" class="mb-3"
                                alt="" />
                            <p class="fw-semibold fs-3 text-primary mb-1">
                                Pegawai
                            </p>
                            <h5 class="fw-semibold text-primary mb-0">{{ \App\Models\User::role('employee')->count() }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{route('customer.index')}}" class="card border-0 zoom-in bg-warning-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="/assets/images/svgs/icon-briefcase.svg" width="50" height="50" class="mb-3"
                                alt="" />
                            <p class="fw-semibold fs-3 text-warning mb-1">Clients</p>
                            <h5 class="fw-semibold text-primary mb-0">{{ \App\Models\User::role('pelanggan')->count() }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{route('order.index')}}" class="card border-0 zoom-in bg-info-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="/assets/images/svgs/icon-mailbox.svg" width="50" height="50" class="mb-3"
                                alt="" />
                            <p class="fw-semibold fs-3 text-info mb-1">Pesanan</p>
                            <h5 class="fw-semibold text-info mb-0">{{ \App\Models\Order::count() }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{route('custom-order.index')}}" class="card border-0 zoom-in bg-light shadow-none" style="aspect-ratio:1/1">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="mb-3 text-dark">
                                <i class="ti ti-checklist" style="font-size: 35px"></i>
                            </div>
                            <p class="fw-semibold fs-2 text-dark mb-1">Pesanan Khusus</p>
                            <h5 class="fw-semibold text-dark mb-0">{{ \App\Models\CustomOrder::count() }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{route('request_production.index')}}" class="card border-0 zoom-in bg-success-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="ti ti-wand" style="font-size: 32px"></i>
                            </div>
                            <p class="fw-semibold fs-2 text-dark mb-1">Pengajuan Produksi</p>
                            <h5 class="fw-semibold text-dark mb-0">{{ \App\Models\RequestProduction::count() }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{{route('supplier.index')}}" class="card border-0 zoom-in bg-info-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="/assets/images/svgs/icon-connect.svg" width="50" height="50" class="mb-3"
                                alt="" />
                            <p class="fw-semibold fs-3 text-info mb-1">Suppliers</p>
                            <h5 class="fw-semibold text-info mb-0">{{ \App\Models\Supplier::count() }}</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/assets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>

    <script>
        $(function() {
            $(".counter-carousel").owlCarousel({
                loop: true,
                rtl: true,
                margin: 30,
                mouseDrag: true,
                autoplay: true,
                autoplayDuration: 2000,
                autoplayHoverPause: true,
                dots: false,
                nav: false,

                responsive: {
                    0: {
                        items: 2,
                        loop: true,
                    },
                    576: {
                        items: 2,
                        loop: true,
                    },
                    768: {
                        items: 3,
                        loop: true,
                    },
                    1200: {
                        items: 5,
                        loop: true,
                    },
                    1400: {
                        items: 6,
                        loop: true,
                    },
                },
            });
        })
    </script>
@endsection
