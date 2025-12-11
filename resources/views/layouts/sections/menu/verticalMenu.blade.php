@php
$configData = Helper::appClasses();
$isAdmin = auth('web')->user()->hasRole('admin');
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  @if(!isset($navbarFull))
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        @include('_partials.macros',["height"=>20])
      </span>
      <span class="app-brand-text demo menu-text fw-bold">AHES Admin Panel</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>
  @endif


  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-item {{ Helper::menuIsActive(['dashboard']) }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div>Dashboard</div>
      </a>
    </li>

    @if($isAdmin || auth('web')->user()->hasPermission(['user-roles-create',
    'user-roles-read',
    'user-roles-update', 'user-roles-delete']))

    <li class="menu-item {{ Helper::menuIsOpen(['roles.create', 'roles.index', 'roles.edit']) }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-shield-cog"></i>
        <div>Access Roles</div>
      </a>
      <ul class="menu-sub">
        @if($isAdmin || auth('web')->user()->hasPermission(['user-roles-create']))
        <li class="menu-item {{ Helper::menuIsActive(['roles.create']) }}">
          <a href="{{ route('roles.create') }}" class="menu-link">
            <div>New Role</div>
          </a>
        </li>
        @endif

        @if($isAdmin || auth('web')->user()->hasPermission(['user-roles-read']))
        <li class="menu-item {{ Helper::menuIsActive(['roles.index']) }}">
          <a href="{{ route('roles.index') }}" class="menu-link">
            <div>Role List</div>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif

    @if($isAdmin || auth('web')->user()->hasPermission(['user-users-create',
    'user-users-read',
    'user-users-update', 'user-users-delete']))

    <li
      class="menu-item {{ Helper::menuIsOpen(['users.create', 'users.index', 'users.edit', 'users.show', 'users.updatePassword']) }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div>Users</div>
      </a>
      <ul class="menu-sub">
        @if($isAdmin || auth('web')->user()->hasPermission(['user-users-create']))
        <li class="menu-item {{ Helper::menuIsActive(['users.create']) }}">
          <a href="{{ route('users.create') }}" class="menu-link">
            <div>New User</div>
          </a>
        </li>
        @endif

        @if($isAdmin || auth('web')->user()->hasPermission(['user-users-read']))
        <li class="menu-item {{ Helper::menuIsActive(['users.index']) }}">
          <a href="{{ route('users.index') }}" class="menu-link">
            <div>User List</div>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Settings</span>
    </li>
    @if($isAdmin || auth('web')->user()->hasPermission(['user-site-settings']))
    <li class="menu-item {{ Helper::menuIsActive(['site-settings.index']) }}">
      <a href="{{ route('site-settings.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-settings"></i>
        <div>Site Settings</div>
      </a>
    </li>
    @endif

  </ul>
</aside>
