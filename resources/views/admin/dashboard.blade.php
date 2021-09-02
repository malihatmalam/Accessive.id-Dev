<!-- MASTER -->
@extends('layouts/layout/template')
<!-- /MASTER -->

<!-- Title Spesific -->
@section('title', 'Dashboard')
<!-- /Title Spesific -->

<!-- Page header -->
@section('title-page', 'Dashboard')
<!-- /page header -->

@section('content')
    @php
    $month = null;
    setlocale(LC_ALL, 'id_ID');
    @endphp

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
            width: 100%;
            height: 600px;
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


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats mt-0">
                    <div class="card-header card-header-icon pb-4 pt-4">
                        <div class="card-icon" style="background: linear-gradient(60deg, #ffa726, #fb8c00);">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <p class="card-category">Jumlah Pengguna Aktif</p>
                        <h3 class="card-title">
                            {{ $user_count->count() }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats mt-0">
                    <div class="card-header card-header-success card-header-icon pb-4 pt-4">
                        <div class="card-icon">
                            <i class="material-icons">business</i>
                        </div>
                        <p class="card-category">Jumlah Tempat</p>
                        <h3 class="card-title mt-4">
                            {{ $place_count->count() }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats mt-0">
                    <div class="card-header card-header-danger card-header-icon pb-4 pt-4">
                        <div class="card-icon">
                            <i class="material-icons">accessible</i>
                        </div>
                        <p class="card-category">Jumlah Fasilitas</p>
                        <h3 class="card-title mt-4">
                            {{ $facility_count->count() }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats mt-0">
                    <div class="card-header card-header-info card-header-icon pb-4 pt-4">
                        <div class="card-icon">
                            <i class="material-icons">auto_stories</i>
                        </div>
                        <p class="card-category">Jumlah Panduan</p>
                        <h3 class="card-title mt-4">
                            {{ $guide_count->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="mymap"></div>
                    </div>
                </div>
            </div>
        </div>

        @include('sweetalert::alert')
    </div>
@endsection
@push('js')

    <script type="text/javascript">
        var locations = <?php print_r(json_encode($place_count)); ?>;
        var mymap = new GMaps({
            el: '#mymap',
            lat: -7.797068,
            lng: 110.370529,
            zoom: 12
        });


        $.each(locations, function(index, value) {
            mymap.addMarker({
                lat: value.latitude,
                lng: value.longitude,
                title: value.title_name,
                infoWindow: {
                    content: value.title_name
                }
            });
        });
    </script>


    <script>
        $(function() {
            'use strict'

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            var $salesChart = $('#laba-rugi')

            var salesChart = new Chart($salesChart, {
                type: 'bar',
                data: {
                    labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUL', 'AGT', 'SEP', 'OKT', 'NOV', 'DES'],
                    datasets: [{
                        backgroundColor: ['#109CF1', '#FFB946', '#F7685B', '#2ED47A', '#885AF8',
                            '#47C7EB', '#109CF1', '#FFB946', '#F7685B', '#2ED47A', '#885AF8',
                            '#47C7EB'
                        ],
                        borderColor: '#007bff',
                        data: [1000, 2000, 3000, 2500, 2700, 2500, 3000, 500, 200, 100, 400, 500,
                            500
                        ]
                    }, ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    if (value >= 1000) {
                                        value /= 1000
                                        value += 'k'
                                    }
                                    return 'Rp' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })

            $.ajax({
                type: "GET",
                url: "{{ route('cash_flow') }}",
                dataType: "json",
                success: function(data) {
                    // console.log(data.bulan);
                    window.myChart = new Chart(document.getElementById('myChart'), {
                        type: 'bar',
                        data: {
                            labels: data.bulan,
                            datasets: [{
                                    label: 'cash in',
                                    data: data.in,
                                    backgroundColor: '#2ED47A',
                                    borderColor: '#2ED47A',
                                    borderWidth: 0
                                },
                                {
                                    label: 'cash out',
                                    data: data.out,
                                    backgroundColor: '#47C7EB',
                                    borderColor: '#47C7EB',
                                    borderWidth: 0
                                }
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    // display: false,
                                    gridLines: {
                                        display: true,
                                        lineWidth: '4px',
                                        color: 'rgba(0, 0, 0, .2)',
                                        zeroLineColor: 'transparent'
                                    },
                                    ticks: $.extend({
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index,
                                            values) {
                                            if (value >= 1000000) {
                                                value /= 1000000
                                                value += 'jt'
                                                return 'Rp' + value
                                            } else if (value <= -1000000) {
                                                value /= 1000000 * -1
                                                value += 'jt'
                                                return '-Rp' + value
                                            }
                                        }
                                    }, ticksStyle)
                                }],
                                xAxes: [{
                                    stacked: true,
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]

                            }
                        }
                    });
                }
            })

            $(document).on('click', '.btnFIlter', function(e) {
                e.preventDefault();
                var year = $('#yearFilter').val();
                var month = $('#period-daily').val();
                var period = $('.period').val();

                if (period == "Bulanan") {
                    window.myChart.destroy();
                    var path = "{{ route('cash_flow') }}?year=" + year;
                    $.ajax({
                        type: "GET",
                        url: path,
                        dataType: "json",
                        success: function(data) {
                            // console.log(data.bulan);
                            window.myChart = new Chart(document.getElementById('myChart'), {
                                type: 'bar',
                                data: {
                                    labels: data.bulan,
                                    datasets: [{
                                            label: 'cash in',
                                            data: data.in,
                                            backgroundColor: '#2ED47A',
                                            borderColor: '#2ED47A',
                                            borderWidth: 0
                                        },
                                        {
                                            label: 'cash out',
                                            data: data.out,
                                            backgroundColor: '#47C7EB',
                                            borderColor: '#47C7EB',
                                            borderWidth: 0
                                        }
                                    ]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            // display: false,
                                            gridLines: {
                                                display: true,
                                                lineWidth: '4px',
                                                color: 'rgba(0, 0, 0, .2)',
                                                zeroLineColor: 'transparent'
                                            },
                                            ticks: $.extend({
                                                // Include a dollar sign in the ticks
                                                callback: function(
                                                    value, index,
                                                    values) {
                                                    if (value >=
                                                        1000000) {
                                                        value /=
                                                            1000000
                                                        value +=
                                                            'jt'
                                                        return 'Rp' +
                                                            value
                                                    } else if (
                                                        value <= -
                                                        1000000) {
                                                        value /=
                                                            1000000 *
                                                            -1
                                                        value +=
                                                            'jt'
                                                        return '-Rp' +
                                                            value
                                                    }
                                                }
                                            }, ticksStyle)
                                        }],
                                        xAxes: [{
                                            stacked: true,
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]

                                    }
                                }
                            });
                        }
                    });

                } else if (period == "Harian") {
                    window.myChart.destroy();
                    var path = "{{ route('cash_flow_daily') }}/" + year + "-" + month;
                    console.log(path);
                    $.ajax({
                        type: "GET",
                        url: path,
                        dataType: "json",
                        success: function(data) {
                            // console.log(data.bulan);
                            window.myChart = new Chart(document.getElementById('myChart'), {
                                type: 'line',
                                data: {
                                    labels: data.day,
                                    datasets: [{
                                            fill: false,
                                            label: 'cash in',
                                            data: data.in,
                                            borderWidth: 2,
                                            lineTension: 0,
                                            spanGaps: true,
                                            borderColor: '#2ED47A',
                                            pointRadius: 3,
                                            pointHoverRadius: 7,
                                            pointColor: '#2ED47A',
                                            pointBackgroundColor: '#2ED47A',
                                        },
                                        {
                                            fill: false,
                                            label: 'cash out',
                                            data: data.out,
                                            borderWidth: 2,
                                            lineTension: 0,
                                            spanGaps: true,
                                            borderColor: '#47C7EB',
                                            pointRadius: 3,
                                            pointHoverRadius: 7,
                                            pointColor: '#47C7EB',
                                            pointBackgroundColor: '#47C7EB',
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        yAxes: [{
                                            // display: false,
                                            gridLines: {
                                                display: true,
                                                lineWidth: '4px',
                                                color: 'rgba(0, 0, 0, .2)',
                                                zeroLineColor: 'transparent'
                                            },
                                            ticks: $.extend({
                                                // Include a dollar sign in the ticks
                                                callback: function(
                                                    value, index,
                                                    values) {
                                                    if (value >=
                                                        1000000) {
                                                        value /=
                                                            1000000
                                                        value +=
                                                            'jt'
                                                        return 'Rp' +
                                                            value
                                                    } else if (
                                                        value <= -
                                                        1000000) {
                                                        value /=
                                                            1000000 *
                                                            -1
                                                        value +=
                                                            'jt'
                                                        return '-Rp' +
                                                            value
                                                    }
                                                }
                                            }, ticksStyle)
                                        }],
                                        xAxes: [{
                                            stacked: true,
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]

                                    }
                                }
                            });
                        }
                    });
                }

            });

            //---------------------
            //- STACKED BAR CHART -
            //---------------------
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')

            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            var stackedBarChart = new Chart(stackedBarChartCanvas, {
                type: 'bar',
                options: stackedBarChartOptions
            })
        })
        document.getElementById("myDIV").style.display = "none";

        function myFunction() {
            var x = document.getElementById("myDIV");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

        document.getElementById("period-daily").style.display = "none";
        $(document).on('change', 'select.period', function(e) {
            var x = document.getElementById("period-daily");
            var period = $("select.period").val();
            if (period == "Harian") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        });
    </script>
@endpush



{{-- <!-- Content area -->
@section('content')
    <div class="content">

        <!-- Main charts -->
        <div class="row">
            <div class="col-xl">

                <!-- Traffic sources -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                    </div>

                    <div class="card-body py-0">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <a href="#"
                                        class="btn bg-transparent border-teal text-teal rounded-round border-2 btn-icon mr-3">
                                        <i class="icon-plus3"></i>
                                    </a>
                                    <div>
                                        <div class="font-weight-semibold">New visitors</div>
                                        <span class="text-muted">2,349 avg</span>
                                    </div>
                                </div>
                                <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                            </div>

                            <div class="col-sm-3">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <a href="#"
                                        class="btn bg-transparent border-warning-400 text-warning-400 rounded-round border-2 btn-icon mr-3">
                                        <i class="icon-watch2"></i>
                                    </a>
                                    <div>
                                        <div class="font-weight-semibold">New sessions</div>
                                        <span class="text-muted">08:20 avg</span>
                                    </div>
                                </div>
                                <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                            </div>

                            <div class="col-sm-3">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <a href="#"
                                        class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon mr-3">
                                        <i class="icon-people"></i>
                                    </a>
                                    <div>
                                        <div class="font-weight-semibold">Total online</div>
                                        <span class="text-muted"><span class="badge badge-mark border-success mr-2"></span>
                                            5,378 avg</span>
                                    </div>
                                </div>
                                <div class="w-75 mx-auto mb-3" id="total-online"></div>
                            </div>

                            <div class="col-sm-3">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <a href="#"
                                        class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon mr-3">
                                        <i class="icon-people"></i>
                                    </a>
                                    <div>
                                        <div class="font-weight-semibold">Total online</div>
                                        <span class="text-muted"><span class="badge badge-mark border-success mr-2"></span>
                                            5,378 avg</span>
                                    </div>
                                </div>
                                <div class="w-75 mx-auto mb-3" id="total-online"></div>
                            </div>
                        </div>
                    </div>

                    <div class="chart position-relative" id="traffic-sources"></div>
                </div>
                <!-- /traffic sources -->

            </div>
        </div>
        <!-- /main charts -->

    </div>
@endsection
<!-- /content area --> --}}
