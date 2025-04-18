<div id="sidebar" class="app-sidebar">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">

            <div class="menu-item" id="dashboard" style="margin-top: 20px !important">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-house"></i>
                    </div>
                    <div class="menu-text">Home</div>
                </a>
            </div>
            @if( Auth::user()->role === 'admin' || Auth::user()->role === 'parish_priest' )
            <div class="menu-item" id="accounts">
                <a href="{{ route('accounts') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="menu-text">Accounts</div>
                </a>
            </div>
            @endif


            <div class="menu-item" id="requests">
                <a href="{{ route('request') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-file"></i>
                    </div>
                    <div class="menu-text">Requests</div>
                </a>
            </div>
            @if(Auth::user()->role === 'secretary' || Auth::user()->role === 'admin' || Auth::user()->role === 'parish_priest' || Auth::user()->role === 'priest')
            <div class="menu-item" id="schedules">
                <a href="{{ route('schedules') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="menu-text">Schedules</div>
                </a>
            </div>
            @endif
            @if(Auth::user()->role === 'secretary' || Auth::user()->role === 'admin' || Auth::user()->role === 'parish_priest')
            <div class="menu-item" id="announcements">
                <a href="{{ route('anouncements') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-bullhorn"></i>
                    </div>
                    <div class="menu-text">Announcements</div>
                </a>
            </div> 
            @endif
            @if(Auth::user()->role === 'secretary' || Auth::user()->role === 'admin')
            <div class="menu-item" id="liturgical">
                <a href="/liturgical" class="menu-link">
                    <div class="menu-icon">
                    <i class="fa fa-cross"></i>
                    </div>
                    <div class="menu-text">Liturgical Services</div>
                </a>
            </div>
            @endif
            @if(Auth::user()->role === 'secretary' || Auth::user()->role === 'admin' || Auth::user()->role === 'parish_priest')
            <div class="menu-item has-sub " id="reports">
                <a href="javascript:;" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-folder"></i>
                    </div>
                    <div class="menu-text">Reports </div>
                    <div class="menu-caret"></div>
                </a>
                <div class="menu-submenu">
                @if(Auth::user()->role === 'parish_priest')
                    <div class="menu-item" id="report_priest">
                        <a href="{{ route('report-annual') }}" class="menu-link">
                            <div class="menu-text">Priest Completed Services </i></div>
                        </a>
                    </div>
                    @endif
                    <div class="menu-item" id="report_total">
                        <a href="{{ route('liturgical-annual') }}" class="menu-link">
                            <div class="menu-text">Total Liturgical Services Requested </i></div>
                        </a>
                    </div>
                   
                </div>
            </div>
            @endif
            <!-- END minify-button -->
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>