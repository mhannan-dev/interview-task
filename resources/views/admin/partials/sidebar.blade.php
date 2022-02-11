<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ URL::asset('backend') }}/dist/img/customer-support.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">
                    <img src="{{ URL::asset('backend') }}/dist/img/man.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
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
                                <i class="far fa-user nav-icon text-success"></i>
                                <p>Customers</p>
                            </a>
                        </li>

                        @if (Auth::guard('admin')->user()->type == 'ADMIN')
                            @if (Session::get('page') == 'employees')
                                <?php $active = 'active'; ?>
                            @else
                                <?php $active = ''; ?>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('employees') }}" class="nav-link {{ $active }}">
                                    <i class="far fa-user nav-icon text-warning"></i>
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
