@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page"> -->
<!-- Navbar -->
<!-- include('backend_app.layouts.nav') -->

<!-- / Navbar -->

<!-- Content wrapper -->
<!-- <div class="content-wrapper"> -->
<!-- Content -->

@section('head') 
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <!--<h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>-->
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Inspection Requirements</li>
        </ol>
      </div>
    </div>
  </div>
</div> 
@endsection

<div class="container-xxl flex-grow-1 container-p-y">
  <!-- <h4 class="py-3 mb-1"><span class="text-muted fw-light">Components / </span> All</h4> -->



  @can('create component')
  <div class="row">
    <div class="col-12">
      <a href="{{route('add-category')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add Inspection Requirements +</a>

    </div>
  </div>
  @endcan
  <!-- DataTable with Buttons -->
  <div class="card">

    @can('all component')
    <div class="table-responsive text-nowrap">
      <table class="table" id="category_table">
        <thead>
          <tr class="text-nowrap">
            <!-- <th><input type="checkbox" name="items[]"></th> -->
            <th class="fw-bold">ID</th>
            <th class="fw-bold">Name </th>
            <th class="fw-bold">IMCA Audit Type</th>
            <th class="fw-bold text-end">Actions</th>

          </tr>
        </thead>
        <tbody id="table-body">
          @foreach ($categories as $category)
          <tr>
            <!-- <td><input type="checkbox" name="items[]"></td> -->

            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->systemtype->name}}</td>

            <td style="" class="text-end">

              @can('edit component')
              <a href="{{ route('edit-category', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              @endcan
              @can('transfer component')
              <a href="{{ route('transfer-category', $category->id) }}" class="btn btn-sm btn-outline-primary" title="transfer">
                <i class="fa fa-arrow-right"></i>
              </a>
              @endcan
              @can('delete component')
              <a href="{{ route('delete-category', $category->id) }}" class="btn btn-sm btn-danger @if($category->id  == 1) d-none @endif" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
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
                        <div class="col-lg-12 col-sm-12 col-md-6 mt-3">
                          <label for="">Inspection Requirements Name</label>
                          <input class="form-control" type="text" readonly value="Testing">
                        </div>

                        <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                          <label for="">Parent Cateogory</label>
                          <select class="form-select" name="" id="">
                            <option value="">parent</option>
                          </select>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                          <label for="">Description</label>
                          <textarea name="" id="" class="form-control" cols="30" rows="3"></textarea>
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
  $('#category_table').DataTable({
    pageLength: 10
  });
</script>
@endpush

@endsection