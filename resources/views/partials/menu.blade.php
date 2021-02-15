<!-- Sidebar -->
<div class="sidebar" data-color="orange" data-background-color="white">
    <!-- Brand Logo -->
    <div class="logo">
        <a href="#" class="simple-text logo-normal">
            {{ trans('panel.site_title') }}
        </a>
    </div>
   <!-- Sidebar Menu -->
    <div class="sidebar-wrapper">
        <ul class="nav" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item {{ request()->is('admin') || request()->is('admin') ? 'active' : '' }}" >
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <p>
                        <i class="fas fa-fw fa-tachometer-alt"> </i>
                        <span>{{ trans('global.dashboard') }}</span>
                    </p>
                </a>
            </li>
            
            @can('product_management')
            <li class="nav-item has-treeview {{ request()->is('admin/permissions/*') ? 'menu-open' : '' }} {{ request()->is('admin/roles/*') ? 'menu-open' : '' }} {{ request()->is('admin/category/*') ? 'menu-open' : '' }} {{ request()->is('admin/product') || request()->is('admin/product') ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#product_management">
                    <i class="fab fa-product-hunt"></i>
                    <p>
                        <span>Products</span>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="product_management">
                    <ul class="nav">
                        @can('product_access')
                            <li class="nav-item {{ request()->is('admin/product') || request()->is('admin/product') ? 'active' : '' }}">
                                <a href="{{ route("admin.product.index") }}" class="nav-link">
                                    <i class="fa-fw fas fa-briefcase"></i>
                                    <span>Products</span>
                                </a>
                            </li>
                        @endcan

                        @can('category_access')
                            <li class="nav-item {{ request()->is('admin/categories') || request()->is('admin/categories') ? 'active' : '' }}">
                                <a href="{{ route("admin.categories.index") }}" class="nav-link {{-- {{ request()->is('categories') || request()->is('admin/categories/*') ? 'active' : '' }} --}}">
                                   <i class="fab fa-product-hunt"></i>
                                    <span>Product Category</span>
                                </a>
                            </li>
                        @endcan
                        
                        <li class="nav-item {{ request()->is('admin/attribute') || request()->is('admin/attribute') ? 'active' : '' }}">
                            <a href="{{ url("admin/attribute") }}" class="nav-link">
                                <i class="fa fa-archive"></i>
                                <span>Attributes</span>
                            </a>
                        </li>                        
                    </ul>
                </div>
            </li>
            @endcan
            @can('order_management')
            <li class="nav-item has-treeview {{ request()->is('admin/permissions/*') ? 'menu-open' : '' }} {{ request()->is('admin/roles/*') ? 'menu-open' : '' }} {{ request()->is('admin/order/*') ? 'menu-open' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#order_management">
                    <i class="fas fa-luggage-cart"></i>
                    <p>
                        <span>Order</span>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="order_management">
                    <ul class="nav">
                        @can('order_access')
                            <li class="nav-item {{ request()->is('admin/order') || request()->is('admin/order') ? 'active' : '' }}">
                                <a href="{{ route("admin.order.index") }}" class="nav-link {{-- {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }} --}}">
                                    <i class="fas fa-cart-arrow-down"></i>
                                    <span>Manage Order</span>
                                </a>
                            </li>
                        @endcan
                        @can('order_return_access')
                        <li class="nav-item {{ request()->is('admin/order-return') || request()->is('admin/order-return') ? 'active' : '' }}">
                            <a href="{{ route("admin.order-return") }}" class="nav-link {{-- {{ request()->is('admin/order-return') || request()->is('admin/order-return/*') ? 'active' : '' }} --}}">
                                <i class="fas fa-people-carry"></i>
                                <span>Order Return</span>
                            </a>
                        </li>
                    @endcan
                   </ul>
                </div>
            </li>
            @endcan
         @can('page_management')
            <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/page*') ? 'menu-open' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#page_management">
                    <i class="fas fa-file-alt"></i>
                    <p>
                        <span>Pages</span>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="page_management">
                    <ul class="nav">
                        @can('page_access')
                            <li class="nav-item {{ request()->is('admin/pages') || request()->is('admin/pages') ? 'active' : '' }}">
                                <a href="{{ route("admin.pages.index") }}" class="nav-link {{-- {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }} --}}">
                                   <i class="far fa-file-alt"></i>
                                    <span>Static Pages</span>
                                </a>
                            </li>
                        @endcan
                           @can('page_access')
                            <li class="nav-item {{ request()->is('admin/load-page') || request()->is('admin/load-page') ? 'active' : '' }}">
                                <a href="{{ route("admin.load-page") }}" class="nav-link {{-- {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }} --}}">
                                   <i class="far fa-file-alt"></i>
                                    <span>Home Page</span>
                                </a>
                            </li>
                        @endcan
                      
                    </ul>
                </div>
            </li>
            @endcan
           @can('setting_management')
            <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/page*') ? 'menu-open' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#setting_management">
                     <i class="fas fa-cogs"></i>
                    <p>
                        <span>Setting</span>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="setting_management">
                    <ul class="nav">
                        <li class="nav-item {{ request()->is('admin/menu') || request()->is('admin/menu') ? 'active' : '' }}">
                            <a href="{{ url('admin/menu') }}" class="nav-link">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                                <span>Menu</span>
                            </a>
                        </li>
                        @can('setting_access')
                            <li class="nav-item {{ request()->is('admin/setting') || request()->is('admin/setting') ? 'active' : '' }}">
                                <a href="{{ route("admin.setting.index") }}" class="nav-link {{-- {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }} --}}">
                               <i class="fas fa-cog"></i>
                                    <span>Site Setting</span>
                                </a>
                            </li>
                        @endcan
                        @can('product_access')
                        <li class="nav-item {{ request()->is('admin/mail-template') || request()->is('admin/mail-template') ? 'active' : '' }}">
                            <a href="{{ route("admin.mail-template.index") }}" class="nav-link {{-- {{ request()->is('admin/home') || request()->is('admin/home/*') ? 'active' : '' }} --}}">
                                <i class="fas fa-mail-bulk"></i>
                                <span>Mail Template</span>
                            </a>
                        </li>
                    @endcan
                   </ul>
                </div>
            </li>
            @endcan
            
            @can('user_management_access')
                <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#user_management">
                        <i class="fa-fw fas fa-users"></i>
                        <p>
                            <span>{{ trans('cruds.userManagement.title') }}</span>
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse " id="user_management">
                        <ul class="nav">
                            @can('permission_access')
                                <li class="nav-item {{ request()->is('admin/permissions') || request()->is('admin/permissions') ? 'active' : '' }}">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{-- {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }} --}}">
                                        <i class="fa-fw fas fa-unlock-alt"></i>
                                       <span>{{ trans('cruds.permission.title') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item {{ request()->is('admin/roles') || request()->is('admin/roles') ? 'active' : '' }}">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{-- {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }} --}}">
                                        <i class="fa-fw fas fa-briefcase"></i>
                                        <span>{{ trans('cruds.role.title') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item {{ request()->is('admin/users') || request()->is('admin/users') ? 'active' : '' }}">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{-- {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }} --}}">
                                        <i class="fa-fw fas fa-user">
                                       </i><span>{{ trans('cruds.user.title') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <p>
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>{{ trans('global.logout') }}</span>
                    </p>
                </a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
