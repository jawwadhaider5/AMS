@extends('backend_app.layouts.template')
@section('content')

<div class="layout-page">
    <!-- Navbar -->

 @include('backend_app.layouts.nav')

    <!-- / Navbar -->

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Customer /</span>{{$data->name}}</h4>

        <!-- Header -->
        <div class="row">
          <div class="col-12">
            <div class="card mb-4">
              <div class="user-profile-header-banner">
                <img src="https://img.freepik.com/premium-vector/abstract-sale-busioness-background-banner-design-multipurpose_1340-16819.jpg   " alt="Banner image" class="rounded-top" />
              </div>
              <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                  <img
                    src="{{asset('assets/img/avatars/avatar.png')}}"
                    alt="user image"
                    class="d-block h-auto ms-0 ms-sm-4 user-profile-img" />
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                  <div
                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                      <h4>{{$data->company}}</h4>
                      <ul
                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                        <li class="list-inline-item d-flex gap-1">
                          <i class="ti ti-color-swatch"></i> Customer
                        </li>
                        <li class="list-inline-item d-flex gap-1"><i class="ti ti-map-pin"></i> {{$data->address}}</li>
                        <li class="list-inline-item d-flex gap-1">
                          <i class="ti ti-calendar"></i> Joined: {{$data->created_at}}
                        </li>
                        <li class="list-inline-item d-flex gap-1">
                          <i class="ti ti-calendar"></i> Profile Updated: {{$data->updated_at}}
                        </li>
                      </ul>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-primary">
                      <i class="ti ti-check me-1"></i>Active
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--/ Header -->

        <!-- Navbar pills -->
        <div class="row">
          <div class="col-md-12">


          </div>
        </div>
        <!--/ Navbar pills -->

        <!-- User Profile Content -->
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-5">
            <!-- About User -->
            <div class="card mb-4">
              <div class="card-body">
                <small class="card-text text-uppercase">About</small>
                <ul class="list-unstyled mb-4 mt-3">
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-user text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Full Name:</span> <span>{{$data->name}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-user text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Father Name:</span> <span>{{$data->father_name}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-check text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">CNIC No:</span> <span>{{$data->cnic_no}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-crown text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Company:</span> <span>{{$data->company}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-flag text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Country:</span> <span>{{$data->nationality}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-file-description text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Date of birth:</span> <span>{{$data->date_of_birth}}</span>
                  </li>
                </ul>
                <small class="card-text text-uppercase">Contacts</small>
                <ul class="list-unstyled mb-4 mt-3">
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-phone-call"></i><span class="fw-medium mx-2 text-heading">Contact:</span>
                    <span>{{$data->phone_no}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-map-pin"></i><span class="fw-medium mx-2 text-heading">Address:</span>
                    <span>{{$data->address}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-mail"></i><span class="fw-medium mx-2 text-heading">Email:</span>
                    <span>{{$data->email}}</span>
                  </li>
                </ul>


              </div>
            </div>

          </div>
          <div class="col-xl-8 col-lg-8 col-md-4">

            <!--/ Activity Timeline -->
            <div class="row">
              <!-- Connections -->
              <div class="col-lg-12 col-xl-12">
                <div class="card card-action mb-4">
                  <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">Customer Profiles</h5>
                    <div class="card-action-element">
                      <div class="dropdown">
                        <button
                          type="button"
                          class="btn dropdown-toggle hide-arrow p-0"
                          data-bs-toggle="dropdown"
                          aria-expanded="false">
                          <i class="ti ti-dots-vertical text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="javascript:void(0);">Share connections</a></li>
                          <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                          <li>
                            <hr class="dropdown-divider" />
                          </li>
                          <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @forelse($data->customer_profiles as $key=>$item)
                      <li class="mb-3">
                        <div class="d-flex align-items-start">
                          <div class="d-flex align-items-start">
                            <div class="avatar me-2">
                              <img src="{{asset('assets/img/avatars/dumi-avatar2.png')}}" alt="Avatar p-2" class="rounded-circle" />
                            </div>
                            <div class="me-2 ms-1">
                              <h6 class="mb-0">{{$item->name}}</h6>
                              <small class="text-muted" > <i class="ti ti-phone-call"></i> {{$item->phone_no}}</small>
                            </div>
                          </div>
                          <div class="ms-auto">
                            <div class="d-flex flex-wrap flex-row">
                            <button class="btn btn-label-primary btn-icon btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal_{{$key}}">
                              <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Client Profile"><i class="ti ti-user-check ti-xs"></i></a>
                            </button>
                            </div>
                          </div>



                        </div>
                        <div class="modal fade" id="exampleModal_{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="exampleModalLabel">Customer Profile Detail</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        <li>Name:  {{$item->name}} </li>
                                        <li>Father's Name: {{$item->father_name}} </li>
                                        <li>Nationality: {{$item->nationality}}</li>
                                        <li>Email: {{$item->email }}</li>
                                        <li>Address:  {{$item->address}}</li>
                                        <li>Phone No: {{$item->phone_no}}</li>
                                        <li>Date of Birth: {{ $item->date_of_birth}}</li>
                                        <li>CNIC: {{$item->cnic}}</li>
                                        <li>Created At: {{$item->created_at}}</li>
                                        <li>Updated At: {{ $item->updated_at }}</li>
                                        <li>Assigned To: {{$item->customers->name}}</li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                          </div>
                      </li>
                      @empty
                            <li>Empty</li>
                        @endforelse
                    </ul>
                  </div>
                </div>
              </div>
              <!--/ Connections -->
              <!-- Teams -->

              <!--/ Teams -->
            </div>
            <!-- Projects table -->

            <!--/ Projects table -->
          </div>


        </div>
        <!--/ User Profile Content -->
      </div>
      <!-- / Content -->

      <!-- Footer -->
   @include('backend_app.layouts.footer')
      <!-- / Footer -->

      <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
  </div>
  @endsection
