<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
          <a href="{{ route('home') }}">CAKE STORE</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">CS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}"><i class="fa fa-home">
                    </i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}"><i class="fa fa-user">
                    </i> <span>Users</span>
                </a>
            </li>
            <li class="{{ Request::is('products') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('products.index') }}"><i class="fa fa-store">
                    </i> <span>Products</span>
                </a>
            </li>
    </aside>
</div>
