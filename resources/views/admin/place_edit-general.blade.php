<!-- MASTER -->
@extends('layouts/layout/template')
<!-- /MASTER -->

<!-- Title Spesific -->
@section('title')
{{ $place->title_name }} - Edit General Information
@endsection
<!-- /Title Spesific -->

<!-- Page header -->
@section('title-page')
    <a href="/place/"> Pendataan Tempat </a> 
    / <a href="/place/{{ $place->place_id }}"> {{ $place->title_name }} </a>
    /Edit Informasi Umum Tempat
@endsection
<!-- /page header -->


<!-- Content -->
@section('content')
<style>
    .thumb{
        margin: 10px 5px 0 0;
        width: 300px;
        height: 300px;
    }
</style>

<div class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Title Create Place -->
            <div class="card">
                <div class="header text-center mt-2">
                    <h3 class="title" style="font-weight: 400;"> Edit Informasi Umum Tempat </h3>
                    {{-- <p class=""><strong>Periode</strong> {{$year}} </p> --}}
                </div>
                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('place.update.general', $place->place_id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <h5 class="font-weight-semibold"> Nama Tempat </h5>
                                    <input type="text" name="title_name" class="form-control"
                                        placeholder="Masukan nama tempat ..." required value="{{ $place->title_name }}">
                                    <p class="text-danger">{{ $errors->first('title_name') }}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <h5 class="font-weight-semibold"> Kategori </h5>
                                    <select class="form-control classification_" name="category_id" required>
                                        <option selected="true" value=""> Kategori </option>
                                        @foreach ($category as $a)
                                            <option value="{{ $a->category_id }}" {{ $place->category_id == $a->category_id ? 'selected':'' }}>
                                                {{ $a->category_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <h5 class="font-weight-semibold"> Nomor Telepon </h5>
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="ex +62812345678901" required value="{{ $place->phone }}">
                                    <p class="text-danger">{{ $errors->first('phone') }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <h5 class="font-weight-semibold"> Website </h5>
                                    <input type="text" name="website" class="form-control"
                                        placeholder="Masukan alamat website ... (Optional)" value="{{ $place->website }}">
                                    {{-- <p># Opsional</p> --}}
                                    <p class="text-danger">{{ $errors->first('website') }}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <h6 style="margin-top:15px">Data yang anda masukan akan tersimpan, maka diharap anda memasukan data dengan benar.
                                    Terima kasih.</h6>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-success"
                                    style="margin-top:10px">Tambah</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
            <!-- /Title Create Place -->
        </div>
    </div>
</div>
</div>





@endsection
<!-- /content -->
@push('js')

<script>
    function loadPreview(input){
        var data = $(input)[0].files;
        $.each(data, function(index, file){
            if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){
                var fRead = new FileReader();
                fRead.onload = (function(file){
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image thumb element
                        $('#thumb-output').append(img);
                    };
                })(file);
                fRead.readAsDataURL(file);
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".btn-success").click(function() {
            var lsthmtl = $(".clone").html();
            $(".increment").after(lsthmtl);
        });
        $("body").on("click", ".alfa", function() {
            $(this).parents(".hdtuto control-group lst").remove();
        });
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


        var url = "{{ route('place.index') }}/" + id;
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

@section('scripts')
@parent
<script
src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize"
async defer></script>
<script src="/js/mapInput.js"></script>
@stop

@include('sweetalert::alert')
@endpush
