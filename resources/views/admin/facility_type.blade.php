<!-- MASTER -->
@extends('layouts/layout/template')
<!-- /MASTER -->

<!-- Title Spesific -->
@section('title', 'Tipe Fasilitas')
<!-- /Title Spesific -->

<!-- Page header -->
@section('title-page', 'Tipe Fasilitas')
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
                    <h3 class="title" style="font-weight: 400;"> Tipe Fasilitas </h3>
                    {{-- <p class=""><strong>Periode</strong> {{$year}} </p> --}}
                </div>
                <div class="card-body">
                    <div class="toolbar">
                        <div class="row d-flex justify-content-end">
                            <div class="col-md-4 text-right">
                                <div class="col-auto align-self-end">
                                    <button type="button" class="btn btn-primary m-1 pl-2 pr-2" data-toggle="modal"
                                        data-target="#tambahfacilityModal" style="float:right;">Tambah
                                        Tipe Fasilitas</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="material-datatables mt-4">
                        <table class="table" id="facilityDatatables" cellspacing="0" width="100%"
                            class="table table-striped table-no-bordered table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>Id</th>
                                    <th>Tipe Fasilitas</th>
                                    <th>Deskripsi</th>
                                    <th>Gambar</th>
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

<!-- Modal Create Tipe Fasilitas -->
<div id="tambahfacilityModal" role="" class="modal fade">
<div class="modal-dialog modal-login modal-lg" role="document">
<form class="form" method="POST" action="{{ route('facility_type.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal-content">
        <div class="card card-signup card-plain">
            <div class="modal-header">
                <div class="card-header card-header-primary text-center">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="material-icons"
                            style="color: #fafafa;font-size:1.1rem;cursor: pointer;">clear</i></button>
                    <h4 class="modal-title"> Tambah Tipe Fasilitas Baru </h4>
                </div>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <!-- Tipe Fasilitas Title -->
                            <div class="form-group">
                                <h5 class="font-weight-semibold"> Nama Tipe Fasilitas </h5>
                                <input type="text" name="facility_type_title" class="form-control"
                                    placeholder="Masukan tipe fasilitas ..." required>
                                <p class="text-danger">{{ $errors->first('facility_type_title') }}</p>
                                {{-- <h6>*Bersifat Unik (Tidak boleh sama dengan yang lain).</h6> --}}
                            </div>
                            <!-- Tipe Fasilitas Title -->
                        </div>
                        <div class="col-12">
                            <!-- Deskripsi -->
                            <div class="form-group">
                                <h5 class="font-weight-semibold"> Deskripsi </h5>
                                <textarea type="text" name="facility_type_desc" class="form-control"
                                    placeholder="Masukan deskripsi tipe fasilitas ... " required></textarea>
                                <p class="text-danger">{{ $errors->first('facility_type_desc') }}</p>
                                {{-- <h6>*+62 .</h6> --}}
                            </div>
                            <!-- Deskripsi -->
                        </div>
                        <div class="col-12">
                            <!-- Icon Tipe Fasilitas -->
                            <div class="form-group">
                                <h5 class="font-weight-semibold mt-2"> Gambar Icon Tipe Fasilitas (Format SVG)
                                </h5>
                            </div>
                            <div class="input-group">
                                <input type="file" name="facility_type_icon" class="form-control" required>
                                <p class="text-danger">{{ $errors->first('facility_type_icon') }}</p>
                            </div>
                            <!-- Icon Tipe Fasilitas -->
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
<!-- /modal Create Tipe Fasilitas -->

