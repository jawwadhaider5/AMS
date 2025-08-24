@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page"> 
    @include('backend_app.layouts.nav') 
    <div class="content-wrapper"> -->
<!-- Content -->

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Users</h1>
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

<div class="container-xxl flex-grow-1 container-p-y">


  <div class="row mb-3">
    <div class="col-12">
      <button class="btn add-new btn-primary mb-3 mb-md-0 float-end" tabindex="2" aria-controls="DataTables_Table_0" type="button" data-toggle="modal" data-target="#offcanvasAddUser"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i> Add New User</span></button>
    </div>

  </div>


  <!-- DataTable with Buttons -->
  <div class="card">

    <div class="table-responsive text-nowrap">

      <table class="table">
        <thead>
          <tr class="text-nowrap"> 
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Action</th>
          </tr>
        <tbody id="table-body">
          @foreach ($users as $key=>$user)
          <tr> 
            <td>{{ $user->id }}</td>
            <td>
              <div class="avatar avatar-sm pull-up">
                <a href="{{route('user-detail',['userId'=>$user->id])}}">
                  <img class="rounded-circle me-1 border" style="width: 80px; " src=" {{ ($user->img) ? asset('assets/users/' . $user->img) : asset('assets/users/dummy-profile-image-male.jpg') }}" alt="Avatar">
                  {{ $user->name }}
                </a>
              </div>
            </td>

            <td>{{ $user->email }}</td>
            <td>
              @if (!empty($user->getRoleNames()))
              @foreach ($user->getRoleNames() as $rolename)
              <label class="badge bg-primary mx-1 text-capitalize">{{ $rolename }}</label>
              @endforeach
              @endif
            </td>


            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-toggle="dropdown">
                  <i class="ti ti-dots-vertical"></i> Action
                </button>
                <div class="dropdown-menu">

                  @can('update permission')
                  <a class="dropdown-item" tabindex="0" data-toggle="modal" data-target="#edit_permission_{{$key}}"><i class="ti ti-pencil me-1"></i> Edit</a>
                  @endcan
                  @can('delete user')
                  <a class="dropdown-item" href="{{ url('users/'.$user->id.'/delete') }}"><i class="ti ti-trash me-1"></i> Delete</a>
                  @endcan
                </div>
              </div>
            </td>
            <div class="modal fade" id="edit_permission_{{$key}}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3 p-md-5">
                  <button
                    type="button"
                    class="btn-close btn-pinned"
                    data-dismiss="modal"
                    aria-label="Close"></button>
                  <div class="modal-body">
                    <div class="text-center mb-4">
                      <h3 class="mb-2">Update User</h3>
                      <p class="text-muted">Update the existing user information</p>
                    </div>
                    <form action="{{ url('users/'.$user->id) }}" method="POST">
                      @csrf
                      @method('PUT')

                      <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" />
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                      </div>
                      <div class="mb-3">
                        <label for="">Email</label>
                        <input type="text" name="email" readonly value="{{ $user->email }}" class="form-control" />
                      </div>
                      <div class="mb-3">
                        <label for="">Password</label>
                        <input type="text" name="password" class="form-control" />
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                      </div>
                      <div class="mb-3">
                        <label for="">Roles</label>
                        <select name="roles[]" class="form-control">
                          <option value="">Select Role</option>
                          @foreach ($roles as $role)
                          <option
                            value="{{ $role }}"
                            {{ in_array($role, $user->roles->pluck('name','name')->all()) ? 'selected':'' }}>
                            {{ $role }}
                          </option>
                          @endforeach
                        </select>
                        @error('roles') <span class="text-danger">{{ $message }}</span> @enderror
                      </div>
                      <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
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


</div>
<div class="modal fade" id="offcanvasAddUser" tabindex="-2" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered">

  
  
  <div class="modal-content mx-0 flex-grow-0 pt-0 h-100 p-3">
  <div class="modal-head">
    <h5  class="offcanvas-title">Add User</h5> 
  </div>

    <form action="{{ url('users') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label for="">Name</label>
        <input type="text" name="name" class="form-control" />
      </div>
      <div class="mb-3">
        <label for="">Email</label>
        <input type="text" name="email" class="form-control" />
      </div>
      <div class="mb-3">
        <label for="">Password</label>
        <input type="text" name="password" class="form-control" />
      </div>
      <div class="mb-3">
        <label for="">Roles</label>
        <select name="roles[]" class="form-control">
          <option value="">Select Role</option>
          @foreach ($roles as $role)
          <option value="{{ $role }}">{{ $role }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
  </div>
</div>
<!-- / Content -->

<!-- Footer -->
<!-- @include('backend_app.layouts.footer') 
<div class="content-backdrop fade"></div>
</div> 
</div> -->

@endsection