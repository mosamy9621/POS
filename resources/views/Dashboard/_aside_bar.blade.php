<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('Dashboard/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{auth()->user()->avatarPath}}" class="img-circle elevation-2" style="width:40px; height: 40px;" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('dashboard.index')}}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            @lang('site.dashboard')
                        </p>
                    </a>

                </li>

                @can('ReadUsers',auth()->user())
                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('dashboard.users.index')}}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            @lang('site.users')
                        </p>
                    </a>

                </li>
                    @endcan

                @if(auth()->user()->hasPermission('read-categories'))
                    <li class="nav-item has-treeview menu-open">
                        <a href="{{route('dashboard.categories.index')}}" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                @lang('site.categories')
                            </p>
                        </a>

                    </li>
                @endif
                @if(auth()->user()->hasPermission('read-products'))
                    <li class="nav-item has-treeview menu-open">
                        <a href="{{route('dashboard.products.index')}}" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                @lang('site.products')
                            </p>
                        </a>

                    </li>
                @endif
                @if(auth()->user()->hasPermission('read-clients'))
                    <li class="nav-item has-treeview menu-open">
                        <a href="{{route('dashboard.clients.index')}}" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                @lang('site.clients')
                            </p>
                        </a>

                    </li>
                @endif
                <li class="nav-item has-treeview menu-open">
                    <a  href="#" id="acnhor" class="nav-link active" onclick="document.getElementById('submit').submit()">
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                        <P>
                        @lang('site.logout')
                        </P>
                    </a>
                </li>
            </ul>
        </nav>
            <!-- /.sidebar-menu -->
        <form METHOD="POST" action="{{route('logout')}}" id="submit">
            @csrf
        </form>

    </div>

    <!-- /.sidebar -->
</aside>
