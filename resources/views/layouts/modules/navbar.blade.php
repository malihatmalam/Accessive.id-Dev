<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark">
     <div class="navbar-brand">
          <a href="index.html" class="d-inline-block">
               <img src="../../../../global_assets/images/logo_light.png" alt="">
          </a>
     </div>

     <div class="d-md-none">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
               <i class="icon-tree5"></i>
          </button>
          <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
               <i class="icon-paragraph-justify3"></i>
          </button>
     </div>

     <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="navbar-nav">
               <li class="nav-item">
                    <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                         <i class="icon-paragraph-justify3"></i>
                    </a>
               </li>
          </ul>

          <span class="badge bg-success ml-md-3 mr-md-auto">Aktif</span>

          <ul class="navbar-nav ">
               <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                         <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle mr-2" height="34" alt="">
                         <span>{{ Auth::user()->UserData->full_name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                         <a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
                         <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                    </form>
               </li>
          </ul>
     </div>
</div>
<!-- /main navbar -->