<!-- Modal Update Tipe Fasilitas -->
<div id="editFacilityModal" role="" class="modal fade">
<div class="modal-dialog modal-login modal-lg" role="document">
<form class="form" method="POST" action="" id="formEditFacility" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-content">
        <div class="card card-signup card-plain">
            <div class="modal-header">
                <div class="card-header card-header-primary text-center">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="material-icons"
                            style="color: #fafafa;font-size:1.1rem;cursor: pointer;">clear</i></button>
                    <h4 class="modal-title"> Edit Tipe Fasilitas </h4>
                </div>
            </div>

            <input type="hidden" class="form-control" name="facility_type_id" id="facility_type_id"
                value="{{ old('facility_type_id') }}">
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <!-- Tipe Fasilitas Title -->
                            <div class="form-group edit_form_facility_type_title">
                                <h5 class="font-weight-semibold"> Nama Tipe Fasilitas </h5>
                                <input id="edit_form_facility_type_title" type="text"
                                    name="edit_facility_type_title" class="form-control"
                                    value="{{ old('edit_facility_type_title') }}"
                                    placeholder="Masukan tipe fasilitas ..." required>
                                <p class="text-danger">{{ $errors->first('edit_facility_type_title') }}</p>
                                {{-- <h6>*Bersifat Unik (Tidak boleh sama dengan yang lain).</h6> --}}
                            </div>
                            <!-- Tipe Fasilitas Title -->
                        </div>
                        <div class="col-12">
                            <!-- Deskripsi -->
                            <div class="form-group edit_form_facility_type_desc">
                                <h5 class="font-weight-semibold"> Deskripsi </h5>
                                <textarea id="edit_form_facility_type_desc" type="text"
                                    name="edit_facility_type_desc" class="form-control"
                                    value="{{ old('edit_facility_type_desc') }}"
                                    placeholder="Masukan deskripsi tipe fasilitas ... " required></textarea>
                                <p class="text-danger">{{ $errors->first('edit_facility_type_desc') }}</p>
                                {{-- <h6>*+62 .</h6> --}}
                            </div>
                            <!-- Deskripsi -->
                        </div>
                        <div class="col-12">
                            <!-- Icon Tipe Fasilitas -->
                            <div class="form-group">
                                <h5 class="font-weight-semibold mt-2"> Gambar Icon Tipe Fasilitas (Format SVG)
                                </h5>
                            </div>
                            <input type="hidden" class="form-control" name="facility_type_icon_image"
                                id="facilityTypeIconImage" value="{{ old('facility_type_icon_image') }}">

                            <div class="form-group facility_type_icon">
                                {{-- <h5 class="font-weight-semibold mt-2"> Ikon Kategori </h5> --}}
                                <img src="" alt="" width="100px" height="100px" id="facility_type_icon_image">
                            </div>

                            <div class="input-group">
                                <input type="file" name="edit_facility_type_icon" class="form-control">
                                <p class="text-danger">{{ $errors->first('edit_facility_type_icon') }}</p>
                            </div>
                            <!-- Icon Tipe Fasilitas -->
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
<!-- /modal Update Tipe Fasilitas -->


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


        var url = "{{ route('facility_type.index') }}/" + id;
        Swal.fire({
            title: 'Anda yakin menghapus tipe fasilitas?',
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
                                text: 'Tipe fasilitas telah dihapus',
                                icon: 'success',
                                timer: 1000
                            })
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Tipe fasilitas tidak bisa dihapus!',
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
        @if ($errors->has('facility_type_title') or $errors->has('facility_type_desc') or $errors->has('facility_type_icon'))
            $('#tambahfacilityModal').modal('show');
        @endif


        @if ($errors->has('edit_facility_type_title') or $errors->has('edit_facility_type_desc') or $errors->has('edit_facility_type_icon'))
            $('#editFacilityModal').modal('show');
            // $('#editUserModal').modal('show');
        
            var image = "{{ old('facility_type_icon_image') }}";
            // var default_photo_profile = "/pic/user.svg";
        
            $('#facility_type_icon_image').attr('src',image);
            
        
            // if (image) {
            // else {
            // $('#profile_photo_url_image').attr('src',
            // default_photo_profile);
            // }
        
        
            $('#edit_form_facility_type_title').val("{{ old('edit_facility_type_title') }}");
            $('#edit_form_facility_type_desc').val("{{ old('edit_facility_type_desc') }}");
        
            // var name = "{{ old('edit_category_type_title') }}";
            var id = "{{ old('facility_type_id') }}";
            var action = "{{ route('facility_type.index') }}/" + id;
            $('#formEditFacility').attr('action', action);
        @endif

        $(document).on('click', '.btnEditFacility ', function() {
            @if ($errors->has('edit_facility_type_title') or $errors->has('edit_facility_type_desc') or $errors->has('edit_facility_type_icon'))
                $('p.text-danger').remove();
            @endif

            var id = $(this).attr('value');
            $('#facility_type_id').val(id);

            $.ajax({
                type: 'GET',
                url: '{!! url('detailFacilityType') !!}',
                data: {
                    'id': id
                },
                dataType: 'html',
                success: function(data) {
                    var servers = $.parseJSON(data);
                    $.each(servers, function(index, value) {
                        // var category_type_title = value.category_type_title;
                        var photo_profile = "/facility_types/" + value
                            .facility_type_icon;
                        var default_photo_profile = "/pic/user.svg";

                        // if (photo_profile) {
                        //     $('#profile_photo_url_image').attr('src',
                        //         photo_profile);
                        // } else {
                        //     $('#profile_photo_url_image').attr('src',
                        //         default_photo_profile);
                        // }

                        $('#facility_type_icon_image').attr('src', photo_profile);

                        console.log(photo_profile);


                        $('#facilityTypeIconImage').val(photo_profile);

                        $('#edit_form_facility_type_title').val(value
                            .facility_type_title);
                        $('#edit_form_facility_type_desc').val(value
                            .facility_type_desc);
                    });
                }
            });

            var action = "{{ route('facility_type.index') }}/" + id;
            $('#formEditFacility').attr('action', action);
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
        $('#facilityDatatables').DataTable({
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
            ajax: "{{ route('ajax.get.data.facility.type.index') }}",
            columns: [{
                    data: 'facility_type_id',
                    name: 'facility_type_id'
                },
                {
                    data: 'facility_type_title',
                    name: 'facility_type_title'
                },
                {
                    data: 'facility_type_desc',
                    name: 'facility_type_desc'
                },
                {
                    data: 'icon',
                    name: 'icon'
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
