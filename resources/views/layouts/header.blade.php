<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Website -->
    <title>Accessive.id - @yield('title')</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/sub_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/sub_assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('global_assets/sub_assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/sub_assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/sub_assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>

    <script src="{{ asset('global_assets/sub_assets/js/app.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/dashboard.js') }}"></script>
    <!-- /theme JS files -->

    <!-- Datatable JS files -->
    <script src="{{ asset('global_assets/js/demo_pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/datatables_advanced.js') }}"></script>
    <!-- /Datatable JS files -->

    <!-- Chartist JS -->
    <script src="{{ url('/') }}/assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ url('/') }}/assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ url('/') }}/assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>

    <script src="{{ url('/') }}/vendor/sweetalert/sweetalert.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <link href="{{ url('/') }}/assets/chosen/1.8.7/chosen.min.css" rel="stylesheet" />


</head>

<body>

    <!-- Main navbar -->
    @include('layouts.modules.navbar')
    <!-- /main navbar -->


    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        @include('layouts.modules.sidebar')
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            @yield('page-header-content')
            <!-- /page header -->


            <!-- Content area -->
            @yield('content')
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->


    <!-- Footer -->
    @include('layouts.modules.footer')
    <!-- /footer -->

</body>

</html>
