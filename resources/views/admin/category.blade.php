<!-- MASTER -->
@extends('layouts/layout/template')
<!-- /MASTER -->

<!-- Title Spesific -->
@section('title', 'Kategori')
    <!-- /Title Spesific -->

    <!-- Page header -->
@section('title-page', 'Kategori')
    <!-- /page header -->


    <!-- Content -->
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Category -->
                    <div class="card">
                        <div class="header text-center mt-2">
                            <h3 class="title" style="font-weight: 400;"> Kategori </h3>
                            {{-- <p class=""><strong>Periode</strong> {{$year}} </p> --}}
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <div class="row d-flex justify-content-end">
                                    <div class="col-md-4 text-right">
                                        <div class="col-auto align-self-end">
                                            <button type="button" class="btn btn-primary m-1 pl-2 pr-2" data-toggle="modal"
                                                data-target="#tambahCategoryModal" style="float:right;">Tambah
                                                Kategori</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables mt-4">
                                <table class="table" id="categoryDatatables" cellspacing="0" width="100%"
                                    class="table table-striped table-no-bordered table-hover">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Ikon</th>
                                            <th>Nama Kategori</th>
                                            <th>Tanggal Buat</th>
                                            <th>Tanggal Update</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- /category -->
                </div>
                <div class="col-md-12">
                    <!-- Category Type -->
                    <div class="card">
                        <div class="header text-center mt-2">
                            <h3 class="title" style="font-weight: 400;"> Tipe Kategori </h3>
                            {{-- <p class=""><strong>Periode</strong> {{$year}} </p> --}}
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <div class="row justify-content-end">
                                    <div class="col-md-4 text-right">
                                        <div class="col-auto align-self-end">
                                            <button type="button" class="btn btn-primary m-1 pl-2 pr-2" data-toggle="modal"
                                                data-target="#tambahCategoryTypeModal" style="float:right;">Tambah Tipe
                                                Kategori</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables mt-4">
                                <table id="categoryTypeDatatables" cellspacing="0" width="100%"
                                    class="table table-striped table-no-bordered table-hover">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Tipe Kategori</th>
                                            <th>Tanggal Buat</th>
                                            <th>Tanggal Update</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- /category Type -->
                </div>
            </div>
        </div>
    </div>





@endsection
<!-- /content -->

