@extends('layouts.auth')

@section('content')
<div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
                <div class="card mb-0 rounded-4">
                    <div class="card-body">
                        <a href="#" class="text-nowrap logo-img text-center d-block w-100">
                            <img src="/storage/{{setting('site.logo')}}" class="" alt="Logo App" style="height:6rem" />
                        </a>
                        {{-- <div class="position-relative text-center my-4">
                            <p class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">sign in with</p>
                            <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                        </div> --}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('email') is-invalid @enderror" id="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input primary" type="checkbox" value="" name="remember" id="remember" checked>
                                    <label class="form-check-label text-dark" for="remember">
                                        Simpan sesi login
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="text-primary fw-medium" href="{{ route('password.request') }}">Lupa Password ?</a>
                                @endif
                            </div>
                            <button class="btn btn-primary w-100 py-8 mb-2 rounded-2">Masuk</button>
                            <a href="{{route('register')}}" class="btn bg-primary-subtle w-100 py-8 mb-3 rounded-2">Daftar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
