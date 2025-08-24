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
        <h1 class="m-0">All Spreads</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Spread</a></li>
          <li class="breadcrumb-item active">All</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

<div class="container-xxl flex-grow-1 container-p-y">

  @can('create spread')
  <div class="row">
    <div class="col-12">
      <a href="{{route('add-system')}}" class="btn btn-primary w-auto float-end mb-2 mx-3">Add Spread +</a>
    </div>
  </div>
  @endcan

  <div class="card">
    @can('all spread')
    <div class="table-responsive text-nowrap">
      <table class="table" id="spread_table">
        <thead>
          <tr class="text-nowrap">
            <th class="text-left">Number of Systems</th>
            <th>Spread</th>
            <th>IMCA Audit Type </th>
            <!-- <th>Location</th> -->
            <th>Current Status</th>
            <th>Actions</th>
          </tr>
        <tbody id="table-body">
          <?php $count = 1 ?>
          @foreach ($systems as $system)
          <tr style="{{ $session->system_id == $system->system_type_id ? 'background-color: #e8ecee;' : '' }}">
            <td class="text-left">{{$system->spreadcategorytype_count}}</td>
            <td><a href="{{ route('save-systemtype-id', $system->id) }}">{{$system->system_name}}</a> </td>
            <!-- <td><a href="{{ route('system_dashboard', ['sid' => $system->id]) }}">{{$system->system_name}}</a> </td> -->

            <td>{{$system->systemtype->name}}</td>
            <!-- <td></td> -->
            <td>
              <span class="btn btn-sm 
                              @if($system->status === 'Expired') 
                                  btn-danger
                              @elseif($system->status === 'Expiring') 
                                  btn-warning
                              @elseif($system->status === 'Certified') 
                                  btn-success 
                              @elseif($system->status === 'Incomplete') 
                                  btn-secondary
                              @else 
                                  btn-secondary
                              @endif
                              ">
                {{ $system->status }}
              </span>
            </td>

            <td>
              @can('view spread')
              <a href="{{ route('edit-system', $system->id) }}" class="btn btn-sm btn-outline-primary d-none" title="Edit">
                <i class="fa fa-download"> Export</i>
              </a>
              @endcan
              @can('edit spread')
              <a href="{{ route('edit-system', $system->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              @endcan
              @can('delete spread')
              <a href="{{ route('delete-system', $system->id) }}" class="btn btn-sm btn-danger @if($system->id == 1) d-none @endif" onclick="return confirm('Are you sure you want to delete this?')" title="Delete">
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
                        <div class="col-lg-12 col-sm-12 col-md-6">
                          <label for="">Spread Name</label>
                          <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6">
                          <label for="">Number</label>
                          <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6">
                          <label for="">IMCA Audit Type</label>
                          <select name="system_type_id" class="form-select" id="">
                            <option value="">Select IMCA Audit Type</option>
                            @foreach ($systemtypes as $systemtype)
                            <option value="{{$systemtype->id}}"> {{$systemtype->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-6 mt-3 mt-3">
                          <label for="">Description</label>
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
  $('#spread_table').DataTable({
    pageLength: 10
  });
</script>
@endpush


@endsection