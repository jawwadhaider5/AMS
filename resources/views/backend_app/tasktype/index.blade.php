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
                <h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Task Type</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

    <div class="container-xxl flex-grow-1 container-p-y">


      @can('create task type')
      <div class="row">
        <div class="col-12">
          <a href="{{route('add-tasktype')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add Task type +</a>
        </div>
      </div>
      @endcan
      <!-- DataTable with Buttons -->
      <div class="card">
        @can('all task type')

        <div class="table-responsive text-nowrap">
          <table class="table" id="tasktype_table">
            <thead>
              <tr class="text-nowrap">
                <!-- <td><input type="checkbox" name="items[]"></td> -->
                <th>Task Type Name</th>
                <th>IMCA Refenrence</th>
                <th>Frequency</th>
                <th>Expire Date</th>
                <th>Actions</th>
              </tr>
            <tbody id="table-body">

              @foreach ($tasktypes as $tasktype)
              <tr>
                <!-- <td><input type="checkbox" name="items[]"></td> -->

                <td>{{$tasktype->name}}</td>
                <td>{{ $tasktype->imca ? $tasktype->imca->name : 'N/A' }}</td>
                <td>{{ $tasktype->frequency }}</td>
                <td>{{ $tasktype->expire_date }}</td>
                <td>
                  @can('edit task type')
                  <a href="{{ route('edit-tasktype', $tasktype->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  @endcan
                  @can('delete task type')
                  <a href="{{ route('delete-tasktype', $tasktype->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                  @endcan
                </td>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="container">
                          <div class="row">
                            <div class="col-lg-6 col-sm-12 col-md-6">
                              <label for="">Project Name</label>
                              <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">

                            </div>
                            <div class="col-lg-6 col-sm-12 col-md-6">
                              <label for="">Client</label>
                              <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">

                            </div>
                            <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                              <label for="">Description</label>
                              <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">

                            </div>
                            <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                              <label for="">Start Date</label>
                              <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">

                            </div>

                            <div class="col-lg-12 col-sm-12 col-md-6 mt-3 mt-3">
                              <label for="">End Date</label>
                              <textarea name="" id="" cols="30" class="form-control" rows="5"></textarea>

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

              </tr>
              @endforeach
            </tbody>
            </thead>
          </table>
        </div>
        @endcan
      </div>
      <div id="paginationContainer" class="float-end mt-3">
        {{-- {{$data->links()}} --}}
      </div>

    </div>
    <!-- / Content -->

    <!-- Footer -->
    <!-- include('backend_app.layouts.footer')
    <div class="content-backdrop fade"></div>
  </div>
</div> -->

@push('scripts')
<script>
  $('#tasktype_table').DataTable({
    pageLength: 10,
    ordering: false
  });
</script>
@endpush

@endsection