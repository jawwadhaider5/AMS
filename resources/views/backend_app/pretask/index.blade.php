@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page"> 
  @include('backend_app.layouts.nav')

  <div class="content-wrapper"> -->

  @section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">All Predefined Tasks</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Pre Defined Tasks</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection


    <div class="container-xxl flex-grow-1 container-p-y">  

      @can('create pre define task')
      <div class="row">
        <div class="col-12">
          <a href="{{route('add-pretask')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add Pre Task +</a>
        </div>
      </div>
      @endcan
      <div class="card">

        @can('all pre define task')
        <div class="table-responsive text-nowrap">
          {{-- <a href="{{route('add-files')}}" class="btn btn-primary float-end mt-3 mx-3">Add New File</a> --}}
          <table class="table" id="pretasks_table">
            <thead>
              <tr class="text-nowrap"> 
              <th class="text-left">Sheet Number</th>
                <!-- <th>Name</th>
                <th>Description</th>
                <th>Frequency</th>  -->
                <th class="text-right">Actions</th>
              </tr>
            <tbody id="table-body">

              @foreach ($tasktypes as $pretask)
              <tr> 
              <td class="text-left">
              <a href="{{ route('show-pretask', $pretask->id) }}">{{ $pretask->name ? $pretask->name: 'N/L' }}</a></td> 
                <td class="text-right">
                  @can('edit pre define task')
                  <a href="{{ route('edit-pretask', $pretask->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  @endcan
                  @can('delete pre define task')
                  <a href="{{ route('delete-pretask', $pretask->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
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

    </div>
    <!-- / Content -->

    
    

    <!-- include('backend_app.layouts.footer')
    
    <div class="content-backdrop fade"></div>
  </div>
</div> -->

@push('scripts')
<script>
  $('#pretasks_table').DataTable({
    pageLength: 10,
    ordering: false
  });
</script>
@endpush

@endsection