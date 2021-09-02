<!-- MASTER -->
@extends('layouts/layout/template')
<!-- /MASTER -->

<!-- Title Spesific -->
@section('title', 'Pendataan Tempat')
<!-- /Title Spesific -->

<!-- Page header -->
@section('title-page', 'Pendataan Tempat')
<!-- /page header -->


<!-- Content -->
@section('content')
<div class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Place -->
            <div class="card">
                <div class="header text-center mt-2">
                    <h3 class="title" style="font-weight: 400;"> Pendataan Tempat </h3>
                    {{-- <p class=""><strong>Periode</strong> {{$year}} </p> --}}
                </div>
                <div class="card-body">
                    <div class="toolbar">
                        <div class="row d-flex justify-content-end">
                            <div class="col-md-4 text-right">
                                <div class="col-auto align-self-end">
                                    <a type="button" class="btn btn-primary m-1 pl-2 pr-2" href="{{ route('place.create') }}" style="float:right;">Tambah
                                        Tempat Baru</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="material-datatables mt-4">
                        <table class="table" id="placeDatatables" cellspacing="0" width="100%"
                            class="table table-striped table-no-bordered table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>Id</th>
                                    <th>Nama Tempat</th>
                                    <th>Kategori</th>
                                    <th>Alamat</th>
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
            <!-- /Place -->
        </div>
    </div>
</div>
</div>





@endsection
<!-- /content -->


@push('js')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $(document).on('click', '.remove', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');


        var url = "{{ route('place.index') }}/" + id;
        Swal.fire({
            title: 'Anda yakin menghapus tempat ?',
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
                                text: 'Tempat telah dihapus',
                                icon: 'success',
                                timer: 1000
                            })
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Tempat tidak bisa dihapus!',
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

{{-- <script>
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
</script> --}}

<script>
    $(document).ready(function() {
        $('#placeDatatables').DataTable({
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
            ajax: "{{ route('ajax.get.data.place.index') }}",
            columns: [{
                    data: 'place_id',
                    name: 'place_id'
                },
                {
                    data: 'title_name',
                    name: 'title_name'
                },
                {
                    data: 'category.category_title',
                    name: 'category.category_title'
                },
                {
                    data: 'address',
                    name: 'address'
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
