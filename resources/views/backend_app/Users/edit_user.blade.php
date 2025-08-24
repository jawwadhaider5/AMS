@extends('backend_app.layouts.template')
@section('content')

<div class="layout-page">
    <!-- Navbar -->

    @include('backend_app.layouts.nav')
    <!-- / Navbar -->

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Files /</span> Add File</h4>




          <div class="card">
            <div class="card-datatable table-responsive p-4">
                <form method="POST" action="{{route('update-files',['id'=>$data->id])}}">
                    @csrf
              <h5 class="pb-3">Update File</h5>
              <div class="row">
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">Form No</label>
                      <input type="text" class="form-control" name="form_no" id="" value="{{$data->form_no}}">
                      @error('form_no')
                              <span class="text-danger">{{$message}}</span>
                      @enderror
                  </div>
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">ID No</label>
                      <input type="text" class="form-control" name="id_no" id="" value="{{$data->id_no}}">
                      @error('id_no')
                      <span class="text-danger">{{$message}}</span>
              @enderror
                  </div>


              </div>
              <div class="row mt-3">
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">Security No</label>
                      <input type="text" class="form-control" name="security_no" id="" value="{{$data->security_no}}">
                      @error('security_no')
                      <span class="text-danger">{{$message}}</span>
              @enderror
                  </div>
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">File Status</label>
                     <select name="file_status" class="form-select" id="">
                      <option   value="">Choose...</option>
                      <option  @if($data->file_status === "open" ) selected @endif value="open">Open</option>
                      <option  @if($data->file_status === "closed" ) selected @endif value="closed">Closed</option>
                      <option  @if($data->file_status === "blocked" ) selected @endif value="blocked">Blocked</option>
                      <option  @if($data->file_status === "processing" ) selected @endif value="processing">Processing</option>
                      <option  @if($data->file_status === "reserved" ) selected @endif value="reserved">Reserved</option>
                      <option  @if($data->file_status === "ready" ) selected @endif value="ready">Ready</option>
                      <option  @if($data->file_status === "delivered" ) selected @endif value="delivered">Delivered</option>
                     </select>
                  </div>

              </div>

              <div class="row mt-3">
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">Type</label>
                      <select name="type" class="form-select" id="">
                          <option value="">Choose...</option>
                          <option  @if($data->type === "residential" ) selected @endif value="residential">Residential</option>
                          <option @if($data->type === "commercial" ) selected @endif value="commercial">Commercial</option>
                         </select>
                         @error('type')
                         <span class="text-danger">{{$message}}</span>
                 @enderror
                  </div>
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">Size</label>
                      <input type="number" name="size" class="form-control"  id="" value="{{$data->size}}">
                      @error('size')
                      <span class="text-danger">{{$message}}</span>
              @enderror
                  </div>

              </div>

              <div class="row mt-3">
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">Unit</label>
                      <select name="unit" class="form-select" id="">
                          <option value="">Choose...</option>
                          <option @if($data->unit === "marla" ) selected @endif value="marla">Marla</option>
                          <option @if($data->unit === "kanal" ) selected @endif value="kanal">Kanal</option>
                         </select>
                         @error('unit')
                         <span class="text-danger">{{$message}}</span>
                 @enderror
                  </div>
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">Total Amount</label>
                      <input type="number" name="total_amount" class="form-control" id="" value="{{$data->total_amount}}">
                      @error('total_amount')
                      <span class="text-danger">{{$message}}</span>
              @enderror
                  </div>

              </div>

              <div class="row mt-3">
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">Paid Amount</label>
                      <input type="number" class="form-control" id="" disabled value="{{$data->paid_amount}}">
                      @error('paid_amount')
                      <span class="text-danger">{{$message}}</span>
              @enderror
                  </div>
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">Balance Amount</label>
                      <input type="number" class="form-control" disabled id="" value="{{$data->balance_amount}}">
                      @error('balance_amount')
                      <span class="text-danger">{{$message}}</span>
              @enderror
                  </div>

              </div>

              <div class="row mt-3">
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">File Location</label>
                      <input type="text" class="form-control" name="file_location" id="" value="{{$data->file_location}}">
                      @error('file_location')
                      <span class="text-danger">{{$message}}</span>
              @enderror
                  </div>
                  <div class="col-lg-6 col-sm-12 col-md-6">
                      <label for="">Assign Distributor</label>
                      <select name="distributor_id" class="form-select" id="">
                          <option value="">Choose...</option>
                          @foreach ($distributor as $item)
                          <option @if($item->id === $data->distributor_id ) selected @endif value="{{$item->id}}">{{$item->company}}</option>
                          @endforeach
                         </select>
                         @error('distributor_id')
                         <span class="text-danger">{{$message}}</span>
                 @enderror
                  </div>
                  <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                    <label for="">Plot no</label>
                    <input type="text" value="{{$data->plot_no}}" name="plot_no" class="form-control" placeholder="Enter Plot no">
                       @error('plot_no')
                       <span class="text-danger">{{$message}}</span>
               @enderror
                </div>
              </div>



              <div class="row mt-3">
                  <div class="col-12">
                      <button class="btn btn-primary">Submit</button>
                  </div>
              </div>
          </form>
            </div>
          </div>
        <!-- Modal to add new record -->

        <!--/ DataTable with Buttons -->



      </div>
      <!-- / Content -->

      <!-- Footer -->
  @include('backend_app.layouts.footer')
      <!-- / Footer -->

      <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
  </div>

@endsection

