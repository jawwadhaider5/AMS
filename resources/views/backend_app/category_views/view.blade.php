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
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Example /</span>Drive / Detail Page</h4>

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
                      <h4>FAS</h4>
                      <ul
                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                        <li class="list-inline-item d-flex gap-1">
                          <i class="ti ti-color-swatch"></i> Category
                        </li>

                        <li class="list-inline-item d-flex gap-1">
                          <i class="ti ti-calendar"></i> Joined: 23:12:200
                        </li>
                        <li class="list-inline-item d-flex gap-1">
                          <i class="ti ti-calendar"></i> Record Updated: 23:12:200
                        </li>
                      </ul>
                    </div>
                    <a href="javascript:void(0)"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_2">
                      <i class="ti ti-plus me-1"></i>Add New Task
                    </a>
                    <div class="modal fade" id="exampleModal_2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel_2">Add New Task</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="container">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 col-md-6">
                                        <label for="">Task Type</label>
                                        <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">

                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-md-6">
                                        <label for="">Sub Type</label>
                                        <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">

                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                        <label for="">Frequency</label>
                                        <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">

                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                        <label for="">Expire Date</label>
                                        <input value="{{ old('name') }}" type="date" class="form-control" name="name" id="">

                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                        <label for="">Start Date</label>
                                        <input value="{{ old('name') }}" type="date" class="form-control" name="name" id="">

                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                                        <label for="">IMCA Reference</label>
                                       <select name="" class="form-select" id="">
                                        <option value="">Choose</option>
                                        <option value="">testing</option>
                                       </select>

                                    </div>




                                </div>

                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
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
                    ><span class="fw-medium mx-2 text-heading">Asset ID:</span> <span>1245</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-user text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Manufacturer:</span> <span>1ASF!</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-check text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Model:</span> <span>4124</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-crown text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Serial No:</span> <span>15215</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-flag text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Location:</span> <span>Testing</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-file-description text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Safety Critical:</span> <span>124124</span>
                  </li>
                </ul>
                <small class="card-text text-uppercase">More Detail</small>
                <ul class="list-unstyled mb-4 mt-3">
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-phone-call"></i><span class="fw-medium mx-2 text-heading">Project:</span>
                    <span>Testing</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-map-pin"></i><span class="fw-medium mx-2 text-heading">Class:</span>
                    <span>No!</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-mail"></i><span class="fw-medium mx-2 text-heading">Class Code:</span>
                    <span>1241</span>
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
                    <h5 class="card-action-title mb-0">Tasks List</h5>
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

                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <ul class="list-unstyled mb-0">

                      <li class="mb-3 border-bottom border-dark">
                        <div class="d-flex align-items-start">
                          <div class="d-flex align-items-start">
                            <div class="avatar me-2">
                                <i class="menu-icon tf-icons ti ti-file fs-3"></i>
                            </div>
                            <div class="me-2 ms-1">
                              <h6 class="mb-0">Visual Examination</h6>

                            </div>
                          </div>
                          <div class="ms-auto">
                            <div class="d-flex flex-wrap flex-row">
                            <button class="btn btn-label-primary btn-icon btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModal">
                              <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Client Profile"><i class="ti ti-user-check ti-xs"></i></a>
                            </button>
                            </div>
                          </div>



                        </div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="exampleModalLabel">Task Detail</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        <li>Task ID: 1026.7135.0001</li>
                                        <li>IMCA Ref: Sheet 24.1 & 24.2</li>
                                        <li>IMCA D018 Requirements: When new or after modification:
                                            Internal pressure test to 1.5 times maximum working pressure of the system plus gas leak test at maximum working pressure of the system.
                                            Verify internal cleanliness appropriate to intended duty
                                            Maintenance Routine Notes: After modification HP and LP line were tested to 4500 and 450 psi and no leak noticed. Line was internally cleaned also for breathing air use. Fit for use.</li>
                                        <li>Start Date: 10/08/2022  /  Expiry Date:</li>

                                    </ul>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                </div>
                              </div>
                            </div>
                          </div>
                      </li>

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
