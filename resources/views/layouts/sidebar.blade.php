    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="index" class="logo logo-dark">
                {{-- <span class="logo-sm">
                    <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
                </span> --}}
                {{-- <span class="logo-lg">
                    <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="22">
                </span> --}}
            </a>
            <a href="index" class="logo logo-light">
                {{-- <span class="logo-sm">
                    <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="22">
                </span> --}}
            </a>
            <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span>@lang('translation.menu')</span></li>                
                    <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="{{ url('/contacts') }}"  role="button"  target="_self" >
                            <i class="menu-icon tf-icons bx bx-user"></i><span>@lang('translation.contacts')</span> 
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="{{ url('/sanction') }}"  role="button"  target="_self" >
                            <i class="ph-receipt"></i><span>@lang('translation.sanction')</span> 
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="{{ url('/disbursements') }}"  role="button"  target="_self" >
                            <i class="menu-icon tf-icons bx bx-task"></i><span>@lang('translation.disbursement')</span> 
                        </a>                       
                    </li> 
                   
                    
                    <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="#sidebarLayouts2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts" target="_self" >
                            <i class="menu-icon tf-icons bx bx-cog"></i><span>@lang('translation.settings')</span> 
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLayouts2"> 
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('/users') }}"  class="nav-link" data-key="t-horizontal" target="_self" >@lang('translation.manage user')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/roles') }}" class="nav-link" data-key="t-detached" target="_self" >@lang('translation.manage roles')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/permissions') }}" class="nav-link" data-key="t-two-column" target="_self" >@lang('translation.manage permissions')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/addbank') }}" class="nav-link" data-key="t-hovered" target="_self" >@lang('translation.manage bank')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/data-share') }}" class="nav-link" data-key="t-hovered" target="_self" >@lang('translation.manage groups')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/manage_members') }}"  class="nav-link" data-key="t-hovered" target="_self" >@lang('translation.manage sharing rules')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/payouts') }}"  class="nav-link" data-key="t-hovered" target="_self" >@lang('translation.payout structure')</a>
                                </li>
                            </ul>
                        </div>
                    </li>                
                </ul>
            </div>
            <!-- Sidebar -->
        </div>

        <div class="sidebar-background"></div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>
