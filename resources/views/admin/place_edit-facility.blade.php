<!-- MASTER -->
@extends('layouts/layout/template')
<!-- /MASTER -->

<!-- Title Spesific -->
@section('title')
    {{ $place->title_name }} - Edit Facility
@endsection
<!-- /Title Spesific -->

<!-- Page header -->
@section('title-page')
    <a href="/place/"> Pendataan Tempat </a>
    / <a href="/place/{{ $place->place_id }}"> {{ $place->title_name }} </a>
    /Edit Fasilitas Tempat
@endsection
<!-- /page header -->

{{-- <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/sub_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/sub_assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('global_assets/sub_assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/sub_assets/css/components.min.css') }}" rel="stylesheet" type="text/css"> --}}

<!-- Content -->
@section('content')

    <style>
        .thumb {
            margin: 10px 10px 10px 10px;
            width: 300px;
            height: 300px;
        }

        .checkbox-style {
            margin: 10px 5px 10px 10px;
        }

        .checkbox-style-label {
            margin: 10px 40px 10px 5px;
        }

    </style>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Title Create Place -->
                    <div class="card">
                        <div class="header text-center mt-2">
                            <h3 class="title" style="font-weight: 400;"> Edit Fasilitas Tempat </h3>
                            {{-- <p class=""><strong>Periode</strong> {{$year}} </p> --}}
                        </div>
                        <div class="card-body">
                            <form class="form" method="POST"
                                action="{{ route('place.update.facility', $place->place_id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <h5 class="font-weight-semibold"> Pilihan Fasilitas </h5>
                                        </div>
                                        <div class="checkbox">
                                            @foreach ($facility_type as $ft)
                                                <input type="checkbox" id="inlineCheckbox1" value="{{ $ft->facility_type_id }}"
                                                    class="checkbox-style" name="facility[]"
                                                    {{ in_array( $ft->facility_type_id, $place->FacilityType->pluck('facility_type_id')->all()) ? 'checked' : '' }}
                                                    >


                                                @if ($ft->facility_type_icon == !null)
                                                    <img src="{{ asset('facility_types/' . $ft->facility_type_icon) }}"
                                                        alt="{{ $ft->facility_type_title }}" width="40px" height="40px"
                                                        id="guide_type_icon_image">
                                                @endif
                                                <label class="form-check-label checkbox-style-label" for="exampleRadios2">
                                                    {{ $ft->facility_type_title }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-sm-10">
                                        <h6 style="margin-top:15px">Data yang anda masukan akan tersimpan, maka diharap anda
                                            memasukan data dengan benar.
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
        function loadPreview(input) {
            var data = $(input)[0].files;
            $.each(data, function(index, file) {
                if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
                    var fRead = new FileReader();
                    fRead.onload = (function(file) {
                        return function(e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target
                                .result); //create image thumb element
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
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize"
                async defer></script>
        <script src="/js/mapInput.js"></script>
    @stop

    @include('sweetalert::alert')
@endpush
