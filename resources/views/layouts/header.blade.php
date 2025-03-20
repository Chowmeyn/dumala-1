<div id="header" class="app-header" data-bs-theme="dark">
    <!-- BEGIN navbar-header -->
    <div class="navbar-header">
        <a href="/dashboard" class="navbar-brand">
            <img src="{{ asset('assets/img/logos-dumala-trans.png') }}" alt="Logo"
                style="height: 100px; width: auto;" />
        </a>
        <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- END navbar-header -->
    <!-- BEGIN header-nav -->
    <div class="navbar-nav">

        <div class="navbar-item dropdown">
            <a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon">
                <i class="fa fa-bell"></i>
                <div class="noti">
                    @if(get_count_notify() != 0)
                        <span class="badge">{{get_count_notify()}}</span>
                    @endif
                </div>

            </a>
            <div class="dropdown-menu media-list dropdown-menu-end">
                <div class="dropdown-header noti_head">NOTIFICATIONS ({{get_count_notify()}})</div>
                <div class="list_notify">
                    <!-- <a href="javascript:;" class="dropdown-item media">
                        <div class="media-left">
                            <img src="{{ asset('assets/img/user/user-1.jpg') }}" class="media-object" alt="" />
                            <i class="fab fa-facebook-messenger text-blue media-object-icon"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="media-heading">John Smith</h6>
                            <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                            <div class="text-muted fs-10px">25 minutes ago</div>
                        </div> 
                    </a> -->
                </div>

                <div class="dropdown-footer text-center">
                    <a class="text-decoration-none" data-bs-toggle="offcanvas" href="#offcanvasEndExample">View more</a>
                </div>
            </div>
        </div>
        <div class="navbar-item navbar-user dropdown">
            <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                <img src="{{  Auth::user()->profile_image }}" alt="" />
                <span class="d-none d-md-inline">{{ Auth::user()->firstname.' '. Auth::user()->lastname }}</span> <b
                    class="caret ms-6px"></b>
            </a>
            <div class="dropdown-menu dropdown-menu-end me-1">
                <a class="dropdown-item" onclick="openEditModalv('{{Auth::user()->id}}')">Edit Profile</a>

                <a href="#modal-dialog-changepass" class="dropdown-item" data-bs-toggle="modal">Change password</a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="dropdown-item">Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    <!-- END header-nav -->
</div>