@extends('auth.master')

@section('title')
    Regristration
@endsection

@section('body')

    <!-- Page content -->
    <div class="page-content login-cover">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content d-flex justify-content-center align-items-center">

                <!-- Registration form -->

                <form method="POST" action="{{ route('register') }}" class="flex-fill">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <i
                                            class="icon-plus3 icon-2x text-success border-success border-3 rounded-round p-3 mb-3 mt-1"></i>
                                        <h5 class="mb-0">Membuat akun Accessive.id</h5>
                                        <span class="d-block text-muted">Pastikan anda mengisi data dengan benar</span>
                                    </div>

                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <input id="full_name" type="text"
                                            class="form-control @error('full_name') is-invalid @enderror" name="full_name"
                                            value="{{ old('full_name') }}" required autocomplete="full_name"
                                            placeholder="Nama lengkap " autofocus>
                                        <div class="form-control-feedback">
                                            <i class="icon-user-plus text-muted"></i>
                                        </div>
                                        @error('full_name')
                                            <span class="form-text text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <input id="user_name" type="text"
                                            class="form-control @error('user_name') is-invalid @enderror"
                                            name="user_name" value="{{ old('user_name') }}" required
                                            autocomplete="user_name" placeholder="Username anda " autofocus>
                                        <div class="form-control-feedback">
                                            <i class="icon-user-check text-muted"></i>
                                        </div>
                                        @error('user_name')
                                            <span class="form-text text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Email anda">
                                        <div class="form-control-feedback">
                                            <i class="icon-mention text-muted"></i>
                                        </div>
                                        @error('email')
                                            <span class="form-text text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password" placeholder="Kata sandi " autofocus>
                                        <div class="form-control-feedback">
                                            <i class="icon-user-lock text-muted"></i>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="form-text text-danger" role="alert">
                                                <strong>{{ $errors->first('password') }}<strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <input id="password-confirm" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="Konfirmasi kata sandi " autofocus>
                                        <div class="form-control-feedback">
                                            <i class="icon-user-lock text-muted"></i>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="form-text text-danger" role="alert">
                                                <strong>{{ $errors->first('password') }}<strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <input id="phone" type="text"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" value="{{ old('phone') }}" required
                                            autocomplete="phone" placeholder="Nomor telepon " autofocus>
                                        <div class="form-control-feedback">
                                            <i class="icon-phone text-muted"></i>
                                        </div>
                                        @error('phone')
                                            <span class="form-text text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                            name="address" value="{{ old('address') }}" required autocomplete="address"
                                            placeholder="Alamat " autofocus></textarea>
                                        <div class="form-control-feedback">
                                            <i class="icon-home text-muted"></i>
                                        </div>
                                        @error('address')
                                            <span class="form-text text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-right"><b><i
                                                class="icon-plus3"></i></b> Buat akun </button>

                                    <div class="row">
                                        <div class="col-12 text-center">
                                            Sudah Punya
                                                Akun?
                                            <a href="{{ route('login') }}" class="text-center">
                                                <strong>Masuk!</strong></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /registration form -->

            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
@endsection
