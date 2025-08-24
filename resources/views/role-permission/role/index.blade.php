@extends('backend_app.layouts.template')
@section('content')
<!-- <div class="layout-page"> 
  include('backend_app.layouts.nav')  
    <div class="content-wrapper">  -->

    @section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Roles</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Roles</a></li>
          <li class="breadcrumb-item active">All</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

      <div class="container-xxl flex-grow-1 container-p-y"> 

        <p class="mb-4">
          A role provided access to predefined menus and features so that depending on <br />
          assigned role an administrator can have access to what user needs.
        </p>
        
        <!-- Role cards -->
        <div class="row g-4">
            @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between"> 
                      <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                        <li
                          data-bs-toggle="tooltip"
                          data-popup="tooltip-custom"
                          data-bs-placement="top"
                          title="Vinnie Mostowy"
                          class="avatar avatar-sm pull-up">
                          <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar" />
                        </li>
                        <li
                          data-bs-toggle="tooltip"
                          data-popup="tooltip-custom"
                          data-bs-placement="top"
                          title="Allen Rieske"
                          class="avatar avatar-sm pull-up">
                          <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar" />
                        </li>
                        <li
                          data-bs-toggle="tooltip"
                          data-popup="tooltip-custom"
                          data-bs-placement="top"
                          title="Julee Rossignol"
                          class="avatar avatar-sm pull-up">
                          <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar" />
                        </li>
                        <li
                          data-bs-toggle="tooltip"
                          data-popup="tooltip-custom"
                          data-bs-placement="top"
                          title="Kaith D'souza"
                          class="avatar avatar-sm pull-up">
                          <img class="rounded-circle" src="../../assets/img/avatars/3.png" alt="Avatar" />
                        </li>
                        <li
                          data-bs-toggle="tooltip"
                          data-popup="tooltip-custom"
                          data-bs-placement="top"
                          title="John Doe"
                          class="avatar avatar-sm pull-up">
                          <img class="rounded-circle" src="../../assets/img/avatars/1.png" alt="Avatar" />
                        </li>
                      </ul>
                    </div>
                    <div class="d-flex justify-content-between align-items-end mt-1">
                      <div class="role-heading">
                        <h4 class="mb-1 text-capitalize">{{$role->name}}</h4>
                        @can('update role')
                        <a href="{{ url('roles/'.$role->id.'/give-permissions') }}" >
                            Add / Edit Role Permission
                        </a>
                        @endcan
                        @can('delete role')
                        <a href="{{ url('roles/'.$role->id.'/delete') }}" class="btn btn-danger ms-5">
                            Delete
                        </a>
                        @endcan


                      </div>

                    </div>
                  </div>
                </div>
              </div>
            @endforeach


            <div class="card h-100">
              <div class="row h-100">
                <div class="col-sm-5">
                  <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                    <img
                      src="../../assets/img/illustrations/add-new-roles.png"
                      class="img-fluid mt-sm-4 mt-md-0"
                      alt="add-new-roles"
                      width="83" />
                  </div>
                </div>
                <div class="col-sm-7">
                  <div class="card-body text-sm-end text-center ps-sm-0">
                    @can('create role')


                    <button
                      data-target="#addRoleModal"
                      data-toggle="modal"
                      class="btn btn-primary mb-2 text-nowrap add-new-role">
                      Add New Role
                    </button>
                    @endcan
                    <p class="mb-0 mt-1">Add role, if it does not exist</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!--/ Role cards -->

        <!-- Add Role Modal -->
        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">

            <div class="modal-content p-3 p-md-5">
              <button
                type="button"
                class="btn-close btn-pinned"
                data-dismiss="modal"
                aria-label="Close"></button>
              <div class="modal-body">
                <div class="text-center mb-4">
                  <h3 class="role-title mb-2">Add New Role</h3>
                  <p class="text-muted">Set role permissions</p>
                </div>
                <!-- Add role form -->
                <form action="{{ url('roles') }}" class="row g-3" method="POST">
                    @csrf
                  <div class="col-12 mb-4">
                    <label class="form-label" for="modalRoleName">Role Name</label>
                    <input
                      type="text"
                      id="modalRoleName"
                      name="name"
                      class="form-control"
                      placeholder="Enter a role name"
                      tabindex="-1" />
                  </div>

                  <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    <button
                      type="reset"
                      class="btn btn-label-secondary"
                      data-dismiss="modal"
                      aria-label="Close">
                      Cancel
                    </button>
                  </div>
                </form>
                <!--/ Add role form -->
              </div>
            </div>
          </div>
        </div>
        <!--/ Add Role Modal -->

        <!-- / Add Role Modal -->
      </div>
      <!-- / Content --> 


    <!-- </div> 
  </div> -->

@endsection