<!-- Modal Create Category -->
<div id="tambahCategoryModal" role="" class="modal fade">
    <div class="modal-dialog modal-login" role="document">
        <form class="form" method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="card card-signup card-plain">
                    <div class="modal-header">
                        <div class="card-header card-header-primary text-center">
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="material-icons"
                                    style="color: #fafafa;font-size:1.1rem;cursor: pointer;">clear</i></button>
                            <h4 class="modal-title"> Tambah Kategori</h4>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <h5 class="font-weight-semibold"> Nama Kategori</h5>
                                <input type="text" name="category_title" class="form-control"
                                    placeholder="Masukan nama kategori ..." required>
                                <p class="text-danger">{{ $errors->first('category_title') }}</p>
                            </div>
                            <div class="form-group">
                                <h5 class="font-weight-semibold"> Tipe Kategori </h5>
                                <select class="form-control classification_" name="category_type_id" required>
                                    <option selected="true" value="">Tipe Kategori</option>
                                    @foreach ($categoryType as $a)
                                        <option value="{{ $a->category_type_id }}">
                                            {{ $a->category_type_title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <h5 class="font-weight-semibold mt-2"> Ikon Kategori </h5>
                            </div>
                            <div class="input-group">
                                <input type="file" name="category_icon" class="form-control" required>
                                <p class="text-danger">{{ $errors->first('category_icon') }}</p>
                            </div>
                            <br>
                            <h6>Data yang anda masukan akan tersimpan, maka diharap anda memasukan data dengan benar.
                                Terima kasih.</h6>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal"><i
                                class="icon-cross2 font-size-base mr-1"></i>
                            Keluar</button>
                        <button type="submit" class="btn bg-primary"><i class="icon-checkmark3 font-size-base mr-1"></i>
                            Tambah</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /modal Create Category -->

<!-- Modal Update Category -->
<div id="editCategoryModal" role="" class="modal fade">
    <div class="modal-dialog modal-login" role="document">
        <form class="form" method="POST" action="" id="formEditCategory" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="card card-signup card-plain">
                    <div class="modal-header">
                        <div class="card-header card-header-primary text-center">
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="material-icons"
                                    style="color: #fafafa;font-size:1.1rem;cursor: pointer;">clear</i></button>
                            <h4 class="modal-title"> Edit Kategori</h4>
                        </div>
                    </div>

                    <input type="hidden" class="form-control" name="category_id" id="category_id">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group category_name">
                                <h5 class="font-weight-semibold"> Nama Kategori</h5>
                                <input type="text" name="edit_category_title" class="form-control"
                                    value="{{ old('edit_category_title') }}" required>
                                <p class="text-danger">{{ $errors->first('edit_category_title') }}</p>
                            </div>
                            <div class="form-group category_type">
                                <h5 class="font-weight-semibold"> Tipe Kategori </h5>
                                <select class="form-control" name="edit_category_type_id" id="categoryType" required>
                                    <option selected="true" value="">Tipe Kategori</option>
                                    @foreach ($categoryType as $a)
                                        <option value="{{ $a->category_type_id }}">
                                            {{ $a->category_type_title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <input type="hidden" class="form-control" name="category_icon_image" id="categoryIconImage"
                                value="{{ old('category_icon_image') }}">
                            <div class="form-group category_icon">
                                <h5 class="font-weight-semibold mt-2"> Ikon Kategori </h5>
                                <img src="" alt="" width="100px" height="100px" id="category_icon_image">
                            </div>
                            <div class="input-group category_icon">
                                <input type="file" name="edit_category_icon" class="form-control">
                            </div>
                            <p class="text-danger">{{ $errors->first('edit_category_icon') }}</p>
                            <br>
                            <h6>Data yang anda masukan akan tersimpan, maka diharap anda memasukan data dengan benar.
                                Terima kasih.</h6>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal"><i
                                class="icon-cross2 font-size-base mr-1"></i>
                            Keluar</button>
                        <button type="submit" class="btn bg-primary"><i class="icon-checkmark3 font-size-base mr-1"></i>
                            Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /modal Update Category -->

<!-- Modal Create Category  Type -->
<div id="tambahCategoryTypeModal" role="" class="modal fade">
    <div class="modal-dialog modal-login" role="document">
        <form class="form" method="POST" action="{{ route('category_type.store') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="card card-signup card-plain">
                    <div class="modal-header">
                        <div class="card-header card-header-primary text-center">
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="material-icons"
                                    style="color: #fafafa;font-size:1.1rem;cursor: pointer;">clear</i></button>
                            <h4 class="modal-title"> Tambah Tipe Kategori</h4>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <h5 class="font-weight-semibold"> Nama Kategori</h5>
                                <input type="text" name="category_type_title" class="form-control"
                                    placeholder="Masukan nama kategori ..." required>
                                <p class="text-danger">{{ $errors->first('category_type_title') }}</p>
                            </div>
                            <h6>Data yang anda masukan akan tersimpan, maka diharap anda memasukan data dengan benar.
                                Terima kasih.</h6>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal"><i
                                class="icon-cross2 font-size-base mr-1"></i>
                            Keluar</button>
                        <button type="submit" class="btn bg-primary"><i class="icon-checkmark3 font-size-base mr-1"></i>
                            Tambah</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /modal Create Category Type -->

<!-- Modal Update Category Type -->
<div id="editCategoryTypeModal" role="" class="modal fade">
    <div class="modal-dialog modal-login" role="document">
        <form class="form" method="POST" action="" id="formEditCategoryType" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="card card-signup card-plain">
                    <div class="modal-header">
                        <div class="card-header card-header-primary text-center">
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="material-icons"
                                    style="color: #fafafa;font-size:1.1rem;cursor: pointer;">clear</i></button>
                            <h4 class="modal-title"> Edit Tipe Kategori</h4>
                        </div>
                    </div>

                    <input type="hidden" class="form-control" name="category_type" id="category_type_id">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group category_type_name">
                                <h5 class="font-weight-semibold"> Nama Kategori</h5>
                                <input type="text" name="edit_category_type_title" class="form-control"
                                    value="{{ old('edit_category_type_title') }}" required>
                                {{-- @error('edit_category_type_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}

                                <p class="text-danger">{{ $errors->first('edit_category_type_title') }}</p>
                            </div>
                            <h6>Data yang anda masukan akan tersimpan, maka diharap anda memasukan data dengan benar.
                                Terima kasih.</h6>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal"><i
                                class="icon-cross2 font-size-base mr-1"></i>
                            Keluar</button>
                        <button type="submit" class="btn bg-primary"><i class="icon-checkmark3 font-size-base mr-1"></i>
                            Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /modal Update Category Type -->

@push('js')

    <script>
        $(document).on('click', '#editButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#editModal').modal("show");
                    $('#editBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $(document).on('click', '.remove', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');


            var url = "{{ route('category_type.index') }}/" + id;
            Swal.fire({
                title: 'Anda yakin menghapus tipe kategori?',
                text: 'Anda tidak dapat mengembalikan data yang telah dihapus!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal!',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'JSON',
                        success: (response) => {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: 'Dihapus!',
                                    text: 'Tipe kategori telah dihapus',
                                    icon: 'success',
                                    timer: 1000
                                })
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Tipe kategori memiliki data kategori!',
                                    icon: 'warning',
                                    timer: 1000
                                })
                            }
                            console.log(response.status);
                            $(this).closest('tr').remove();
                            location.reload();
                        }
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Batal',
                        'Data batal dihapus :)',
                        'error'
                    )
                }
            })
        });

        $(document).on('click', '.remove-category', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');


            var url = "{{ route('category.index') }}/" + id;
            Swal.fire({
                title: 'Anda yakin menghapus kategori?',
                text: 'Anda tidak dapat mengembalikan data yang telah dihapus!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal!',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'JSON',
                        success: (response) => {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: 'Dihapus!',
                                    text: 'Kategori telah dihapus',
                                    icon: 'success',
                                    timer: 10000
                                })
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Kategori memiliki data tempat!',
                                    icon: 'warning',
                                    timer: 10000
                                })
                            }
                            console.log(response.status);
                            $(this).closest('tr').remove();
                            location.reload();
                        }
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Batal',
                        'Data batal dihapus :)',
                        'error'
                    )
                }
            })
        });
    </script>

    <script>
        $(document).ready(function() {
            @if ($errors->has('category_type_title'))
                $('#tambahCategoryTypeModal').modal('show');
            @endif
            @if ($errors->has('edit_category_type_title'))
                $('#editCategoryTypeModal').modal('show');
                var name = "{{ old('edit_category_type_title') }}";
                var id = "{{ old('category_type') }}";
                var action = "{{ route('category_type.index') }}/" + id;
                $('#formEditCategoryType').attr('action', action);
            @endif
            @if ($errors->has('edit_category_title'))
                $('#editCategoryModal').modal('show');
                var name = "{{ old('edit_category_title') }}";
                var parent = "{{ old('edit_category_type_id') }}";
                var image = "{{ old('category_icon_image') }}";
            
                console.log(image);
            
                $('#categoryType').val(parent);
            
                $('#category_icon_image').attr('src',image);
            
                var id = "{{ old('category_id') }}";
                var action = "{{ route('category.index') }}/" + id;
                $('#formEditCategory').attr('action', action);
            @endif
            @if ($errors->has('edit_category_icon'))
                $('#editCategoryModal').modal('show');
                var name = "{{ old('edit_category_title') }}";
                var parent = "{{ old('edit_category_type_id') }}";
                var image = "{{ old('category_icon_image') }}";
            
                console.log(image);
            
                $('#categoryType').val(parent);
            
                $('#category_icon_image').attr('src',image);
            
                var id = "{{ old('category_id') }}";
                var action = "{{ route('category.index') }}/" + id;
                $('#formEditCategory').attr('action', action);
            @endif

            @if (Session::has('deleted_category_type_error'))
                // swal.fire(
                // 'Gagal!',
                // 'Tipe kategori masih memiliki kategori!',
                // 'warning',
                // )
                // @endif

            $(document).on('click', '.btnEditCategoryType', function() {
                @if ($errors->has('edit_category_type_title'))
                    $('p.text-danger').remove();
                @endif
                var id = $(this).attr('value');
                $('#category_type_id').val(id);

                $.ajax({
                    type: 'GET',
                    url: '{!! url('detailCategoryType') !!}',
                    data: {
                        'id': id
                    },
                    dataType: 'html',
                    success: function(data) {
                        var servers = $.parseJSON(data);
                        $.each(servers, function(index, value) {
                            var category_type_title = value.category_type_title;

                            $("div.category_type_name input").val(category_type_title);
                        });
                    }
                });

                var action = "{{ route('category_type.index') }}/" + id;
                $('#formEditCategoryType').attr('action', action);
            });

            $(document).on('click', '.btnEditCategory', function() {
                @if ($errors->has('edit_category_title'))
                    $('p.text-danger').remove();
                @endif
                @if ($errors->has('edit_category_icon'))
                    $('p.text-danger').remove();
                @endif


                var id = $(this).attr('value');
                $('#category_id').val(id);

                $.ajax({
                    type: 'GET',
                    url: '{!! url('detailCategory') !!}',
                    data: {
                        'id': id
                    },
                    dataType: 'html',
                    success: function(data) {
                        var servers = $.parseJSON(data);
                        $.each(servers, function(index, value) {
                            var category_type_id = value.category_type_id;
                            var category_title = value.category_title;
                            var category_icon = "/categories/" + value.category_icon;

                            $('#category_icon_image').attr('src', category_icon);

                            $('#categoryIconImage').val(category_icon);
                            // $('div.category_icon input').val(nameCode);
                            $("div.category_type select").val(category_type_id);
                            $("div.category_name input").val(category_title);
                        });
                    }
                });


                var action = "{{ route('category.index') }}/" + id;
                $('#formEditCategory').attr('action', action);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#categoryTypeDatatables').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                "ordering": false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari",
                },
                ajax: "{{ route('ajax.get.data.category.type.index') }}",
                columns: [{
                        data: 'category_type_title',
                        name: 'category_type_title'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'view',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });

        $(document).ready(function() {
            $('#categoryDatatables').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                "ordering": false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari",
                },
                ajax: "{{ route('ajax.get.data.category.index') }}",
                columns: [{
                        data: 'icon',
                        name: 'icon'
                    },
                    {
                        data: 'category_title',
                        name: 'category_title'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'view',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>

    @include('sweetalert::alert')
@endpush
