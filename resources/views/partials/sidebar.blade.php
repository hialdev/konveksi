<!-- Sidebar Start -->
<aside class="left-sidebar with-vertical">
    <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="text-nowrap logo-img">
                <img src="/storage/{{setting('site.logo')}}" class="{{env('APP_NAME')}}" alt="Tanur Logo"
                    style="height: 4em; width:auto; object-fit:contain;" />
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>


        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <!-- ---------------------------------- -->
                <!-- Home -->
                <!-- ---------------------------------- -->
                <li class="nav-small-cap mt-2">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item {{ Route::is('home') ? 'selected' : '' }}">
                    <a href="{{ route('home') }}" class="sidebar-link" aria-expanded="false">
                        <span>
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                {{-- <li class="nav-small-cap mt-2">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Customer Menu</span>
                </li> --}}
                <li class="sidebar-item {{ Route::is('product.etalase') ? 'selected' : '' }}">
                    <a href="{{ route('product.etalase') }}" class="sidebar-link" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-grid"></i>
                        </span>
                        <span class="hide-menu">Etalase</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('order.my') ? 'selected' : '' }}">
                    <a href="{{ route('order.my') }}" class="sidebar-link" aria-expanded="false">
                        <span>
                            <i class="ti ti-shopping-cart"></i>
                        </span>
                        <span class="hide-menu">Pesanan Saya</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('custom-order.my') ? 'selected' : '' }}">
                    <a href="{{ route('custom-order.my') }}" class="sidebar-link" aria-expanded="false">
                        <span>
                            <i class="ti ti-checklist"></i>
                        </span>
                        <span class="hide-menu">Pesanan Khusus Saya</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('desain.index') ? 'selected' : '' }}">
                    <a href="{{ route('desain.index') }}" class="sidebar-link" aria-expanded="false">
                        <span>
                            <i class="ti ti-paint"></i>
                        </span>
                        <span class="hide-menu">Desain / Konsep Saya</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item {{ Route::is('etalase') ? 'selected' : '' }}">
                    <a href="{{ route('home') }}" class="sidebar-link" aria-expanded="false">
                        <span>
                            <i class="ti ti-star"></i>
                        </span>
                        <span class="hide-menu">Ulasan Saya</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('etalase') ? 'selected' : '' }}">
                    <a href="{{ route('home') }}" class="sidebar-link" aria-expanded="false">
                        <span>
                            <i class="ti ti-truck-return"></i>
                        </span>
                        <span class="hide-menu">Pengembalian Saya</span>
                    </a>
                </li> --}}
                
                @if(auth()->user() && auth()->user()->getRoleNames()[0] != 'pelanggan')
                    <li class="nav-small-cap mt-2">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Data Master</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-basket"></i>
                            </span>
                            <span class="hide-menu">Produk</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('product.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Semua Produk</span>
                                </a>
                            </li>
                            @role(['admin', 'developer'])
                            <li class="sidebar-item">
                                <a href="{{ route('product.add') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Tambah Produk</span>
                                </a>
                            </li>
                            @endrole
                            <li class="sidebar-item">
                                <a href="{{ route('category.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Semua Kategori Produk</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item {{ Route::is('supplier.*') ? 'selected' : '' }}">
                        <a href="{{ route('supplier.index') }}" class="sidebar-link" aria-expanded="false">
                            <span>
                                <i class="ti ti-user-circle"></i>
                            </span>
                            <span class="hide-menu">Supplier</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-atom-2"></i>
                            </span>
                            <span class="hide-menu">Bahan Baku</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('raw_material.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Semua Bahan Baku</span>
                                </a>
                            </li>
                            @role(['admin', 'developer'])
                            <li class="sidebar-item">
                                <a href="{{ route('raw_material.add') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Tambah Bahan Baku</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('raw_material.purchase.add') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Catat Pembelian Bahan Baku</span>
                                </a>
                            </li>
                            @endrole
                        </ul>
                        
                    </li>

                    @role(['admin', 'developer'])
                   <li class="sidebar-item {{ Route::is('bank.*') ? 'selected' : '' }}">
                        <a href="{{ route('bank.index') }}" class="sidebar-link" aria-expanded="false">
                            <span>
                                <i class="ti ti-credit-card"></i>
                            </span>
                            <span class="hide-menu">Rekening Bank</span>
                        </a>
                    </li>
                    @endrole

                    <li class="sidebar-item {{ Route::is('customer.*') ? 'selected' : '' }}">
                        <a href="{{ route('customer.index') }}" class="sidebar-link" aria-expanded="false">
                            <span>
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">Pelanggan</span>
                        </a>
                    </li>

                    <li class="nav-small-cap mt-0">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Business Process</span>
                    </li>
                    @role(['admin', 'developer'])
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-shopping-cart-plus"></i>
                            </span>
                            <span class="hide-menu">Pembelian Bahan Baku</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('raw_material.purchase.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Semua Pembelian</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('raw_material.purchase.add') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Tambah Pembelian</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-wand"></i>
                            </span>
                            <span class="hide-menu">Pengajuan Produksi</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('request_production.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Semua Pengajuan</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('request_production.add') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Buat Pengajuan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            <span class="hide-menu">Pesanan</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('order.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Semua Pesanan</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('order.waiting') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Menunggu Verifikasi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-checklist"></i>
                            </span>
                            <span class="hide-menu">Pesanan Khusus</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('custom-order.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Semua Pesanan Khusus</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('custom-order.add') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Buat Pesanan Khusus</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a href="{{ route('home') }}" class="sidebar-link" aria-expanded="false">
                            <span>
                                <i class="ti ti-truck-return"></i>
                            </span>
                            <span class="hide-menu">Pengembalian</span>
                        </a>
                    </li> --}}

                    @role(['admin', 'developer'])
                        <!-- ---------------------------------- -->
                        <!-- User Management -->
                        <!-- ---------------------------------- -->
                        <li class="nav-small-cap mt-0">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Site Management</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="hide-menu">User</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('user.index') }}" class="sidebar-link">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Semua User</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('user.add') }}" class="sidebar-link">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Tambah</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('setting.index') }}" class="sidebar-link" aria-expanded="false">
                                <span>
                                    <i class="ti ti-settings"></i>
                                </span>
                                <span class="hide-menu">Settings</span>
                            </a>
                        </li>
                    @endrole
                @endif
            </ul>
        </nav>
        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                    <img src="{{ auth()->user() && auth()->user()->image ? '/storage/'. auth()->user()->image : '/assets/images/profile/user-1.jpg' }}"
                        class="rounded-circle" width="40" height="40" style="object-fit: cover"
                        alt="Image User {{ auth()->user() ? auth()->user()->name : 'Pengunjung' }}" />
                </div>
                <div class="john-title">
                    <h6 class="mb-0 fs-2 fw-semibold">{{ auth()->user() ? auth()->user()->name : 'Pengunjung' }}</h6>
                    <span class="fs-2">{{ auth()->user() ? auth()->user()->getRoleNames()[0] : 'Masuk Dahulu' }}</span>
                </div>
                @if(auth()->user())
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="border-0 bg-transparent text-primary ms-auto" tabindex="0"
                        aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Keluar">
                        <i class="ti ti-power fs-6"></i>
                    </button>
                </form>
                @else
                    <a href="{{route('login')}}" class="border-0 bg-transparent text-primary ms-auto" tabindex="0"
                        aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Masuk">
                        <i class="ti ti-login fs-6"></i>
                    </a>
                @endif
            </div>
        </div>
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
    </div>
</aside>
<!--  Sidebar End -->
