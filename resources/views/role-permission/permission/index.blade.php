@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page">
    include('backend_app.layouts.nav') -->

@section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Permissions</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Permissions</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
 
    <!-- <div class="content-wrapper"> -->
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y"> 
        <div class="row mb-3">
            <div class="col-12">
                <button class="btn add-new btn-primary mb-3 mb-md-0 float-end" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#addPermissionModal"><span>Add Permission</span></button>

            </div>
            <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content p-3 p-md-5">
                    <button
                      type="button"
                      class="btn-close btn-pinned"
                      data-bs-dismiss="modal"
                      aria-label="Close"></button>
                    <div class="modal-body">
                      <div class="text-center mb-4">
                        <h3 class="mb-2">Add New Permission</h3>
                        <p class="text-muted">Permissions you may use and assign to your users.</p>
                      </div>
                      <form action="{{ url('permissions') }}" method="POST">
                        @csrf

                        <div class="col-12 mb-3">
                          <label class="form-label" for="modalPermissionName">Permission Name</label>
                          <input
                            type="text"
                            id="modalPermissionName"
                            name="name"
                            class="form-control"
                            placeholder="Permission Name"
                            autofocus />
                        </div>
                        <div class="col-12 mb-2">

                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                          <button type="submit" class="btn btn-primary me-sm-3 me-1">Create Permission</button>
                          <button
                            type="reset"
                            class="btn btn-label-secondary"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                            Discard
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
        </div>


        <!-- DataTable with Buttons -->
        <div class="card">

            <div class="table-responsive text-nowrap">
                {{-- <a href="{{route('add-files')}}" class="btn btn-primary float-end mt-3 mx-3">Add New File</a> --}}
                <table class="table" id="permissions_table">
                  <thead>
                    <tr class="text-nowrap">
                        <!-- <td><input type="checkbox" name="items[]"></td> -->
                        <th>Name </th>
                        <th>Action</th>

                    </tr>
                    <tbody id="table-body">
                        @foreach ($permissions as $key=>$permission)
                    <tr>
                        <!-- <td><input type="checkbox" name="items[]"></td> -->
                        <td>{{$permission->name}}</td>
                        <td>  <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                @can('update permission')
                              <a class="dropdown-item"  tabindex="0" data-bs-toggle="modal" data-bs-target="#edit_permission_{{$key}}"
                                ><i class="ti ti-pencil me-1"></i> Edit</a
                              >
                              @endcan
                              @can('delete permission')
                              <a class="dropdown-item"  href="{{ url('permissions/'.$permission->id.'/delete') }}"
                                ><i class="ti ti-trash me-1"></i> Delete</a
                              >
                              @endcan
                            </div>
                          </div></td>
                          <div class="modal fade" id="edit_permission_{{$key}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content p-3 p-md-5">
                                <button
                                  type="button"
                                  class="btn-close btn-pinned"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"></button>
                                <div class="modal-body">
                                  <div class="text-center mb-4">
                                    <h3 class="mb-2">Update Permission</h3>
                                    <p class="text-muted">Update the existing permission name</p>
                                  </div>
                                  <form action="{{ url('permissions/'.$permission->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-12 mb-3">
                                      <label class="form-label" for="modalPermissionName">Permission Name</label>
                                      <input
                                        type="text"
                                        id="modalPermissionName"
                                        name="name"
                                        class="form-control"
                                        placeholder="Permission Name"
                                        value="{{$permission->name}}"
                                        autofocus />
                                    </div>
                                    <div class="col-12 mb-2">

                                    </div>
                                    <div class="col-12 text-center demo-vertical-spacing">
                                      <button type="submit" class="btn btn-primary me-sm-3 me-1">Update Permission</button>
                                      <button
                                        type="reset"
                                        class="btn btn-label-secondary"
                                        data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Discard
                                      </button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                    </tr>
                    @endforeach
                </tbody>
                </thead>
               </table>
          </div>
        </div>
        <!-- Modal to add new record -->

        <!--/ DataTable with Buttons -->



      </div>
      <!-- / Content -->

      <!-- Footer -->
  <!-- include('backend_app.layouts.footer') -->
      <!-- / Footer -->

      <!-- <div class="content-backdrop fade"></div>
    </div> 
  </div> -->

  @push('scripts')
<script>
    $('#permissions_table').DataTable({
        pageLength: 10,
        ordering:false
    });
</script>
@endpush

@endsection

