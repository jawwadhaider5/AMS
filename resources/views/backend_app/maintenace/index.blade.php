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
                <h1 class="m-0">All Maintenances</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Maintenance</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y"> 


      <!-- DataTable with Buttons -->
      <div class="card">

        @can('all maintenance')
        <div class="table-responsive text-nowrap">
          <table class="table" id="maintenance_table">
            <thead>
              <tr class="text-nowrap">
                <!-- <td><input type="checkbox" name="items[]"></td> -->
                <th>Asset ID </th>
                <th>Description </th>
                <th>Equipment Type</th>
                <th>Structure</th>
                <th>Spread</th>
                <th>Manufacturer</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            <tbody id="table-body">
              @foreach ($all_assets as $all_asset)
              <tr>
                <!-- <td><input type="checkbox" name="items[]"></td> -->
                <!-- <td><a href="{{ route('asset-category-edit', $all_asset->id) }}">{{$all_asset->id}}</a></td> -->
                <td>{{$all_asset->id}}</td>
                <td> {{substr($all_asset->description, 0, 20)}} </td>
                <td>{{$all_asset->subcategory->name}}</td>
                <td>{{$all_asset->system ? $all_asset->system->system_name : ''}}</td>
                <td>{{$all_asset->category->name}}</td>
                <td>{{$all_asset->manufacturer}}</td>
                <td>Certified</td>
                <td>
                  <a class="btn btn-sm btn-outline-info " style="font-size: inherit;" href="{{ route('maintenace-generate-pdf', $all_asset->id) }}" target="_blank">
                    <i class="fa fa-download"></i>&nbsp;Open</a>
                  @can('edit maintenance')
                  <a href="{{ route('move-maintenace', $all_asset->id) }}" class="btn btn-sm btn-outline-primary waves-effect" title="Edit">
                    <i class="fas fa-arrow-right"></i>
                  </a>
                  @endcan

                </td>
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

    <!-- Footer -->
    <!-- include('backend_app.layouts.footer')
    <div class="content-backdrop fade"></div>
  </div>
</div> -->


@push('scripts')
<script>
  $('#maintenance_table').DataTable({
    pageLength: 10
  });
</script>
@endpush

@endsection