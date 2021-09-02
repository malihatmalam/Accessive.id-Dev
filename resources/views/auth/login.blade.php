@extends('auth.master')

@section('title')
    Login
@endsection

@section('body')

    <body>

        <!-- Page content -->
        <div class="page-content login-cover">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login form -->
                    <form class="login-form wmin-sm-400" action="{{ route('login') }}" method="POST">

                        @csrf
                        <div class="card mb-0">

                            <div class="tab-content card-body">
                                <div class="tab-pane fade show active" id="login-tab1">
                                    <div class="text-center mb-3">
                                        <i
                                            class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                                        <h4 class="mb-0">Masuk ke akun anda</h4>
                                        {{-- <span class="d-block text-muted">Your credentials</span> --}}
                                    </div>

                                    <!-- Username / email form -->
                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <input id="email" type="email" placeholder="Email " class="form-control
                                            @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                                            required autocomplete="email" autofocus>
                                        <div class="form-control-feedback">
                                            <i class="icon-user text-muted"></i>
                                        </div>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Email atau password salah</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- /Username / email form -->

                                    <!-- Password form -->
                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <input id="password" placeholder="Kata sandi " type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">
                                        <div class="form-control-feedback">
                                            <i class="icon-lock2 text-muted"></i>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                    <!-- /Password form -->

                                    <div class="form-group d-flex align-items-center">
                                        @if (Route::has('password.request'))
                                            <a class="ml-auto" href="{{ route('password.request') }}">
                                                Lupa Kata Sandi ?
                                            </a>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                                    </div>

                                    {{-- <div class="row">
                                <div class="col-12 text-center">
                                    <a href="{{ route('register') }}"
                                        class="text-center btn btn-make-user">Belum Punya Akun? <strong>Daftar!</strong></a>
                                    </div>
                                </div> --}}
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /login form -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </body>
@endsection
