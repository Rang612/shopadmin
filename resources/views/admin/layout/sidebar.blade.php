<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logo-white.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">XRAY SHOP</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <!-- Route dành cho Super Admin -->
                @if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->role === 'super_admin')                    <li class="nav-item">
                    <li class="nav-item">
                        <a href="dashboard.html" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon mr-2" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 4a2 2 0 012-2h4l2 2h8a2 2 0 012 2v1H2V4zm0 3h20v9a2 2 0 01-2 2H4a2 2 0 01-2-2V7z"/>
                        </svg>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sub-categories.index') }}" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon mr-2" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3h12a1 1 0 011 1v2H3V4a1 1 0 011-1zm-1 5h14v2H3V8zm0 4h14v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z"/>
                        </svg>
                        <p>Sub Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pages.index') }}" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon mr-2" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 2a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414A1 1 0 0116 4.414V18a2 2 0 01-2 2H6a2 2 0 01-2-2V2zm6 1v4h4l-4-4z"/>
                        </svg>
                        <p>Pages</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('store_location.index') }}" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon mr-2" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a1 1 0 0 0-1 1v1.14a2 2 0 0 0 .51 1.33L4 7v10a1 1 0 0 0 1 1h2v-5h6v5h2a1 1 0 0 0 1-1V7l.49-.53A2 2 0 0 0 17 5.14V4a1 1 0 0 0-1-1H4zm1 2h10v.14a1 1 0 0 1-.25.67L14 7H6l-.75-.19A1 1 0 0 1 5 5.14V5z"/>
                        </svg>
                        <p>Store Location</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admins.index')}}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Admins</p>
                    </a>
                </li>
                @endif

                <!-- Route dành cho Admin -->
                @if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->role === 'admin')                    <li class="nav-item">
                        <a href="{{route('brands.index')}}" class="nav-link">
                            <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p>Brands</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('shipping.create')}}" class="nav-link">
                            <!-- <i class="nav-icon fas fa-tag"></i> -->
                            <i class="fas fa-truck nav-icon"></i>
                            <p>Shipping</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('orders.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('coupons.index')}}" class="nav-link">
                            <i class="nav-icon  fa fa-percent" aria-hidden="true"></i>
                            <p>Discount</p>
                        </a>
                    </li>
                <li class="nav-item">
                    <a href="{{route('admin.coupons.usage')}}" class="nav-link">
                        <i class="nav-icon  fa fa-tag" aria-hidden="true"></i>
                        <p>Coupon Usage History</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.blog.index')}}" class="nav-link">
                        <i class="nav-icon  fa fa-newspaper" aria-hidden="true"></i>
                        <p>Blogs</p>
                    </a>
                </li>
                    <li class="nav-item">
                        <a href="{{route('users.index')}}" class="nav-link">
                            <i class="nav-icon  fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                <li class="nav-item">
                    <a href="{{route('staffs.index')}}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Support Staffs</p>
                    </a>
                </li>
                @endif

                <!-- Route dành cho Support Staff -->
                @if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->role === 'support_staff')                    <li class="nav-item">
                    <li class="nav-item">
                    <a href="{{route('orders.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Orders</p>
                    </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.blog.index')}}" class="nav-link">
                            <i class="nav-icon  fa fa-newspaper" aria-hidden="true"></i>
                            <p>Blogs</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
