<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link text-center">
        <i class="nav-icon fas fa-tachometer-alt fa-3x"></i>
        {{-- <span class="brand-text font-weight-light">Dashboard</span> --}}
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{ url('admin/profile-update') }}" class="d-block">
                    <i class="fas fa-user fa-2x text-warning"></i> &nbsp;
                    {{ Auth::guard('admin')->user()->name }}/{{ Auth::guard('admin')->user()->type }}</a>
            </div>
        </div>
        
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- Settings --}}
                <li class="nav-item menu-is-opening menu-open">
                    <ul class="nav nav-treeview" style="display: block;">
                        @if (Session::get('page') == 'customers')
                            <?php $active = 'active'; ?>
                        @else
                            <?php $active = ''; ?>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('customers') }}" class="nav-link {{ $active }}">
                                <i class="far fa-user nav-icon"></i>
                                <p>Customers</p>
                            </a>
                        </li>

                        @if (Auth::guard('admin')->user()->type == "ADMIN")

                        @if (Session::get('page') == 'employees')
                            <?php $active = 'active'; ?>
                        @else
                            <?php $active = ''; ?>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('employees') }}" class="nav-link {{ $active }}">
                                <i class="far fa-user nav-icon"></i>
                                <p>Employees</p>
                            </a>
                        </li>


                        @endif
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
