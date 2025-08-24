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
                <h1 class="m-0">All Spares</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Spares</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

    <div class="container-xxl flex-grow-1 container-p-y"> 


      @can('create spare')
      <div class="row">
        <div class="col-12">
          <div class="dropdown float-end">
          </div>
          <a href="{{route('add-spares')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add Spares +</a>

        </div>
      </div>
      @endcan

      <div class="card">

        @can('all spare')
        <div class="table-responsive text-nowrap">
          <table class="table" id="spare_table">
            <thead>
              <tr class="text-nowrap">
                <!-- <th><input type="checkbox" name="items[]"></th> -->
                <th class="fw-bold">ID</th>
                <th class="fw-bold">Spread Name </th>
                <th class="fw-bold">Part Number</th>
                <th class="fw-bold">Description</th>
                <th class="fw-bold">Supplier</th>
                <th class="fw-bold">Supplier Part Number</th>
                <th class="fw-bold">Quantity</th>
                <th class="fw-bold">Critical Quantity</th>
                <th class="fw-bold text-end">Actions</th>
              </tr>
            </thead>
            <tbody id="table-body">
              @foreach ($spares as $spare)
              <tr>
                <!-- <td><input type="checkbox" name="items[]"></td> -->
                <td>{{$spare->id}}</td>
                <td>

                  {{ $spare->system->system_name ?? 'N/A' }}
                </td>
                <td> {{substr($spare->description, 0, 50)}} </td>
                <td>{{$spare->part_number}}</td>
                <td>{{$spare->supplier}}</td>
                <td>{{$spare->supplier_part_number}}</td>
                <td>{{$spare->quantity}}</td>
                <td>{{$spare->critical_quantity}}</td>

                <td style="width: 30px;">
                  @can('edit spare')
                  <a href="{{ route('edit-spares', $spare->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  @endcan
                  @can('delete spare')
                  <a href="{{ route('delete-spares', $spare->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                  @endcan
                </td>
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
  $('#spare_table').DataTable({
    pageLength: 10
  });
</script>
@endpush

@endsection