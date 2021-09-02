<ul class="nav">    
    <li class="nav-item {{ Request::segment(1) === 'main' ? 'active' : null }}  ">
        <a href="{{route('main.index')}}" class="nav-link">
            <i class="material-icons">dashboard</i>
            <p>Dashboard</p>
        </a>
    </li>
    <li class="nav-item {{ Request::segment(1) === 'user_management' ? 'active' : null }}  ">
        <a href="{{route('user_management.index')}}"class="nav-link">
            <i class="material-icons">manage_accounts</i>
            <p>Managemen Pengguna</p>
        </a>
    </li>
    <li class="nav-item {{ Request::segment(1) === 'place' ? 'active' : null }}">
        <a class="nav-link" href="{{ route('place.index') }}">
            <i class="material-icons">business</i>
            <p>Pendataan Tempat</p>
        </a>
    </li>
    <li class="nav-item {{ Request::segment(1) === 'category' ? 'active' : null }}">
        <a class="nav-link" href="{{ route('category.index') }}">
            <i class="material-icons">view_list</i>
            <p>Kategori</p>
        </a>
    </li>
    <li class="nav-item {{ Request::segment(1) === 'facility_type' ? 'active' : null }}">
        <a class="nav-link" href="{{ route('facility_type.index') }}">
            <i class="material-icons">accessible</i>
            <p>Jenis Fasilitas</p>
        </a>
    </li>
    <li class="nav-item {{ Request::segment(1) === 'guide_type' ? 'active' : null }}">
        <a class="nav-link" href="{{ route('guide_type.index') }}">
            <i class="material-icons">library_books</i>
            <p>Jenis Panduan</p>
        </a>
    </li>
</ul>