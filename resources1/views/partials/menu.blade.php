<!-- Sidebar -->
<div class="sidebar" data-color="orange" data-background-color="white">
    <!-- Brand Logo -->
    <div class="logo" style="background:#FFAC32">
        <a href="#" class="simple-text logo-normal">
            {{ trans('panel.site_title') }}
        </a>
    </div>
   <!-- Sidebar Menu -->
    <div class="sidebar-wrapper">
        <ul class="nav" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item active " style="background:#FFAC32; color:#fff !important">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <p>
                        <i class="fas fa-fw fa-tachometer-alt"> </i>
                        <span>{{ trans('global.dashboard') }}</span>
                    </p>
                </a>
            </li>
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
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-unlock-alt"></i>
                                       <span>{{ trans('cruds.permission.title') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-briefcase"></i>
                                        <span>{{ trans('cruds.role.title') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-user">
                                       </i><span>{{ trans('cruds.user.title') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan
            @can('product_setting')
            <li class="nav-item has-treeview {{ request()->is('admin/permissions/*') ? 'menu-open' : '' }} {{ request()->is('admin/roles/*') ? 'menu-open' : '' }} {{ request()->is('admin/category/*') ? 'menu-open' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#product_setting">
                    <i class="fas fa-screwdriver"></i>
                    <p>
                        <span>Product Setting</span>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="product_setting">
                    <ul class="nav">
                        @can('color_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.color.index") }}" class="nav-link {{ request()->is('admin/color') || request()->is('admin/color/*') ? 'active' : '' }}">
                                    <i class="fas fa-palette"></i>
                                    <span>Color Setting</span>
                                </a>
                            </li>
                        @endcan
                        @can('size_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.product-size-setting.index") }}" class="nav-link {{ request()->is('admin/product-size-setting') || request()->is('admin/product-size-setting/*') ? 'active' : '' }}">
                                    <i class="fas fa-ruler-combined"></i>
                                    <span>Product Size Varient </span>
                                </a>
                            </li>
                        @endcan
                        @can('size_value_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.product-size-value-setting.index") }}" class="nav-link {{ request()->is('admin/product-size-value-setting') || request()->is('admin/product-size-value-setting/*') ? 'active' : '' }}">
                                    <i class="fas fa-compass"></i>
                                    <span> Size Varient Value </span>
                                </a>
                            </li>
                        @endcan
                        @can('size_chart_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.product-size-chart.index") }}" class="nav-link {{ request()->is('admin/product-size-chart') || request()->is('admin/product-size-chart/*') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar"></i>
                                <span>Product Size Chart </span>
                            </a>
                        </li>
                    @endcan
                    @can('style_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.product-style-customization.index") }}" class="nav-link {{ request()->is('admin/product-style-customization') || request()->is('admin/product-style-customization/*') ? 'active' : '' }}">
                            <i class="fas fa-tshirt"></i>
                            <span> Style Customization </span>
                        </a>
                    </li>
                @endcan
                @can('measure_access')
                <li class="nav-item">
                    <a href="{{ route("admin.measurement-instruction.index") }}" class="nav-link {{ request()->is('admin/measurement-instruction') || request()->is('admin/measurement-instruction/*') ? 'active' : '' }}">
                        <i class="fas fa-drafting-compass"></i>
                        <span>Measurement Instruct. </span>
                    </a>
                </li>
            @endcan
            @can('tax_access')
            <li class="nav-item">
                <a href="{{ route("admin.tax.index") }}" class="nav-link {{ request()->is('admin/tax') || request()->is('admin/tax/*') ? 'active' : '' }}">
                    <i class="fas fa-industry"></i>
                    <span>Tax Setting</span>
                </a>
            </li>
             @endcan
             @can('zone_access')
             <li class="nav-item">
                 <a href="{{ route("admin.selling-zone.index") }}" class="nav-link {{ request()->is('admin/selling-zone') || request()->is('admin/selling-zone/*') ? 'active' : '' }}">
                    <i class="fab fa-shopware"></i>
                     <span>Selling Zone</span>
                 </a>
             </li>
              @endcan
              @can('brand_access')
              <li class="nav-item">
                  <a href="{{ route("admin.brand-setting.index") }}" class="nav-link {{ request()->is('admin/brand-setting') || request()->is('admin/brand-setting/*') ? 'active' : '' }}">
                      <i class="fab fa-bandcamp"></i>
                      <span>Product Brand </span>
                  </a>
              </li>
              @endcan
              @can('fabric_access')
              <li class="nav-item">
                  <a href="{{ route("admin.fabric-setting.index") }}" class="nav-link {{ request()->is('admin/fabric-setting') || request()->is('admin/fabric-setting/*') ? 'active' : '' }}">
                    <i class="fas fa-tshirt"></i>
                      <span>Dress Fabrics </span>
                  </a>
              </li>
              @endcan
              @can('prange_access')
              <li class="nav-item">
                  <a href="{{ route("admin.price-range.index") }}" class="nav-link {{ request()->is('admin/price-range') || request()->is('admin/price-range/*') ? 'active' : '' }}">
                    <i class="fas fa-sliders-h"></i>
                      <span>Price Range</span>
                  </a>
              </li>
              @endcan
                 </ul>
                </div>
            </li>
            @endcan
            @can('product_management')
            <li class="nav-item has-treeview {{ request()->is('admin/permissions/*') ? 'menu-open' : '' }} {{ request()->is('admin/roles/*') ? 'menu-open' : '' }} {{ request()->is('admin/category/*') ? 'menu-open' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#product_management">
                    <i class="fab fa-product-hunt"></i>
                    <p>
                        <span>Products</span>
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="product_management">
                    <ul class="nav">
                        @can('category_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.categories.index") }}" class="nav-link {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                                   <i class="fab fa-product-hunt"></i>
                                    <span>Product Category</span>
                                </a>
                            </li>
                        @endcan
                        @can('product_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.product.index") }}" class="nav-link {{ request()->is('admin/product') || request()->is('admin/product/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase"></i>
                                    <span>Products</span>
                                </a>
                            </li>
                        @endcan
                
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
                            <li class="nav-item">
                                <a href="{{ route("admin.order.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fas fa-cart-arrow-down"></i>
                                    <span>Manage Order</span>
                                </a>
                            </li>
                        @endcan
                        @can('order_return_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.order-return") }}" class="nav-link {{ request()->is('admin/order-return') || request()->is('admin/order-return/*') ? 'active' : '' }}">
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
                            <li class="nav-item">
                                <a href="{{ route("admin.pages.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                   <i class="far fa-file-alt"></i>
                                    <span>Static Pages</span>
                                </a>
                            </li>
                        @endcan
                           @can('page_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.load-page") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
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
                        @can('setting_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.setting.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                               <i class="fas fa-cog"></i>
                                    <span>Site Setting</span>
                                </a>
                            </li>
                        @endcan
                        @can('product_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.load-page") }}" class="nav-link {{ request()->is('admin/home') || request()->is('admin/home/*') ? 'active' : '' }}">
                                <i class="fas fa-mail-bulk"></i>
                                <span>Mail Template</span>
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
