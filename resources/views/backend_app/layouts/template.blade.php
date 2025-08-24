<!DOCTYPE html>

<html lang="en" class="default-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>{{meta_title()}}</title>

  <meta name="description" content="{{meta_description()}}" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/x-icon" href="{{asset('assets/fav_icon/'.fav_icon())}}" />
  <link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.css">

   <!-- Select2 -->
   <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">


  <style>
    body {
      font-size: 12px;
    }

    a {
      text-decoration: none;
    }
  </style>
</head>


<body class="hold-transition sidebar-mini layout-fixed @if(Route::currentRouteName()==='system_dashboard' || Route::currentRouteName()==='asset-category-edit' || Route::currentRouteName()==='asset-subcategory-edit' ) sidebar-open @endif">
  <div class="wrapper">
    @php
    $currentRouteName = Route::currentRouteName();
    $isSaveSystemTypeId = 'false';
    if ( $currentRouteName == 'save-systemtype-id' ) {
    $isSaveSystemTypeId = 'true';
    }
    @endphp

    <?php

    use App\Models\Category;
    use App\Models\System;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $systemtypes = System::with('systemtype')->get();
    $categories = Category::with('subcategories')->get();
    ?>



    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark"
      @if(Route::currentRouteName()==='system_dashboard' || Route::currentRouteName()==='asset-category-edit' || Route::currentRouteName()==='asset-subcategory-edit' ) style="margin-left: 250px;" @else style="margin-left: 0px;" @endif>
      <!-- Left navbar links -->

      <ul class="navbar-nav  
      @if(Route::currentRouteName() === 'system_dashboard' || Route::currentRouteName()==='asset-category-edit' || Route::currentRouteName()==='asset-subcategory-edit') d-m-block @else d-md-none @endif">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav mx-auto">

        @can('view dashboard')
        <li class="nav-item d-none d-md-block d-lg-block">
          <a class="btn btn-lg btn-primary mx-1" href="{{route('dashboard')}}">
            Dashboard
          </a>
        </li>
        @endcan
        @can('all spread')
        <li class="nav-item {{ Request::is('system/all') ? 'active' : '' }} d-none d-md-block d-lg-block">
          <a class="btn btn-lg btn-primary mx-1" href="{{route('all-system')}}">
            Spread
          </a>
        </li>
        @endcan
        @can('all system')
        <li class="nav-item {{ Request::is('spreadcategory/all') ? 'active' : '' }} d-none d-md-block d-lg-block">
          <a class="btn btn-lg btn-primary mx-1" href="{{route('all-spreadcategory')}}">
            System
          </a>
        </li>
        @endcan

        @can('all spare')
        <li class="nav-item {{ Request::is('spares/all') ? 'active' : '' }} d-none d-md-block d-lg-block">
          <a class="btn btn-lg btn-primary mx-1" href="{{route('all-spares')}}">
            Spares
          </a>
        </li>
        @endcan

        @can('all asset')
          <li class="nav-item nav-item {{ Request::is('assets/all') ? 'active' : '' }} d-none d-md-block d-lg-block">
            <a class="btn btn-lg btn-primary mx-1" href="{{route('all-assets')}}">
              All Assets 
            </a>
          </li>
          @endcan


        <li class="nav-item {{ Request::is('category/all') ? 'active' : '' }}  dropdown d-none d-md-block d-lg-block">
          <a class="btn btn-lg btn-primary mx-1 dropdown-toggle" href="#" data-toggle="dropdown">
            More
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @can('all qurantine')
            <a href="{{route('qurantine')}}" class="menu-link dropdown-item {{ Request::is('qurantine') ? 'active' : '' }}">
              <div>Qurantines</div>
            </a>
            @endcan
            @can('all maintenance')
            <a href="{{route('maintenace')}}" class="menu-link dropdown-item  {{ Request::is('maintenace') ? 'active' : '' }}">
              <div>Maintenance</div>
            </a>
            @endcan
            @can('all location')
            <a href="{{route('all-locations')}}" class="menu-link dropdown-item  {{ Request::is('location/all') ? 'active' : '' }}">
              <div>Locations</div>
            </a>
            @endcan
            @can('all project')
            <a href="{{route('all-projects')}}" class="menu-link dropdown-item  {{ Request::is('project/all') ? 'active' : '' }}">
              <div>Projects</div>
            </a>
            @endcan
          </div>
        </li>
        @can('advance')
        <li class="nav-item dropdown d-none d-md-block d-lg-block">
          <a class="btn btn-lg btn-primary mx-1 dropdown-toggle" href="#" data-toggle="dropdown">
            Advance Options
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @can('all spread type')
            <a href="{{route('all-systemtype')}}" class="menu-link dropdown-item {{ Request::is('systemtype/all') ? 'active' : '' }}">
              <p>IMCA Audit Type</p>
            </a>
            @endcan
            @can('all pre define task')
            <a href="{{route('all-pretask')}}" class="menu-link dropdown-item  {{ Request::is('pretask/all') || Request::is('pretask/add') ? 'active' : '' }}">
              <p>
                Predefined Task
              </p>
            </a>
            @endcan
            @can('all role')
            <a href="{{route('roles.index')}}" class="menu-link dropdown-item  {{ Request::is('roles') ? 'active' : '' }}">
              <p>Roles</p>
            </a>
            @endcan
            @can('all user')
            <a href="{{route('users.index')}}" class="menu-link dropdown-item  {{ Request::is('users') ? 'active' : '' }}">
              <p>Users</p>
            </a>
            @endcan
            @can('setting')
            <a href="{{route('setting')}}" class="menu-link dropdown-item  {{ Request::is('setting') ? 'active' : '' }}">
              <p>Settings</p>
            </a>
            @endcan
          </div>
        </li>
        @endcan

      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown d-none d-md-block d-lg-block d-sm-block d-xs-block">

          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user " style="font-size: 30px; width: 80px"></i>
          </a>

          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> {{$user->name}}
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('edit_profile')}}">
              <i class="fa fa-user"></i>
              <span class="align-middle">My Profile</span>
            </a>
            @can('setting')
            <a class="dropdown-item" href="{{route('setting')}}">
              <i class="fa fa-cog"></i>
              <span class="align-middle">Settings</span>
            </a>
            @endcan
            <a class="dropdown-item" href="{{route('logout')}}">
              <i class="fas fa-sign-out-alt"></i>
              <span class="align-middle">Log Out</span>
            </a>
          </div>
        </li>
        <li class="nav-item d-md-none d-none d-sm-block d-xs-block">
          <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary bg-dark elevation-4 @if(Route::currentRouteName() === 'system_dashboard' || Route::currentRouteName()==='asset-category-edit' || Route::currentRouteName()==='asset-subcategory-edit') d-block @else d-none @endif">

      <!-- Brand Logo -->
      <a href="/" class="brand-link ">
        <img src="{{asset('assets/logo/1.jpeg')}}" alt="NDE" class="brand-image elevation-3 " style="opacity: .8; width: 150px; margin-left: 35px;">
      </a>


      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('assets/logo/1.jpeg')}}" class="img-circle elevation-2" alt="NDE">
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">

          <select id="select2Basic" class="select2 form-select form-select-lg form-control form-control-sidebar" data-allow-clear="true">
            @foreach ($systemtypes as $systemtype)
            <option value="{{$systemtype->id}}">{{$systemtype->system_name}} - {{$systemtype->systemtype->name}}</option>
            @endforeach
          </select>

        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2 ">
          <ul id="menuContainer" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


          </ul>
        </nav>

        <!-- /.sidebar-menu -->



        <!-- Sidebar Menu -->
        <!-- <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
 

            <li class="nav-header">Advance Option</li>
            <li class="nav-item ">
              <a class=" nav-link {{ Request::is('systemtype/all') || Request::is('category/all') || Request::is('subcategory/all') ? 'open' : '' }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>Spread Type<i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                @can('all spread type')
                <li class="nav-item ">
                  <a href="{{route('all-systemtype')}}" class="nav-link {{ Request::is('systemtype/all') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Spread Types</p>
                  </a>
                </li>
                @endcan
                @can('all component')
                <li class="nav-item ">
                  <a href="{{route('all-category')}}" class="nav-link {{ Request::is('category/all') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Components</p>
                  </a>
                </li>
                @endcan
                @can('all sub component')
                <li class="nav-item ">
                  <a href="{{route('all-subcategory')}}" class="nav-link {{ Request::is('subcategory/all') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sub Components</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>



            @can('all task type')
            <li class="nav-item">
              <a href="{{route('all-tasktype')}}" class="nav-link  {{ Request::is('tasktype/all') ||  Request::is('tasktype/add') ? 'active' : '' }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Task Type
                </p>
              </a>
            </li>
            @endcan

            @can('all pre define task')
            <li class="nav-item ">
              <a href="{{route('all-pretask')}}" class="nav-link {{ Request::is('pretask/all') || Request::is('pretask/add') ? 'active' : '' }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Predefined Task
                </p>
              </a>
            </li>
            @endcan
            @can('all imca reference')
            <li class="nav-item ">
              <a href="{{route('all-imca')}}" class="nav-link {{ Request::is('imca/all') || Request::is('imca/add') ? 'active' : '' }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  IMCA Reference
                </p>
              </a>
            </li>
            @endcan

            @can('roles and permission')
            <li class="nav-item ">
              <a class=" nav-link ">

                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Roles & Permissions
                  <i class="fas fa-angle-left right"></i>
                </p>

              </a>
              <ul class="nav nav-treeview">
                @can('all role')
                <li class="nav-item ">
                  <a href="{{route('roles.index')}}" class="nav-link {{ Request::is('roles') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Roles</p>
                  </a>
                </li>
                @endcan
                @can('all permission')
                <li class="nav-item ">
                  <a href="{{route('permissions.index')}}" class="nav-link {{ Request::is('permissions') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Permissions</p>
                  </a>
                </li>
                @endcan
                @can('all user')
                <li class="nav-item ">
                  <a href="{{route('users.index')}}" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            @endcan

            <li class="nav-item ">
              <a href="{{route('edit_profile')}}" class="nav-link {{ Request::is('edit-profile') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Edit Profile</p>
              </a>
            </li>


            @can('setting')
            <li class="nav-item">
              <a href="{{route('setting')}}" class="nav-link {{ Request::is('setting') ? 'active' : '' }}">
                <i class="nav-icon tf-icons ti ti-settings"></i>
                <i class="far fa-circle nav-icon"></i>
                <p>Settings</p>
              </a>
            </li>
            @endcan

          </ul>
        </nav> -->
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" @if(Route::currentRouteName()==='system_dashboard' || Route::currentRouteName()==='asset-category-edit' || Route::currentRouteName()==='asset-subcategory-edit' ) style="margin-left: 250px;" @else style="margin-left: 0px;" @endif>

      @if(session('success'))
      <div id="success">
        <div class="alert alert-success d-flex align-items-center" style="top: 110px; position: fixed; width: 27%; z-index: 9999; right: 25px;" role="alert">
          <span class="alert-icon text-success me-2">
            <i class="ti ti-check ti-xs"></i>
          </span>
          {{ session('success') }}
        </div>
      </div>
      @endif
      @if(session('error'))
      <div id="error">
        <div class="alert alert-danger d-flex align-items-center" style="top: 110px;  position: fixed; width: 27%; z-index: 9999; right: 25px;" role="alert">
          <span class="alert-icon text-danger me-2">
            <i class="ti ti-ban ti-xs"></i>
          </span>
          {{ session('error') }}
        </div>
      </div>
      @endif



      @yield('head')
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- Main row -->
          <div class="row">

            @yield('content')

          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <!-- Control Sidebar -->
    <!-- <aside class="control-sidebar control-sidebar-dark">

      <nav class="mt-2 p-2">
        <ul class="navbar-nav ml-auto nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          @can('view dashboard')
          <li class="nav-item">
            <a class="nav-link  dropdown-item" href="{{route('dashboard')}}">
              <div class="text-white" style="font-size: 16px;">Dashboard</div>
            </a>
          </li>
          @endcan
          @can('all spread')
          <li class="nav-item {{ Request::is('system/all') ? 'active' : '' }}">
            <a class="nav-link  dropdown-item" href="{{route('all-system')}}">
              <div class="text-white" style="font-size: 16px;">Spread</div>
            </a>
          </li>
          @endcan
          @can('all system')
          <li class="nav-item {{ Request::is('spreadcategory/all') ? 'active' : '' }}">
            <a class="nav-link  dropdown-item" href="{{route('all-spreadcategory')}}">
              <div class="text-white" style="font-size: 16px;">System</div>
            </a>

          </li>
          @endcan

          @can('all asset')
          <li class="nav-item">
            <a class="nav-link dropdown-item {{ Request::is('assets/all') ? 'active' : '' }}" href="{{route('all-assets')}}">
              <div class="text-white" style="font-size: 16px;">All Assets</div>
            </a>
          </li>
          @endcan
          @can('create asset')
          <li class="nav-item">
            <a class="nav-link dropdown-item {{ Request::is('assets/add') ? 'active' : '' }}" href="{{route('add-assets')}}">
              <div class="text-white" style="font-size: 16px;">Add Asset</div>
            </a>
          </li>
          @endcan

          @can('all spare')
          <li class="nav-item {{ Request::is('spares/all') ? 'active' : '' }}">
            <a class="nav-link  dropdown-item" href="{{route('all-spares')}}">
              <div class="text-white" style="font-size: 16px;">Spares</div>
            </a>
          </li>
          @endcan

          @can('all components')
          <li class="nav-item">
            <a class="nav-link dropdown-item {{ Request::is('category/all') ? 'active' : '' }}" href="{{route('all-category')}}">
              <div class="text-white" style="font-size: 16px;">All Components</div>
            </a>
          </li>
          @endcan
          @can('all sub components')
          <li class="nav-item">
            <a class="nav-link dropdown-item {{ Request::is('subcategory/all') ? 'active' : '' }}" href="{{route('all-subcategory')}}">
              <div class="text-white" style="font-size: 16px;">All Sub Components</div>
            </a>
          </li>
          @endcan

          @can('all qurantine')
          <li class="nav-item">
            <a href="{{route('qurantine')}}" class="nav-link dropdown-item {{ Request::is('qurantine') ? 'active' : '' }}">
              <div class="text-white" style="font-size: 16px;">Qurantines</div>
            </a>
          </li>
          @endcan
          @can('all maintenance')
          <li class="nav-item">
            <a href="{{route('maintenace')}}" class="nav-link dropdown-item  {{ Request::is('maintenace') ? 'active' : '' }}">
              <div class="text-white" style="font-size: 16px;">Maintenance</div>
            </a>
          </li>
          @endcan
          @can('all location')
          <li class="nav-item">
            <a href="{{route('all-locations')}}" class="nav-link dropdown-item  {{ Request::is('location/all') ? 'active' : '' }}">
              <div class="text-white" style="font-size: 16px;">Locations</div>
            </a>
          </li>
          @endcan
          @can('all project')
          <li class="nav-item">
            <a href="{{route('all-projects')}}" class="nav-link dropdown-item  {{ Request::is('project/all') ? 'active' : '' }}">
              <div class="text-white" style="font-size: 16px;">Projects</div>
            </a>
          </li>
          @endcan

        </ul>

      </nav>
    </aside> -->
    <!-- /.control-sidebar -->


    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2025 <a href="#">NDE</a>.</strong>
      All rights reserved.
    </footer>


  </div>
 

  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.js"></script>
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>


  <script>
    $(document).ready(function() {

      setTimeout(function() {
        $("#success").hide();
      }, 3000);

      setTimeout(function() {
        $("#error").hide();
      }, 3000);

      $('#select2Basic').select2();

      function getSessionSystemTypeId() {
        var systemtypeId = 1;
        $.ajax({
          url: '/get-systemtype-id',
          method: 'GET',
          async: false,
          success: function(response) {
            if (response.systemtype_id !== null) {
              systemtypeId = response.systemtype_id;
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });
        return systemtypeId;
      }

      var systemtypeId = getSessionSystemTypeId();
      $('#select2Basic').val(systemtypeId).trigger('change');

      loadCategories(systemtypeId);

      $('#select2Basic').on('change', function() {

        systemtypeId = $(this).val();

        $.ajax({
          url: '/set-systemtype-id',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            systemtype_id: systemtypeId
          },
          success: function(response) {
            window.location.reload();
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });


      });

      function loadCategories(systemtypeId) {
        $.ajax({
          url: '/categories-update',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            systemtype_id: systemtypeId
          },
          success: function(response) {

            if (response.success) {
              updateCategories(response.categories);
            } else {
              console.error('Error fetching categories');
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });
      }


      // @can('all task type')
      //       <li class="nav-item">
      //         <a href="{{route('all-tasktype')}}" class="nav-link  {{ Request::is('tasktype/all') ||  Request::is('tasktype/add') ? 'active' : '' }}">
      //           <i class="nav-icon fas fa-copy"></i>
      //           <p>
      //             Task Type
      //           </p>
      //         </a>
      //       </li>
      //       @endcan
      // @can('all imca reference')
      //       <li class="nav-item ">
      //         <a href="{{route('all-imca')}}" class="nav-link {{ Request::is('imca/all') || Request::is('imca/add') ? 'active' : '' }}">
      //           <i class="nav-icon fas fa-copy"></i>
      //           <p>
      //             IMCA Reference
      //           </p>
      //         </a>
      //       </li>
      //       @endcan
      // @can('all permission')
      //           <li class="nav-item ">
      //             <a href="{{route('permissions.index')}}" class="nav-link {{ Request::is('permissions') ? 'active' : '' }}">
      //               <i class="far fa-circle nav-icon"></i>
      //               <p>Permissions</p>
      //             </a>
      //           </li>
      //           @endcan
      // @can('all component')
      //           <li class="nav-item ">
      //             <a href="{{route('all-category')}}" class="nav-link {{ Request::is('category/all') ? 'active' : '' }}">
      //               <i class="far fa-circle nav-icon"></i>
      //               <p>All Components</p>
      //             </a>
      //           </li>
      //           @endcan
      //           @can('all sub component')
      //           <li class="nav-item ">
      //             <a href="{{route('all-subcategory')}}" class="nav-link {{ Request::is('subcategory/all') ? 'active' : '' }}">
      //               <i class="far fa-circle nav-icon"></i>
      //               <p>Sub Components</p>
      //             </a>
      //           </li>
      //           @endcan


      function updateCategories(categories) {
        var menuContainer = $('#menuContainer');
        menuContainer.empty();
        var currentUrl = window.location.pathname;

        var urlcat = {!!json_encode(isset($urlcat) ? $urlcat : '') !!};
        var urlsubcat = {!!json_encode(isset($urlsubcat) ? $urlsubcat : '') !!};

        var othermenu = ` <li class="nav-header">Advance Option</li>
            <li class="nav-item ">
              <a class=" nav-link {{ Request::is('systemtype/all') || Request::is('category/all') || Request::is('subcategory/all') ? 'open' : '' }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>Spread Type<i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                @can('all spread type')
                <li class="nav-item ">
                  <a href="{{route('all-systemtype')}}" class="nav-link {{ Request::is('systemtype/all') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Spread Types</p>
                  </a>
                </li>
                @endcan
              
              </ul>
            </li>



            

            @can('all pre define task')
            <li class="nav-item ">
              <a href="{{route('all-pretask')}}" class="nav-link {{ Request::is('pretask/all') || Request::is('pretask/add') ? 'active' : '' }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Predefined Task
                </p>
              </a>
            </li>
            @endcan
            

            @can('roles and permission')
            <li class="nav-item ">
              <a class=" nav-link ">

                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Roles & Permissions
                  <i class="fas fa-angle-left right"></i>
                </p>

              </a>
              <ul class="nav nav-treeview">
                @can('all role')
                <li class="nav-item ">
                  <a href="{{route('roles.index')}}" class="nav-link {{ Request::is('roles') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Roles</p>
                  </a>
                </li>
                @endcan
               
                @can('all user')
                <li class="nav-item ">
                  <a href="{{route('users.index')}}" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            @endcan

            <li class="nav-item ">
              <a href="{{route('edit_profile')}}" class="nav-link {{ Request::is('edit-profile') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Edit Profile</p>
              </a>
            </li>


            @can('setting')
            <li class="nav-item">
              <a href="{{route('setting')}}" class="nav-link {{ Request::is('setting') ? 'active' : '' }}">
                <i class="nav-icon tf-icons ti ti-settings"></i>
                <i class="far fa-circle nav-icon"></i>
                <p>Settings</p>
              </a>
            </li>
            @endcan`;



        categories.forEach(function(category) {

          var isCategoryOpen = category.subcategories.some(function(subcategory) {
            return currentUrl.includes('/assets/subcategory/' + subcategory.id);
          })
          var CategoryOpen = currentUrl.includes('/assets/category/' + category.id) || (category.id == urlcat);

          var categoryItem = $('<li >').addClass('nav-item' + ((isCategoryOpen || CategoryOpen ) ? ' menu-is-opening menu-open ' : ''));
          var categoryLink = $('<a>').addClass('nav-link' + ((isCategoryOpen || CategoryOpen ) ? ' active' : '')).attr('href', '#')
            .append('<i class="nav-icon fas fa-copy"></i>')
            .append('<p title="' + category.name + '">' + category.name.substring(0, 30) + '<i class="fas fa-angle-left right"></i></p>');
          categoryItem.append(categoryLink);

          var subcategoryList = $('<ul>').addClass('nav nav-treeview');
          category.subcategories.forEach(function(subcategory) {
            var baseUrl = window.location.protocol + '//' + window.location.host + '/';
            var subcategoryUrl = baseUrl + 'assets/subcategory/' + subcategory.id;
            var isSubcategoryActive = currentUrl.includes('/assets/subcategory/' + subcategory.id) || (subcategory.id == urlsubcat);

            var subcategoryItem = $('<li>').addClass('nav-item');
            var subcategoryLink = $('<a>').addClass('nav-link' + ((isSubcategoryActive) ? ' active' : '')).attr('href', subcategoryUrl)
              .append('<i class="far fa-circle nav-icon"></i>')
              .append('<p title="' + subcategory.name + '">' + subcategory.name.substring(0, 30) + '</p>')
              .append('<span class="badge badge-info right">(' + subcategory.assetCount + ')</span>');
            subcategoryItem.append(subcategoryLink);
            subcategoryList.append(subcategoryItem);
          });

          categoryItem.append(subcategoryList);
          menuContainer.append(categoryItem);
        });

        //menuContainer.append(othermenu);

      }

    });
  </script>

  @yield('script')
  @stack('scripts')

</body>

</html>