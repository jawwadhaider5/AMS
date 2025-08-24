@extends('backend_app.layouts.template')
@section('content')
<style>
  .icon-wrapper {
    cursor: pointer;
  }

  .icon-wrapper:hover {
    transform: scale(1.10);
    transition: 0.3s ease-in-out;
  }

  .sorting-arrows {
    display: inline-block;
    vertical-align: middle;
    font-size: 12px;
    /* Adjust the font size as needed */
    margin-left: 5px;
    /* Adjust the spacing between the text and arrows as needed */
  }

  .sorting-arrows span {
    cursor: pointer;
  }

  /* Styling for the top arrow */
</style>
<div class="layout-page">
  <!-- Navbar -->
  @include('backend_app.layouts.nav')


  {{-- Modal Dealer --}}

  <div class="modal fade" id="bulk_action_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3 class="mb-2">Assign Dealer</h3>

          </div>

          <form id="enableOTPForm" class="row g-3" action="#" method="post">
            @csrf
            <div class="col-12">


            </div>
            <div class="col-12">
              <label class="form-label" for="modalEnableOTPPhone">Dealers</label>
              <div class="input-group py-2 mb-3">
                <select class="form-select" id="dealer_assign">
                  <option value="">Choose...</option>
                  @foreach ($dealers as $dealer)
                  <option value="{{$dealer->id}}">{{$dealer->company}}</option>
                  @endforeach

                </select>
              </div>
            </div>
            <div class="col-12">
              <button type="button" class="btn btn-outline-primary me-sm-3 me-1" id="dealer_btn">Assign</button>
              <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>







  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->



    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="py-3 mb-4"><span class="text-muted fw-light">Files /</span> All Files</h4>
      <div class="row mb-3">
        <div class="col-12">
          <div class="card p-3">
            <div class="card-title">Manage Files</div>
            <form action="{{route('assigned_dealers')}}" id="dealer_form" method="POST">
              @csrf
              <div class="">
                <div class="d-flex flex-wrap flex-row">

                  <div class="icon-wrapper position-absolute" style="right: 10px;">
                    <i id="toggleIcon" class="fas fa-angle-double-down mb-2 text-primary"></i>
                  </div>
                  <label for="" class="mt-2 me-2">Bulk Action</label>
                  <select name="dealer_id" class="form-select w-25" id="dealer_data">
                    <option value="">Choose....</option>
                    <option value="dealers">Dealers</option>
                    <option value="status">Status</option>
                    <option value="delete">Delete</option>

                  </select>
                  <button class="btn btn-primary mx-2" id="bulk_btn" type="button">Submit</button>
                </div>
            </form>
            <form action="{{route('file_filer')}}" method="POST" id="search-file">
              @csrf
              <div class="row pt-2 mt-3 border-top" id="hiddenDiv" style="display: none;">
                <div class="col-md-3">
                  <label for="" class=" me-2 mb-1">Tracking no</label>
                  <input type="text" class="form-control" placeholder="Enter Tracking no" name="tracking_no">
                </div>
                <div class="col-md-3">
                  <label for="" class=" me-2 mb-1">ID No</label>
                  <input type="text" class="form-control" placeholder="Enter ID no" name="id_no">
                </div>
                <div class="col-md-3">
                  <label for="" class=" me-2 mb-1">Type</label>
                  <select name="type" class="form-select ">
                    <option value="">Choose...</option>
                    <option value="residential">Residential</option>
                    <option value="commercial">Commercial</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="" class=" me-2 mb-1">Size</label>
                  <input type="integer" placeholder="Enter Marla Size" class="form-control" name="size">
                </div>
                <div class="col-md-3 mt-3">
                  <label for="" class=" me-2 mb-1">File Status</label>
                  <select name="file_status" class="form-select" id="">
                    <option value="">Choose...</option>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                    <option value="blocked">Blocked</option>
                    <option value="processing">Processing</option>
                    <option value="reserved">Reserved</option>
                    <option value="ready">Ready</option>
                  </select>
                </div>

                <div class="col-md-3 mt-3">
                  <label for="" class=" me-2 mb-1">Assigned Partners</label>
                  <select name="dealer" class="form-select" id="">
                    <option value="">Choose...</option>
                    @foreach ($dealers as $dealer)
                    <option value="{{$dealer->id}}">{{$dealer->company}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 mt-3">
                  <button type="button" class="btn btn-primary mt-4 ms-auto d-block" id="filter_btn">Apply Filter</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-12 py-2">
        <select name="page_view" id="page_view" class="px-2 py-2 border rounded-3  border-primary" style="background:#25293C;" id="">
          <option selected value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <div class="dropdown float-end">
          <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Export
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('export-files',['type'=>'pdf'])}}" class="btn btn-primary w-auto float-end mb-2">PDF</a></li>
            <li><a class="dropdown-item" href="{{route('export-files',['type'=>'excel'])}}" id="delete_all" class="btn btn-primary w-auto float-end mb-2 mx-2 text-white">Excel</a></li>

          </ul>
        </div>
        <div class="dropdown float-end mx-2">
          <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Actions
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('add-files')}}" class="btn btn-primary w-auto float-end mb-2">Add New File</a></li>
            <li><a class="dropdown-item" id="delete_all" onclick="return confirm('Are you want to confirm to delete the files?')" class="btn btn-primary w-auto float-end mb-2 mx-2 text-white">Delete Files</a></li>

          </ul>
        </div>

      </div>
    </div>
    <!-- DataTable with Buttons -->



    <div class="card">

      <div class="table-responsive text-nowrap">
        
        <table class="table">
          <thead>
            <tr class="text-nowrap">
              <th><input type="checkbox" id="checkItems"></th>
              <th>Tracking no</th>
              <th>App Form No </th>
              <th>
                Id No
                <div class="sorting-arrows">
                  <span class="top-arrow">▲</span>
                  <span class="bottom-arrow">▼</span>
                </div>
              </th>
              <th>Security No</th>
              <th>File Status</th>
              <th>Type</th>
              <th>Size</th>
              <th>Unit</th>
              <th>Total Amount</th>
              <th>Paid Amount</th>
              <th>Balance Amount</th>
              <th>File Location</th>
              <th>Assigned To</th>
              <th>Client Name</th>
              <th>Client Cnic</th>
              <th>Plot no</th>
              <th>Action</th>

            </tr>
          </thead>
          <tbody id="table-body">
            @foreach ($data as $item)
            <tr>
              @php

              $ledger = DB::table('ledgers')->where('file_id', $item->id)->get();
              $paid_amount=0;

              if ($ledger !== null) {

              foreach ($ledger as $key => $value) {

              $paid_amount+=$value->paid_amount;
              }


              }


              $remaning_amount = $item->total_amount- $paid_amount;

              @endphp
              <th scope="row">
                <input type="checkbox" class="all_products" name="items[]" value="{{$item->id}}">
              </th>
              <td><a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Detail" href="{{route('file-data',['id'=>$item->id])}}">{{$item->hv_code}}</a></td>
              <td>{{$item->form_no}}</td>
              <td>{{$item->id_no}}</td>
              <td>{{$item->security_no}}</td>
              <td>
                @if ($item->file_status==="open")
                <span class="badge bg-success"> {{$item->file_status}}</span>
                @elseif($item->file_status=="blocked")
                <span class="badge bg-danger"> {{$item->file_status}}</span>
                @elseif($item->file_status=="closed")
                <span class="badge bg-danger"> {{$item->file_status}}</span>
                @elseif($item->file_status=="processing")
                <span class="badge bg-warning"> {{$item->file_status}}</span>
                @elseif($item->file_status =="reserved")
                <span class="badge bg-info"> {{$item->file_status}}</span>
                @elseif($item->file_status =="ready")
                <span class="badge bg-primary"> {{$item->file_status}}</span>
                @elseif($item->file_status =="delivered")
                <span class="badge bg-success"> {{$item->file_status}}</span>

                @endif
              </td>
              <td>{{$item->type}}</td>
              <td>{{$item->size}}</td>
              <td>{{$item->unit}}</td>
              <td class="text-primary">Rs:{{ number_format($item->total_amount) }}</td>
              <td class="text-warning">Rs:{{ number_format($paid_amount) }}</td>
              <td class="text-danger">Rs:{{ number_format($remaning_amount) }}</td>
              <td>{{$item->file_location}}</td>
              <td><span>@if($item->distributor_id !== null){{$item->dealer->company}} @else Not assigned @endif </span><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Update Dealer"></span>

              </td>
              <td>
                @php
                $idAsString = strval($item->id);
                $client = DB::table('clients')
                ->whereRaw('JSON_CONTAINS(files, ?)', [json_encode($idAsString)])->first();

                echo $client ? $client->name : 'Not assigned';
                // Display the username if found, otherwise an empty string
                @endphp


              </td>
              <td>
                @php
                echo $client ? $client->cnic : 'Not assigned';
                @endphp
              </td>
              <td>{{$item->plot_no}}</td>

              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{route('edit-file',['id'=>$item->id])}}"><i class="ti ti-pencil me-1"></i> Edit</a>
                    <a class="dropdown-item" href="{{route('delete-file',['id'=>$item->id])}}"><i class="ti ti-trash me-1"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>

        </table>

      </div>

    </div>
    <div id="paginationContainer" class="float-end mt-3">
      {{$data->links()}}
    </div>

  </div>
  <!-- / Content -->

  <!-- Footer -->
  @include('backend_app.layouts.footer')
  <!-- / Footer -->

  <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>

<div class="modal fade" id="status_action_modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Update Status</h3>
        </div>


        <div class="col-12">
          <label class="form-label" for="modalEnableOTPPhone">Status</label>
          <div class="input-group py-2 mb-3">

            <form action="{{route('bulk_status')}}" class="w-100" method="POST" id="status_form">
              @csrf
              <select name="file_status" class="form-select" id="status_value">
                <option value="">Choose...</option>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
                <option value="blocked">Blocked</option>
                <option value="processing">Processing</option>
                <option value="reserved">Reserved</option>
                <option value="ready">Ready</option>
                <option value="delivered">Delivered</option>

              </select>



          </div>
        </div>
        <div class="col-12">
          <button type="button" class="btn btn-outline-primary me-sm-3 me-1" id="status_btn">Update Status</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
            Cancel
          </button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- --}}

@endsection