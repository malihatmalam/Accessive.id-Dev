!-- MASTER -->
@extends('layouts/layout/template')
<!-- /MASTER -->

<!-- Title Spesific -->
@section('title', 'Tambah Kategori')
    <!-- /Title Spesific -->

    <!-- Page header -->
@section('title-page', 'Kategori / Tambah Kategori')
    <!-- /page header -->


    <!-- Content -->
@section('content')
    <<div class="card mt-0">
        <div class="header text-left m-3">
            <h3 class="title" style="font-weight: 400;">Tambah Kategori</h3>
        </div>
        <form action="{{ route('category.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="card card-journal ml-4 mt-0 mb-4">
                <div class="row m-3 justify-content-between">
                    <div class="col-lg-6 col-md-6 p-0">
                        <div class="col-lg-12 col-md-12 pl-0">
                            <p class="font-weight-bold mb-0">No kwitansi</p>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">receipt</i>
                                    </span>
                                </div>
                                <input type="text" class="form-control border-select" name="receipt" required="true"
                                    aria-required="true" value="{{ old('receipt') }}">
                            </div>
                        </div>
                        <div class="input-group">
                         <h5 class="font-weight-semibold mt-2"> Ikon Kategori </h5>
                         <input type="file" name="category_icon" class="form-control" required>
                         <p class="text-danger">{{ $errors->first('category_icon') }}</p>
                     </div>
                        <div class="col-lg-12 col-md-12 pl-0">
                            <p class="font-weight-bold mb-0">Deskripsi</p>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                </div>
                                <input type="date" class="form-control border-select date" name="date" required="true"
                                    aria-required="true" value="{{ old('date') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="col-lg-12 col-md-12 pl-0">
                            <p class="font-weight-bold mb-0">Keterangan</p>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">description</i>
                                    </span>
                                </div>
                                <textarea class="description" rows="3" style="width:80%" name="description" required="true"
                                    aria-required="true">{{ old('description') }}</textarea>
                            </div>
                            @error('description[$key]')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row m-3">
                    <table class='table table-hover'>
                        <thead class='table-header'>
                            <tr>
                                <th>
                                    Akun
                                </th>
                                <th>
                                    Debit
                                </th>
                                <th>
                                    Kredit
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width:40%">
                                    <select class="form-control border-select credit" name="account[]" required>
                                        <option selected="true" value="">Pilih Akun</option>
                                        {{-- @foreach ($account as $a)
                                            <option value="{{ $a->id }}"
                                                {{ $a->id == old('account.0') ? 'selected' : null }}>
                                                {{ $a->account_code }} - {{ $a->account_name }}</option>
                                        @endforeach --}}
                                    </select>
                                </td>
                                <td style="width: 28%">
                                    <input type="text" id="currency" class="form-control border-select amount"
                                        name="amount_debit[]" data-type="currency" value="{{ old('amount_debit.0') }}"
                                        id="inputNominal">
                                </td>
                                <td style="width: 28%">
                                    <input type="text" id="currency" class="form-control border-select amount"
                                        name="amount_credits[]" data-type="currency"
                                        value="{{ old('amount_credits.0') }}" id="inputNominal">
                                </td>
                                <td>
                                    <button type="button" class="close remove" data-dismiss="modal" aria-hidden="true">
                                        <i class="material-icons"
                                            style="color:#f44336;font-size:1.5rem;cursor: pointer;">close</i></button>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:40%">
                                    <select class="form-control border-select credit" name="account[]" required>
                                        <option selected="true" value="">Pilih Akun</option>
                                        {{-- @foreach ($account as $a)
                                            <option value="{{ $a->id }}"
                                                {{ $a->id == old('account.1') ? 'selected' : null }}>
                                                {{ $a->account_code }} - {{ $a->account_name }}</option>
                                        @endforeach --}}
                                    </select>
                                </td>
                                <td style="width: 28%">
                                    <input type="text" id="currency" class="form-control border-select amount"
                                        name="amount_debit[]" data-type="currency" value="{{ old('amount_debit.1') }}"
                                        id="inputNominal">
                                </td>
                                <td style="width: 28%">
                                    <input type="text" id="currency" class="form-control border-select amount"
                                        name="amount_credits[]" data-type="currency"
                                        value="{{ old('amount_credits.1') }}" id="inputNominal">
                                </td>
                                <td>
                                    <button type="button" class="close remove" data-dismiss="modal" aria-hidden="true">
                                        <i class="material-icons"
                                            style="color:#f44336;font-size:1.5rem;cursor: pointer;">close</i></button>
                                </td>
                            </tr>
                            @foreach (old('account', []) as $parakey => $paravalue)
                                @if ($parakey > 1)
                                    <tr>
                                        <td style="width:40%">
                                            <select class="form-control border-select credit" name="account[]" required>
                                                <option selected="true" value="">Pilih Akun</option>
                                                {{-- @foreach ($account as $a)
                                                    <option value="{{ $a->id }}"
                                                        {{ $a->id == $paravalue ? 'selected' : null }}>
                                                        {{ $a->account_code }} - {{ $a->account_name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </td>
                                        <td style="width: 28%">
                                            <input type="text" id="currency" class="form-control border-select amount"
                                                name="amount_debit[]" data-type="currency"
                                                value="{{ old('amount_debit')[$parakey] }}" id="inputNominal">
                                        </td>
                                        <td style="width: 28%">
                                            <input type="text" id="currency" class="form-control border-select amount"
                                                name="amount_credits[]" data-type="currency"
                                                value="{{ old('amount_credits')[$parakey] }}" id="inputNominal">
                                        </td>
                                        <td>
                                            <button type="button" class="close remove" data-dismiss="modal"
                                                aria-hidden="true">
                                                <i class="material-icons"
                                                    style="color:#f44336;font-size:1.5rem;cursor: pointer;">close</i></button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary m-1 pl-2 pr-2" style="float:left;" id="addRow">Tambah
                            Akun</button>
                    </div>
                </div>
            </div>
            <div class="row m-3 justify-content-center">
                <button id="save" class="btn btn-primary col-2 m-1 pl-2 pr-2" style="float:right;">SIMPAN</button>
            </div>
            </div>

        @endsection
        @push('js')
        <!-- /content -->
