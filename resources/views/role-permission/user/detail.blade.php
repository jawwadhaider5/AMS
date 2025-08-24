@extends('backend_app.layouts.template')
@section('content')


@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">User Detail</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Users</a></li>
          <li class="breadcrumb-item active">All</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">User / View /</span> Account</h4>
    <div class="row">
      <!-- User Sidebar -->
      <div class="col-xl-8 col-lg-6 col-md-6 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="user-avatar-section">
              <div class="d-flex align-items-center flex-column">
                <img
                  class="img-fluid rounded mb-3 pt-1 mt-4"
                  src="{{ asset('assets/users/' . $user->img) }}" onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT45gcJLX6J9Wlyr4rFHA3beqZJbTyCvo_0whWJegVnZQ&s'"
                  height="100px"
                  width="100px"
                  alt="User avatar" />
                <div class="user-info text-center">
                  <h4 class="mb-2">{{$user->name}}</h4>
                  <span class="badge bg-label-secondary mt-1 text-capitalize">{{$user->roles->first()->name}}</span>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">

            </div>
            <p class="mt-4 small text-uppercase text-muted">Details</p>
            <div class="info-container">
              <ul class="list-unstyled">
                <li class="mb-2">
                  <span class="fw-medium me-1">Username:</span>
                  <span>{{$user->name}}</span>
                </li>
                <li class="mb-2 pt-1">
                  <span class="fw-medium me-1">Email:</span>
                  <span>{{$user->email}}</span>
                </li>
                <li class="mb-2 pt-1">
                  <span class="fw-medium me-1">Status:</span>
                  <span class="badge bg-label-success">Active</span>
                </li>
                <li class="mb-2 pt-1">
                  <span class="fw-medium me-1">Role:</span>
                  <span>{{$user->roles->first()->name}}</span>
                </li>
                <!-- <li class="mb-2 pt-1">
                          <span class="fw-medium me-1">Contact:</span>
                          <span>{{$user->phone_no}}</span>
                        </li>
                        <li class="mb-2 pt-1">
                          <span class="fw-medium me-1">Address:</span>
                          <span>{{$user->address}}</span>
                        </li>
                        <li class="pt-1">
                          <span class="fw-medium me-1">Country:</span>
                          <span>{{$user->country}}</span>
                        </li> -->
              </ul>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>


@endsection