<!-- MASTER -->
@extends('layouts/layout/template')
<!-- /MASTER -->

<!-- Title Spesific -->
@section('title')
    {{ $place->title_name }}
@endsection
<!-- /Title Spesific -->

<!-- Page header -->
@section('title-page')
    <a href="/place/"> Pendataan Tempat </a> / {{ $place->title_name }}
@endsection
<!-- /page header -->

<link rel="stylesheet" href="/css/gallery.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>

<!-- Content -->
@section('content')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>


    <style>
        .thumb {
            margin: 10px 5px 0 0;
            width: 300px;
            height: 300px;
        }

        .guide-icon {
            border: 2px solid purple;
            border-radius: 5px;
            padding: 4px;
        }

        .guide-title {
            margin: 8px;
        }

    </style>
    <style type="text/css">
        #mymap {
            /* border:1px solid red; */
            width: 800px;
            height: 250px;
        }

        .gallery {
            display: inline-block;
            margin-top: 20px;
        }

        .close-icon {
            border-radius: 50%;
            position: absolute;
            height: 30px;
            width: 30px;
            right: 4px;
            top: -20px;
            bottom: 10px;
            padding: 2px 2px;
        }

    </style>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Title Create Place -->
                    <div class="card">
                        <div class="header ml-4 mt-4">
                            <h2 class="title" style="font-weight: 400;"> <strong> {{ $place->title_name }} </strong> </h2>
                            <h5><strong> ( {{ $place->Category->category_title }} ) </strong> </h5>
                            <hr>
                            {{-- <p class=""><strong>Periode</strong> {{$year}} </p> --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Foto Tempat</h4>
                                </div>
                            </div>
                            <form action="{{ route('place.add.photo', $place->place_id) }}" method="POST"
                                enctype="multipart/form-data">
                                <div class="row justify-content-end">
                                    {!! csrf_field() !!}
                                    <div class="col-sm-5">
                                        <strong>Tambah Foto Tempat :</strong>
                                        <input type="file" name="photo" class="form-control" required>
                                        <h6 class="inline"><i><strong> Maksimal ukuran file 4 mb </strong></i></h6>
                                    </div>
                                    <div class="col-sm-2">
                                        <br />
                                        <button type="submit" class="btn btn-success">Upload</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <div class="row text-center">
                                <div class="card-columns">
                                    @if ($place->PlacePhoto->count())
                                        @foreach ($place->PlacePhoto as $b)
                                            <div class="card">
                                                <div class='col-sm-3'>
                                                    <a rel="ligthbox" class='card-img-top'
                                                        href="/place_photos/{{ $b->place_photo_url }}">
                                                        <img height="160px" width="279px"
                                                            src="{{ asset('place_photos/' . $b->place_photo_url) }}"
                                                            alt="{{ $b->place_photo_url }}" id="guide_type_icon_image">
                                                        <div class='text-center'>
                                                            {{-- <small class='text-muted'>{{ $image->title }}</small> --}}
                                                        </div> <!-- text-center / end -->
                                                    </a>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <form
                                                                    action="{{ url('deleted-place-photo', $place->place_id) }}"
                                                                    method="POST">
                                                                    {!! csrf_field() !!}
                                                                    {{-- <input type="hidden" name="_method" value="delete"> --}}
                                                                    <input type="hidden" name="place_photo_id"
                                                                        value="{{ $b->place_photo_id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- col-6 / end -->
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div> <!-- row / end -->
                        </div>
                    </div>
                    <!-- /Title Create Place -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h4><strong> Informasi Tempat : </strong></h4>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <a type="button" class="btn btn-warning m-1 pl-2 pr-2"
                                                href="{{ route('place.edit.general', $place->place_id) }}"
                                                style="float:right;">Ubah</a>
                                            <div class="col-auto align-self-end">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h5> Telepon </h5>
                                        </div>
                                        <div class="col-sm-5">
                                            <span>: {{ $place->phone }} </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h5> Website </h5>
                                        </div>
                                        <div class="col-sm-5">
                                            <span>: {{ $place->website }} </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h4><strong> Fasilitas Tempat : </strong></h4>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <a type="button" class="btn btn-warning m-1 pl-2 pr-2"
                                                href="{{ route('place.edit.facility', $place->place_id) }}"
                                                style="float:right;">Ubah</a>
                                            <div class="col-auto align-self-end">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @forelse ($place->FacilityType as $a)
                                            <div class="col-sm-2">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        @if ($a->facility_type_icon == !null)
                                                            <img src="{{ asset('facility_types/' . $a->facility_type_icon) }}"
                                                                alt="{{ $a->facility_type_title }}" width="40px"
                                                                height="40px" id="guide_type_icon_image">
                                                        @endif
                                                        <h6> {{ $a->facility_type_title }} </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty

                                        @endforelse
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h4><strong> Lokasi : </strong></h4>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <a type="button" class="btn btn-warning m-1 pl-2 pr-2"
                                                href="{{ route('place.edit.location', $place->place_id) }}"
                                                style="float:right;">Ubah</a>
                                            <div class="col-auto align-self-end">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span> {{ $place->address }} </span>
                                        </div>
                                        <div class="col-sm-12">
                                            <span hidden> {{ $place->address_gmap }} </span>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div id="mymap"></div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <h4 class="title mt-3" style="font-weight: 400;"> <strong> Panduan Tempat
                                                </strong> </h4>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="col-md-2 text-right">
                                                <a type="button" class="btn btn-success m-1 pl-2 pr-2"
                                                    href="{{ route('place.create.guide', $place->place_id) }}"
                                                    style="float:right;">Tambah</a>
                                                <div class="col-auto align-self-end">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @if ($guide->count())
                                        @foreach ($guide as $g)
                                            <div class="row ml-2 mr-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <h5 class="guide-title" style="color: purple;">
                                                                    <strong>{{ $g->GuideType->guide_type_title }}</strong>
                                                                </h5>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <img src="{{ asset('guide_types/' . $g->GuideType->guide_type_icon) }}"
                                                                    alt="{{ $g->GuideType->guide_type_title }}"
                                                                    width="40px" height="40px" id="guide_type_icon_image"
                                                                    class="guide-icon">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        @if ($g->GuidePhoto->count())
                                                            <div class="row photos">
                                                                @foreach ($g->GuidePhoto as $gp)
                                                                    <div class="col-sm-6 col-md-4 col-lg-3 item  mt-3">
                                                                        <a href="{{ asset('guide_photos/' . $gp->guide_photo_url) }}"
                                                                            data-lightbox="photos"><img class="img-fluid"
                                                                                src="{{ asset('guide_photos/' . $gp->guide_photo_url) }}"
                                                                                style="margin-bottom: 10px">
                                                                        </a>
                                                                        <form
                                                                            action="{{ url('deleted-guide-photo', $place->place_id) }}"
                                                                            method="POST">
                                                                            {!! csrf_field() !!}
                                                                            {{-- <input type="hidden" name="_method" value="delete"> --}}
                                                                            <input type="hidden" name="guide_photo_id"
                                                                                value="{{ $gp->guide_photo_id }}">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Hapus</button>
                                                                        </form>
                                                                        {{-- <a href="" class="btn btn-danger">Hapus</a> --}}
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <p><strong> Deskripsi </strong></p>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        {!! html_entity_decode($g->guide_desc) !!}
                                                                        {{-- htmlspecialchars( $g->guide_desc) --}}
                                                                        {{-- <p>: {{ $g->guide_desc }} </p> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row justify-content-end">
                                                            <div class="col-md-1 mr-4">
                                                                <a href="{{ route('place.edit.guide', $g->guide_id) }}"
                                                                    class="btn btn-warning">Ubah</a>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <form
                                                                    action="{{ route('place.delete.guide', $g->guide_id) }}"
                                                                    method="POST">
                                                                    {!! csrf_field() !!}
                                                                    {{-- <input type="hidden" name="_method" value="delete"> --}}
                                                                    <input type="hidden" name="guide_id">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
<!-- /content -->
@push('js')

    <script type="text/javascript">
        var locations = {!! json_encode($place->toArray()) !!};
        // var latitude = locations.latitude;

        var mymap = new GMaps({
            el: '#mymap',
            lat: locations.latitude,
            lng: locations.longitude,
            zoom: 17
        });

        mymap.addMarker({
            lat: locations.latitude,
            lng: locations.longitude,
            // title: value.city,
            click: function(e) {
                alert(locations.address_gmap);
            }
        });
    </script>


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

        {{-- // <script src="/js/mapInput.js"></script> --}}
    @stop

    @include('sweetalert::alert')
@endpush
