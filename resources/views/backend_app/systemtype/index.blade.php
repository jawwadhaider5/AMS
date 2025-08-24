@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page">
   include('backend_app.layouts.nav') 
  <div class="content-wrapper"> -->

  @section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">All IMCA Audit Type</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">IMCA Audit Type</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

      @can('create spread type')
      <div class="row">
        <div class="col-12">
          <a href="{{route('add-systemtype')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add IMCA Audit Type +</a>
        </div>
      </div>
      @endcan

      <!-- DataTable with Buttons -->
      <div class="card">

        @can('all spread type')
        <div class="table-responsive text-nowrap"> 
          <table class="table" id="systemtypes_table">
            <thead>
              <tr class="text-nowrap">
                <!-- <td><input type="checkbox" name="items[]"></td> -->
                <th>IMCA Audit Type Name</th>
                <th class="text-end">Actions</th>
              </tr>
            <tbody id="table-body">

              @foreach ($systemtypes as $systemtype)
              <tr> 
                <td><a href="{{ route('show-systemtype', $systemtype->id) }}">{{$systemtype->name}}</a></td> 
                <td class="text-end">
                  @can('edit spread type')
                  <a href="{{ route('edit-systemtype', $systemtype->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  @endcan
                  @can('delete spread type')
                  <a href="{{ route('delete-systemtype', $systemtype->id) }}" class="btn btn-sm btn-danger @if($systemtype->id == 1) d-none @endif" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
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

    <!-- include('backend_app.layouts.footer')
    <div class="content-backdrop fade"></div>
  </div>
</div> -->

@push('scripts')
<script>
  $('#systemtypes_table').DataTable({
    pageLength: 10,
    ordering: false
  });
</script>
@endpush

@endsection