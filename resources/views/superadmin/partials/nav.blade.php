<div class="sidebar">
    <h3>Super Admin</h3>

    <a href="{{ route('superadmin.dashboard') }}"
       class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
        Dashboard
    </a>

    <a href="{{ route('admins.index') }}"
       class="nav-link {{ request()->routeIs('admins.*') ? 'active' : '' }}">
        Admins
    </a>

    <a href="{{ route('fields.index') }}"
       class="nav-link {{ request()->routeIs('fields.*') ? 'active' : '' }}">
        Employee Fields
    </a>

    <a href="{{ route('blog-fields.index') }}"
       class="nav-link {{ request()->routeIs('blog-fields.*') ? 'active' : '' }}">
        Blog Fields
    </a>

    <a href="{{ route('blogs.index') }}"
       class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}">
        Blogs
    </a>

    <a href="{{ route('employees.index') }}"
   class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
   Employees
</a>

</div>
