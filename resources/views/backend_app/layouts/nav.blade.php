@php
$user=Auth::user();
@endphp
<style>
  @media(max-width:768px) {

    .mob-view {
      margin-top: -39px !important;
    }
  }
</style>
@if(Route::currentRouteName() === 'dashboard')
<nav class="layout-navbar  container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme d-block" id="layout-navbar" style="background: #89CFF0!important;    left: 0px;
    width: 100%;">
  @else
  <nav class="layout-navbar  container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme d-block" id="layout-navbar" style="background: #89CFF0!important;">
    @endif

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="ti ti-menu-2 ti-sm"></i>
      </a>
    </div>
    @if(Route::currentRouteName() === 'dashboard')
    <div class="navbar-nav-right d-flex align-items-center justify-content-center" id="navbar-collapse">
      @else
      <div class="navbar-nav-right d-flex align-items-center justify-content-center" id="navbar-collapse">

        @endif
        @if(Route::currentRouteName() === 'dashboard')
        <ul class="navbar-nav flex-row align-items-center  mob-view">
          @else
          <ul class="navbar-nav flex-row align-items-center  mob-view">

            @endif

            @can('view dashboard')
            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow text-dark fw-bold" href="{{route('dashboard')}}" class="menu-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chart-pie">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M10 3.2a9 9 0 1 0 10.8 10.8a1 1 0 0 0 -1 -1h-6.8a2 2 0 0 1 -2 -2v-7a.9 .9 0 0 0 -1 -.8" />
                  <path d="M15 3.5a9 9 0 0 1 5.5 5.5h-4.5a1 1 0 0 1 -1 -1v-4.5" />
                </svg> Dashboard
              </a>
            </li>
            @endcan 
            @can('all spread')
            <li class="nav-item {{ Request::is('system/all') ? 'active' : '' }} me-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow text-dark fw-bold" href="{{route('all-system')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                  <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                </svg> Spread
              </a>
            </li>
            @endcan
            @can('all system')
            <li class="nav-item {{ Request::is('spreadcategory/all') ? 'active' : '' }}">
              <a class="nav-link dropdown-toggle hide-arrow text-dark fw-bold" href="{{route('all-spreadcategory')}}" class="menu-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chart-pie">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M10 3.2a9 9 0 1 0 10.8 10.8a1 1 0 0 0 -1 -1h-6.8a2 2 0 0 1 -2 -2v-7a.9 .9 0 0 0 -1 -.8" />
                  <path d="M15 3.5a9 9 0 0 1 5.5 5.5h-4.5a1 1 0 0 1 -1 -1v-4.5" />
                </svg> System
              </a>

            </li>
            @endcan

            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow text-dark fw-bold" href="javascript:void(0);" data-bs-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings-star">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M10.325 19.683a1.723 1.723 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572a1.67 1.67 0 0 1 1.106 .831" />
                  <path d="M14.89 11.195a3.001 3.001 0 1 0 -4.457 3.364" />
                  <path d="M17.8 20.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z" />
                </svg> Spread Assets
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                @can('all asset')
                <li class="dropdown-item {{ Request::is('assets/all') ? 'active' : '' }}">
                  <a href="{{route('all-assets')}}" class="menu-link">
                    <div>Spread Assets</div>
                  </a>
                </li>
                @endcan
                @can('create asset')
                <li class="dropdown-item  {{ Request::is('assets/add') ? 'active' : '' }}">
                  <a href="{{route('add-assets')}}" class="menu-link">
                    <div>Add Spread Assets</div>
                  </a>
                </li>
                @endcan
              </ul>
            </li> 
            @can('all spare')
            <li class="nav-item {{ Request::is('spares/all') ? 'active' : '' }} dropdown me-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow text-dark fw-bold" href="{{route('all-spares')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                  <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                </svg> Spares
              </a>

            </li>
            @endcan 
            <li class="nav-item {{ Request::is('category/all') ? 'active' : '' }} dropdown-language dropdown me-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow text-dark fw-bold" href="javascript:void(0);" data-bs-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-category">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M4 4h6v6h-6z" />
                  <path d="M14 4h6v6h-6z" />
                  <path d="M4 14h6v6h-6z" />
                  <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                </svg> Components
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                @can('all component')
                <li class="dropdown-item {{ Request::is('category/all') ? 'active' : '' }}">
                  <a href="{{route('all-category')}}" class="menu-link">
                    <div>All Components</div>
                  </a>
                </li>
                @endcan
                @can('all sub component')
                <li class="dropdown-item  {{ Request::is('subcategory/all') ? 'active' : '' }}">
                  <a href="{{route('all-subcategory')}}" class="menu-link">
                    <div>Sub Components</div>
                  </a>
                </li>
                @endcan
              </ul>
            </li>

            <li class="nav-item {{ Request::is('category/all') ? 'active' : '' }} dropdown-language dropdown me-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow text-dark fw-bold" href="javascript:void(0);" data-bs-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-category">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M4 4h6v6h-6z" />
                  <path d="M14 4h6v6h-6z" />
                  <path d="M4 14h6v6h-6z" />
                  <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                </svg> More
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                @can('all qurantine')
                <li class="dropdown-item {{ Request::is('qurantine') ? 'active' : '' }}">
                  <a href="{{route('qurantine')}}" class="menu-link">
                    <div>Qurantines</div>
                  </a>
                </li>
                @endcan
                @can('all maintenance')
                <li class="dropdown-item  {{ Request::is('maintenace') ? 'active' : '' }}">
                  <a href="{{route('maintenace')}}" class="menu-link">
                    <div>Maintenance</div>
                  </a>
                </li>
                @endcan
                @can('all location')
                <li class="dropdown-item  {{ Request::is('location/all') ? 'active' : '' }}">
                  <a href="{{route('all-locations')}}" class="menu-link">
                    <div>Locations</div>
                  </a>
                </li>
                @endcan
                @can('all project')
                <li class="dropdown-item  {{ Request::is('project/all') ? 'active' : '' }}">
                  <a href="{{route('all-projects')}}" class="menu-link">
                    <div>Projects</div>
                  </a>
                </li>
                @endcan
              </ul>
            </li>

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                  <img src="{{asset("assets/users/".$user->img )}}" alt class="h-auto rounded-circle" />
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                          <img src="{{asset("assets/users/".$user->img )}}" alt class="h-auto rounded-circle" />
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <span class="fw-medium d-block">{{$user->name}}</span>
                        <small class="text-muted">{{$user->role}}</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                </li>
                <li>
                  <a class="dropdown-item" href="{{route('edit_profile')}}">
                    <i class="ti ti-user-check me-2 ti-sm"></i>
                    <span class="align-middle">My Profile</span>
                  </a>
                </li>
                @can('setting')
                <li>
                  <a class="dropdown-item" href="{{route('setting')}}">
                    <i class="ti ti-settings me-2 ti-sm"></i>
                    <span class="align-middle">Settings</span>
                  </a>
                </li>
                @endcan


                <li>
                  <a class="dropdown-item" href="{{route('logout')}}">
                    <i class="ti ti-logout me-2 ti-sm"></i>
                    <span class="align-middle">Log Out</span>
                  </a>
                </li>
              </ul>
            </li> 
          </ul>
      </div>
 
      <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." />
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
      </div>
  </nav>