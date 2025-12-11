@php
$configData = Helper::appClasses();
$isAdmin = auth('admin')->user()->hasRole('admin');
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  @if(!isset($navbarFull))
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        @include('_partials.macros',["height"=>20])
      </span>
      <!-- AHES -->
      <span class="app-brand-text demo menu-text fw-bold">Ahes Admin</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>
  @endif


  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-item {{ Helper::menuIsActive(['admin.dashboard']) }}">
      <a href="{{ route('admin.dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div>Dashboard</div>
      </a>
    </li>

    @if($isAdmin || auth('admin')->user()->hasPermission(['admin-roles-create',
    'admin-roles-read',
    'admin-roles-update', 'admin-roles-delete']))

    <li class="menu-item {{ Helper::menuIsOpen(['admin.roles.create', 'admin.roles.index', 'admin.roles.edit']) }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-shield-cog"></i>
        <div>Access Roles</div>
      </a>
      <ul class="menu-sub">
        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-roles-create']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.roles.create']) }}">
          <a href="{{ route('admin.roles.create') }}" class="menu-link">
            <div>New Role</div>
          </a>
        </li>
        @endif

        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-roles-read']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.roles.index']) }}">
          <a href="{{ route('admin.roles.index') }}" class="menu-link">
            <div>Role List</div>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif

    @if($isAdmin || auth('admin')->user()->hasPermission(['admin-admins-create',
    'admin-admins-read',
    'admin-admins-update', 'admin-admins-delete']))

    <li
      class="menu-item {{ Helper::menuIsOpen(['admin.admins.create', 'admin.admins.index', 'admin.admins.edit', 'admin.admins.show', 'admin.admins.updatePassword']) }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users-group"></i>
        <div>Admins</div>
      </a>
      <ul class="menu-sub">
        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-admins-create']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.admins.create']) }}">
          <a href="{{ route('admin.admins.create') }}" class="menu-link">
            <div>New Admin</div>
          </a>
        </li>
        @endif

        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-admins-read']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.admins.index']) }}">
          <a href="{{ route('admin.admins.index') }}" class="menu-link">
            <div>Admin List</div>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif

    @if($isAdmin || auth('admin')->user()->hasPermission(['admin-users-create',
    'admin-users-read',
    'admin-users-update', 'admin-users-delete']))

    <li
      class="menu-item {{ Helper::menuIsOpen(['admin.users.create', 'admin.users.index', 'admin.users.edit', 'admin.users.show', 'admin.users.updatePassword']) }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div>Users</div>
      </a>
      <ul class="menu-sub">
        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-users-create']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.users.create']) }}">
          <a href="{{ route('admin.users.create') }}" class="menu-link">
            <div>New User</div>
          </a>
        </li>
        @endif

        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-users-read']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.users.index']) }}">
          <a href="{{ route('admin.users.index') }}" class="menu-link">
            <div>User List</div>
          </a>
        </li>
        @endif
      </ul>
    </li>
    <li
      class="menu-item {{ Helper::menuIsOpen(['admin.users.create', 'admin.users.index', 'admin.users.edit', 'admin.users.show', 'admin.users.updatePassword']) }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div>Services</div>
      </a>
      <ul class="menu-sub">
        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-users-create']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.services.create']) }}">
          <a href="{{ route('admin.services.create') }}" class="menu-link">
            <div>New Service</div>
          </a>
        </li>
        @endif

        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-users-read']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.services.index']) }}">
          <a href="{{ route('admin.services.index') }}" class="menu-link">
            <div>Service List</div>
          </a>
        </li>
        @endif
      </ul>
    </li>
    <li
      class="menu-item {{ Helper::menuIsOpen(['admin.users.create', 'admin.users.index', 'admin.users.edit', 'admin.users.show', 'admin.users.updatePassword']) }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div>Why Points</div>
      </a>
      <ul class="menu-sub">
        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-users-create']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.why-points.create']) }}">
          <a href="{{ route('admin.why-points.create') }}" class="menu-link">
            <div>New Why Point</div>
          </a>
        </li>
        @endif

        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-users-read']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.why-points.index']) }}">
          <a href="{{ route('admin.why-points.index') }}" class="menu-link">
            <div>Why Point List</div>
          </a>
        </li>
        @endif
      </ul>
    </li>
    <li
      class="menu-item {{ Helper::menuIsOpen(['admin.users.create', 'admin.users.index', 'admin.users.edit', 'admin.users.show', 'admin.users.updatePassword']) }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div>Testimonials</div>
      </a>
      <ul class="menu-sub">
        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-users-create']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.testimonials.create']) }}">
          <a href="{{ route('admin.testimonials.create') }}" class="menu-link">
            <div>New Testimonials</div>
          </a>
        </li>
        @endif

        @if($isAdmin || auth('admin')->user()->hasPermission(['admin-users-read']))
        <li class="menu-item {{ Helper::menuIsActive(['admin.testimonials.index']) }}">
          <a href="{{ route('admin.testimonials.index') }}" class="menu-link">
            <div>Testimonials List</div>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Settings</span>
    </li>
    @if($isAdmin || auth('admin')->user()->hasPermission(['admin-site-settings']))
    <li class="menu-item {{ Helper::menuIsActive(['admin.site-settings.index']) }}">
      <a href="{{ route('admin.site-settings.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-settings"></i>
        <div>Site Settings</div>
      </a>
    </li>
    @endif

  </ul>
</aside>
