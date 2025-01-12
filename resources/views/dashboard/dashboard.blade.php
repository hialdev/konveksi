@extends ('layouts.base')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card w-100 bg-info-subtle overflow-hidden shadow-none">
                <div class="card-body py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-sm-6">
                            <h5 class="fw-semibold mb-9 fs-5">{{setting('site.dashboard-greeting')}}.. {{auth()->user()->name}}!</h5>
                            <p class="mb-9">
                                {{setting('site.dashboard-paragraf')}}
                            </p>
                            <a href="{{url(setting('site.dashboard-button-link'))}}" class="btn btn-primary">{{setting('site.dashboard-button-text')}}</a>
                        </div>
                        <div class="col-sm-5">
                            <div class="position-relative mb-n7 text-end">
                                <img src="/assets/images/backgrounds/welcome-bg2.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-al-primary al-primary">
                <div class="card-body">
                    <div class="d-flex gap-4 no-block align-items-center">
                        <div>
                            <span class="text-dark al-primary display-6"><i class="ti ti-basket"></i></span>
                        </div>
                        <div class="me-auto">
                            <h2 class="fs-7">{{$count->user}}</h2>
                            <h6 class="fw-medium text-dark al-primary mb-0">Products</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-primary">
                <div class="card-body">
                    <div class="d-flex gap-4 no-block align-items-center">
                        <div>
                            <span class="text-primary display-6"><i class="ti ti-checklist"></i></span>
                        </div>
                        <div class="me-auto">
                            <h2 class="fs-7">{{$count->flyer}}</h2>
                            <h6 class="fw-medium text-primary mb-0">Orders</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-primary">
                <div class="card-body">
                    <div class="d-flex gap-4 no-block align-items-center">
                        <div>
                            <span class="text-primary display-6"><i class="ti ti-wand"></i></span>
                        </div>
                        <div class="me-auto">
                            <h2 class="fs-7">{{$count->views}}</h2>
                            <h6 class="fw-medium text-primary mb-0">Custom Orders</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card w-100 position-relative overflow-hidden">
                <div class="card-body pb-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="card-title mb-0 fw-semibold"> Penjualan Hari Ini </h5>
                        <div class="p-2 bg-primary-subtle rounded-2 d-inline-block">
                            <img src="/assets/images/svgs/icon-master-card-2.svg" alt="" class="img-fluid"
                                width="24" height="24">
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7 pb-8">
                        <h4 class="fw-semibold mb-0 fs-7 me-3">Rp. {{ $todayViewsCount }}</h4>
                        <div class="d-flex align-items-center">
                            <span
                                class="me-1 rounded-circle {{ $isGrowth ? 'bg-success-subtle' : 'bg-danger-subtle' }} round-20 d-flex align-items-center justify-content-center">
                                <i class="ti {{ $isGrowth ? 'ti-arrow-up-right text-success' : 'ti-arrow-down-right text-danger' }}"></i>
                            </span>
                            <p class="text-muted me-1 fs-3 mb-0">
                                {{ $isGrowth ? '+' : '' }}{{ round($growthPercentage, 2) }}%
                            </p>
                        </div>
                    </div>
                    <div id="today-views"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold">Latest Viewed</h5>
                    <p class="card-subtitle mb-7 pb-8">Flyer yang terakhir kali dilihat oleh pengunjung</p>
                    <div class="position-relative overflow-auto m-3 px-3" style="max-height: 25em">
                        @foreach ($latest_views as $view)
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <div
                                    class="bg-primary-subtle rounded-2 d-flex align-items-center justify-content-center me-6">
                                    <img src="{{$view->flyer->image ? '/storage/'.$view->flyer->image : ''}}" alt="{{$view->flyer->title}} Flyer" class="img-fluid rounded-2"
                                    style="width:4em" />
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-4 fw-semibold">{{$view->flyer->title}}</h6>
                                    <p class="fs-2 mb-0">{{ \Carbon\Carbon::parse($view->created_at)->format('d M Y - H:i') }}</p>
                                </div>
                            </div>
                            <h6 class="mb-0 fw-semibold"><i class="ti ti-map me-2"></i> {{$view->location}}</h6>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{route('flyer.index')}}" class="btn btn-primary w-100">Manage Flyers</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const hourlyViews = @json($hourlyData);

        const hourlyLabels = Array.from({
            length: 24
        }, (_, i) => `${i.toString().padStart(2, '0')}:00`);

        var options = {
            chart: {
                id: "today-views",
                type: "area",
                height: 70,
                sparkline: {
                    enabled: true,
                },
                fontFamily: "'Plus Jakarta Sans', sans-serif",
            },
            series: [{
                name: "Views",
                color: "var(--bs-primary)",
                data: hourlyViews, 
            }],
            stroke: {
                curve: "smooth",
                width: 2,
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 0,
                    inverseColors: false,
                    opacityFrom: 0.12,
                    opacityTo: 0,
                    stops: [20, 180],
                },
            },
            markers: {
                size: 0,
            },
            tooltip: {
                theme: "dark",
                custom: function({
                    series,
                    seriesIndex,
                    dataPointIndex
                }) {
                    return `<div style="padding: 5px; color: #fff; background: rgba(0,0,0,0.7); border-radius: 4px;">
                        Views di Jam ${hourlyLabels[dataPointIndex]} : ${series[seriesIndex][dataPointIndex]}
                    </div>`;
                },
            },
        };
        new ApexCharts(document.querySelector("#today-views"), options).render();
    </script>

@endsection
