<!-- MASTER -->
@extends('layouts/layout/template')
<!-- /MASTER -->

<!-- Title Spesific -->
@section('title', 'Managemen Pengguna')
    <!-- /Title Spesific -->

    <!-- Page header -->
@section('title-page', 'Managemen Pengguna')
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
                            <h3 class="title" style="font-weight: 400;"> Managemen Pengguna </h3>
                            {{-- <p class=""><strong>Periode</strong> {{$year}} </p> --}}
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <div class="row d-flex justify-content-end">
                                    <div class="col-md-4 text-right">
                                        <div class="col-auto align-self-end">
                                            <button type="button" class="btn btn-primary m-1 pl-2 pr-2" data-toggle="modal"
                                                data-target="#tambahUserModal" style="float:right;">Tambah
                                                Pengguna</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables mt-4">
                                <table class="table" id="userDatatables" cellspacing="0" width="100%"
                                    class="table table-striped table-no-bordered table-hover">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Gambar Profil</th>
                                            <th>Id Akun</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Jenis</th>
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
            </div>
        </div>
    </div>





@endsection
<!-- /content -->

<!-- Modal Create User -->
<div id="tambahUserModal" role="" class="modal fade">
    <div class="modal-dialog modal-login modal-lg" role="document">
        <form class="form" method="POST" action="{{ route('user_management.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="card card-signup card-plain">
                    <div class="modal-header">
                        <div class="card-header card-header-primary text-center">
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="material-icons"
                                    style="color: #fafafa;font-size:1.1rem;cursor: pointer;">clear</i></button>
                            <h4 class="modal-title"> Tambah Pengguna Baru </h4>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <!-- Username -->
                                    <div class="form-group">
                                        <h5 class="font-weight-semibold"> Username </h5>
                                        <input type="text" name="user_name" class="form-control"
                                            placeholder="Masukan username ..." required>
                                        <p class="text-danger">{{ $errors->first('user_name') }}</p>
                                        <h6>*Bersifat Unik (Tidak boleh sama dengan yang lain).</h6>
                                    </div>
                                    <!-- Username -->
                                </div>
                                <div class="col-6">
                                    <!-- Email -->
                                    <div class="form-group">
                                        <h5 class="font-weight-semibold"> Email </h5>
                                        <input type="text" name="email" class="form-control"
                                            placeholder="Masukan email ..." required>
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                        <h6>*Bersifat Unik (Tidak boleh sama dengan yang lain).</h6>
                                    </div>
                                    <!-- Email -->
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-8">
                                    <!-- Fullname -->
                                    <div class="form-group">
                                        <h5 class="font-weight-semibold"> Nama Lengkap </h5>
                                        <input type="text" name="full_name" class="form-control"
                                            placeholder="Masukan nama lengkap ..." required>
                                        <p class="text-danger">{{ $errors->first('full_name') }}</p>
                                        {{-- <h6>*Bersifat Unik (Tidak boleh sama dengan yang lain).</h6> --}}
                                    </div>
                                    <!-- Fullname -->
                                </div>
                                <div class="col-4">
                                    <!-- Phone -->
                                    <div class="form-group">
                                        <h5 class="font-weight-semibold"> Nomor Telepon </h5>
                                        <input type="text" name="phone" class="form-control" placeholder="+62 ..."
                                            required>
                                        <p class="text-danger">{{ $errors->first('phone') }}</p>
                                        {{-- <div class="row">
                                        </div> --}}
                                        {{-- <h6>*+62 .</h6> --}}
                                    </div>
                                    <!-- Phone -->
                                </div>
                                <div class="col-12">
                                    <!-- Address -->
                                    <div class="form-group">
                                        <h5 class="font-weight-semibold"> Alamat </h5>
                                        <textarea type="text" name="address" class="form-control"
                                            placeholder="Masukan alamat ... " required></textarea>
                                        <p class="text-danger">{{ $errors->first('address') }}</p>
                                        {{-- <h6>*+62 .</h6> --}}
                                    </div>
                                    <!-- Address -->
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <h5 class="font-weight-semibold mt-2"> Foto Profile Pengguna </h5>
                                    </div>
                                    <div class="input-group">
                                        <input type="file" name="profile_photo_url" class="form-control">
                                        <p class="text-danger">{{ $errors->first('profile_photo_url') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <h6>Data yang anda masukan akan tersimpan, maka diharap anda memasukan data dengan benar.
                            Terima kasih.</h6>
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
<!-- /modal Create User -->

<!-- Modal Update User -->
<div id="editUserModal" role="" class="modal fade">
    <div class="modal-dialog modal-login modal-lg" role="document">
        <form class="form" method="POST" action="" id="formEditUser" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="card card-signup card-plain">
                    <div class="modal-header">
                        <div class="card-header card-header-primary text-center">
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="material-icons"
                                    style="color: #fafafa;font-size:1.1rem;cursor: pointer;">clear</i></button>
                            <h4 class="modal-title"> Edit Pengguna </h4>
                        </div>
                    </div>

                    <input type="hidden" class="form-control" name="user_id" id="user_id"
                        value="{{ old('user_id') }}">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <!-- Username -->
                                    <div class="form-group edit_form_user_name">
                                        <h5 class="font-weight-semibold"> Username </h5>
                                        <input id="edit_form_user_name" type="text" name="edit_user_name"
                                            class="form-control" value="{{ old('edit_user_name') }}"
                                            placeholder="Masukan username ..." required disabled>
                                        <p class="text-danger">{{ $errors->first('edit_user_name') }}</p>
                                        <h6>*Bersifat Unik (Tidak boleh sama dengan yang lain).</h6>
                                    </div>
                                    <!-- Username -->
                                </div>
                                <div class="col-6">
                                    <!-- Email -->
                                    <div class="form-group edit_form_email">
                                        <h5 class="font-weight-semibold"> Email </h5>
                                        <input id="edit_form_email" type="text" name="edit_email" class="form-control"
                                            value="{{ old('edit_email') }}" placeholder="Masukan email ..." required
                                            disabled>
                                        <p class="text-danger">{{ $errors->first('edit_email') }}</p>
                                        <h6>*Bersifat Unik (Tidak boleh sama dengan yang lain).</h6>
                                    </div>
                                    <!-- Email -->
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-8">
                                    <!-- Fullname -->
                                    <div class="form-group edit_form_full_name">
                                        <h5 class="font-weight-semibold"> Nama Lengkap </h5>
                                        <input type="text" id="edit_form_full_name" name="edit_full_name"
                                            class="form-control" value="{{ old('edit_full_name') }}"
                                            placeholder="Masukan nama lengkap ..." required>
                                        <p class="text-danger">{{ $errors->first('edit_full_name') }}</p>
                                        {{-- <h6>*Bersifat Unik (Tidak boleh sama dengan yang lain).</h6> --}}
                                    </div>
                                    <!-- Fullname -->
                                </div>
                                <div class="col-4">
                                    <!-- Phone -->
                                    <div class="form-group edit_form_phone">
                                        <h5 class="font-weight-semibold"> Nomor Telepon </h5>
                                        <input id="edit_form_phone" type="text" name="edit_phone" class="form-control"
                                            value="{{ old('edit_phone') }}" placeholder="+62 ..." required>
                                        <p class="text-danger">{{ $errors->first('edit_phone') }}</p>
                                        {{-- <div class="row">
                                        </div> --}}
                                        {{-- <h6>*+62 .</h6> --}}
                                    </div>
                                    <!-- Phone -->
                                </div>
                                <div class="col-12">
                                    <!-- Address -->
                                    <div class="form-group edit_form_address">
                                        <h5 class="font-weight-semibold"> Alamat </h5>
                                        <textarea id="edit_form_address" type="text" name="edit_address"
                                            class="form-control" value="{{ old('edit_address') }}"
                                            placeholder="Masukan alamat ... " required></textarea>
                                        <p class="text-danger">{{ $errors->first('edit_address') }}</p>
                                        {{-- <h6>*+62 .</h6> --}}
                                    </div>
                                    <!-- Address -->
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <h5 class="font-weight-semibold mt-2"> Foto Profile Pengguna </h5>
                                    </div>
                                    <input type="hidden" class="form-control" name="profile_photo_url_image"
                                        id="profilePhotoUrlImage" value="{{ old('profile_photo_url_image') }}">

                                    <div class="form-group profile_photo_url">
                                        {{-- <h5 class="font-weight-semibold mt-2"> Ikon Kategori </h5> --}}
                                        <img src="" alt="" width="100px" height="100px" id="profile_photo_url_image">
                                    </div>
                                    <div class="input-group">
                                        <input type="file" name="edit_profile_photo_url" class="form-control">
                                        <p class="text-danger">{{ $errors->first('edit_profile_photo_url') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <h6>Data yang anda masukan akan tersimpan, maka diharap anda memasukan data dengan benar.
                            Terima kasih.</h6>
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
<!-- /modal Update User -->


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


            var url = "{{ route('user_management.index') }}/" + id;
            Swal.fire({
                title: 'Anda yakin menghapus pengguna?',
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
                                    text: 'Pengguna telah dihapus',
                                    icon: 'success',
                                    timer: 1000
                                })
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Pengguna tidak bisa dihapus!',
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
    </script>

    <script>
        $(document).ready(function() {
            // Untuk error tambah
            @if ($errors->has('email'))
                $('#tambahUserModal').modal('show');
            @endif
            @if ($errors->has('user_name'))
                $('#tambahUserModal').modal('show');
            @endif
            @if ($errors->has('full_name'))
                $('#tambahUserModal').modal('show');
            @endif
            @if ($errors->has('phone'))
                $('#tambahUserModal').modal('show');
            @endif
            @if ($errors->has('address'))
                $('#tambahUserModal').modal('show');
            @endif
            @if ($errors->has('email'))
                $('#tambahUserModal').modal('show');
            @endif


            @if ($errors->has('edit_user_name'))
                $('#editUserModal').modal('show');
                // $('#editUserModal').modal('show');
            
                var image = "{{ old('profile_photo_url_image') }}";
                var default_photo_profile = "/pic/user.svg";
            
                if (image) {
                $('#profile_photo_url_image').attr('src',image);
                }
                if (photo_profile == "/user_datas/"+null) {
                $('#profile_photo_url_image').attr('src',
                default_photo_profile);
                }
            
            
                $('#edit_form_user_name').val("{{ old('edit_user_name') }}");
                $('#edit_form_email').val("{{ old('edit_email') }}");
                $('#edit_form_full_name').val("{{ old('edit_full_name') }}");
                $('#edit_form_phone').val("{{ old('edit_phone') }}");
                $('#edit_form_address').val("{{ old('edit_address') }}");
            
                // var name = "{{ old('edit_category_type_title') }}";
                var id = "{{ old('user_id') }}";
                var action = "{{ route('user_management.index') }}/" + id;
                $('#formEditUser').attr('action', action);
            @endif
            @if ($errors->has('edit_full_name'))
                $('#editUserModal').modal('show');
                // $('#editUserModal').modal('show');
            
                var image = "{{ old('profile_photo_url_image') }}";
                var default_photo_profile = "/pic/user.svg";
            
                if (image) {
                $('#profile_photo_url_image').attr('src',image);
                }
                if (photo_profile == "/user_datas/"+null) {
                $('#profile_photo_url_image').attr('src',
                default_photo_profile);
                }
            
                $('#edit_form_user_name').val("{{ old('edit_user_name') }}");
                $('#edit_form_email').val("{{ old('edit_email') }}");
                $('#edit_form_full_name').val("{{ old('edit_full_name') }}");
                $('#edit_form_phone').val("{{ old('edit_phone') }}");
                $('#edit_form_address').val("{{ old('edit_address') }}");
            
                // var name = "{{ old('edit_category_type_title') }}";
                var id = "{{ old('user_id') }}";
                var action = "{{ route('user_management.index') }}/" + id;
                $('#formEditUser').attr('action', action);
            @endif
            @if ($errors->has('edit_phone'))
                $('#editUserModal').modal('show');
                // $('#editUserModal').modal('show');
            
                var image = "{{ old('profile_photo_url_image') }}";
                var default_photo_profile = "/pic/user.svg";
            
                if (image) {
                $('#profile_photo_url_image').attr('src',image);
                }
                if (photo_profile == "/user_datas/"+null) {
                $('#profile_photo_url_image').attr('src',
                default_photo_profile);
                }
            
                $('#edit_form_user_name').val("{{ old('edit_user_name') }}");
                $('#edit_form_email').val("{{ old('edit_email') }}");
                $('#edit_form_full_name').val("{{ old('edit_full_name') }}");
                $('#edit_form_phone').val("{{ old('edit_phone') }}");
                $('#edit_form_address').val("{{ old('edit_address') }}");
            
                // var name = "{{ old('edit_category_type_title') }}";
                var id = "{{ old('user_id') }}";
                var action = "{{ route('user_management.index') }}/" + id;
                $('#formEditUser').attr('action', action);
            @endif
            @if ($errors->has('edit_address'))
                $('#editUserModal').modal('show');
                // $('#editUserModal').modal('show');
            
                var image = "{{ old('profile_photo_url_image') }}";
                var default_photo_profile = "/pic/user.svg";
            
                if (image) {
                $('#profile_photo_url_image').attr('src',image);
                }
                if (photo_profile == "/user_datas/"+null) {
                $('#profile_photo_url_image').attr('src',
                default_photo_profile);
                }
            
                $('#edit_form_user_name').val("{{ old('edit_user_name') }}");
                $('#edit_form_email').val("{{ old('edit_email') }}");
                $('#edit_form_full_name').val("{{ old('edit_full_name') }}");
                $('#edit_form_phone').val("{{ old('edit_phone') }}");
                $('#edit_form_address').val("{{ old('edit_address') }}");
            
                // var name = "{{ old('edit_category_type_title') }}";
                var id = "{{ old('user_id') }}";
                var action = "{{ route('user_management.index') }}/" + id;
                $('#formEditUser').attr('action', action);
            @endif


            $(document).on('click', '.btnEditUser', function() {
                @if ($errors->has('edit_email'))
                    $('p.text-danger').remove();
                @endif
                @if ($errors->has('edit_user_name'))
                    $('p.text-danger').remove();
                @endif
                @if ($errors->has('edit_full_name'))
                    $('p.text-danger').remove();
                @endif
                @if ($errors->has('edit_phone'))
                    $('p.text-danger').remove();
                @endif
                @if ($errors->has('edit_address'))
                    $('p.text-danger').remove();
                @endif

                var id = $(this).attr('value');
                $('#user_id').val(id);

                $.ajax({
                    type: 'GET',
                    url: '{!! url('detailUserManagement') !!}',
                    data: {
                        'id': id
                    },
                    dataType: 'html',
                    success: function(data) {
                        var servers = $.parseJSON(data);
                        $.each(servers, function(index, value) {
                            // var category_type_title = value.category_type_title;
                            var photo_profile = "/user_datas/" + value.user_data
                                .profile_photo_url;
                            var default_photo_profile = "/pic/user.svg";

                            if (photo_profile) {
                                $('#profile_photo_url_image').attr('src',
                                    photo_profile);
                            }
                            if (photo_profile == "/user_datas/" + null) {
                                $('#profile_photo_url_image').attr('src',
                                    default_photo_profile);
                            }

                            console.log(photo_profile);


                            $('#profilePhotoUrlImage').val(photo_profile);

                            $('#edit_form_user_name').val(value.user_name);
                            $('#edit_form_email').val(value.email);
                            $('#edit_form_full_name').val(value.user_data.full_name);
                            $('#edit_form_phone').val(value.user_data.phone);
                            $('#edit_form_address').val(value.user_data.address);
                        });
                    }
                });

                var action = "{{ route('user_management.index') }}/" + id;
                $('#formEditUser').attr('action', action);
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
            $('#userDatatables').DataTable({
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
                ajax: "{{ route('ajax.get.data.user.management.index') }}",
                columns: [{
                        data: 'avatar',
                        name: 'avatar'
                    },
                    {
                        data: 'account_id',
                        name: 'account_id'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },

                    {
                        data: 'role',
                        name: 'role'
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
