<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="#"><img src="../../../../global_assets/images/placeholders/placeholder.jpg" width="38"
                                height="38" class="rounded-circle" alt=""></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ Auth::user()->UserData->full_name }} <strong>( {{ Auth::user()->role }} )</strong></div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-pin font-size-sm"></i> &nbsp; {{ Auth::user()->UserData->address }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('main.index') }}" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                <!-- /Dashboard -->

                <!-- Managemen Pengguna -->
                <li class="nav-item">
                    <a href="index.html" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>
                            Managemen Pengguna
                        </span>
                    </a>
                </li>
                <!-- /Managemen Pengguna -->

                <!-- Pendataan Tempat -->
                <li class="nav-item">
                    <a href="index.html" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>
                            Pendataan Tempat
                        </span>
                    </a>
                </li>
                <!-- /Pendataan Tempat -->

                <!-- Kategori -->
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>
                            Kategori
                        </span>
                    </a>
                </li>
                <!-- /Kategori -->

                <!-- Jenis Fasilitas -->
                <li class="nav-item">
                    <a href="index.html" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>
                            Jenis Fasilitas
                        </span>
                    </a>
                </li>
                <!-- /Jenis Fasilitas -->

                <!-- Jenis Panduan -->
                <li class="nav-item">
                    <a href="index.html" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>
                            Jenis Panduan
                        </span>
                    </a>
                </li>
                <!-- /Jenis Panduan -->


                <!-- /main -->
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
