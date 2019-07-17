<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip"
                       title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}
                    </a>
                </div>
            </div>
    @endif

    <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control"
                       placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i
                        class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('home') }}"><i class='glyphicon glyphicon-dashboard'></i>
                    <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class='glyphicon glyphicon-user'></i> <span>{{ trans('adminlte_lang::message.user') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/user/create')}}">Create</a></li>
                    <li><a href="{{url('/user/manage')}}">Manage Users</a></li>
                </ul>
            </li>
            <li>
                <a href="{{url('/brands')}}">
                    <i class='glyphicon glyphicon-tags'></i> <span>Brands</span>
                </a>
            </li>
            <li>
                <a href="{{url('/category')}}">
                    <i class='glyphicon glyphicon-duplicate'></i> <span>Category</span>
                </a>
            </li>
            <li>
                <a href="{{url('/location')}}">
                    <i class='glyphicon  glyphicon-map-marker'></i> <span>Locations</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#"><i class='glyphicon glyphicon-gift'></i> <span>Products</span>
                    <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/products/create')}}">Add Product</a></li>
                    <li><a href="{{url('/products')}}">Manege Product</a></li>
                </ul>
            </li>
            <li>
                <a href="{{url('')}}">
                    <i class='fa fa-truck'></i> <span>Supplier</span>
                </a>
            </li>
            <li>
                <a href="{{url('')}}">
                    <i class='glyphicon glyphicon-tasks'></i> <span>Purchase Order</span>
                </a>
            </li>
            <li>
                <a href="{{url('')}}">
                    <i class='glyphicon glyphicon-circle-arrow-down'></i> <span>Goods Received Note</span>
                </a>
            </li>
            <li>
                <a href="{{url('')}}">
                    <i class='glyphicon glyphicon-circle-arrow-up'></i> <span>Goods Transfer Note</span>
                </a>
            </li>
            <li>
                <a href="{{url('')}}">
                    <i class='glyphicon  glyphicon-map-marker'></i> <span>Invoice</span>
                </a>
            </li>
            <li>
                <a href="{{url('')}}">
                    <i class='glyphicon glyphicon-stats'></i> <span>Reports</span>
                </a>
            </li>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
