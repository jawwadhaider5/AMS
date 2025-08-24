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

        <div class="card mb-3">
            <div class="card-datatable table-responsive p-4 ">

              <h5 class="pb-3">Import File Data From Excel File</h5>
              <div class="row">
                <form action="{{route('import-excel')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <label for="">Attach File</label>
                        <input type="file" class="form-control" accept=".xlsx, .xls" name="excel_file" id="">
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <button class="btn btn-primary mt-3" type="submit">Import File</button>
                    </div>


                </div>
            </form>


            </div>
          </div>
          <div class="card mb-3">
            <div class="card-datatable table-responsive p-4 ">

              <p class="pb-3">Download the excel format from below link</p>


              <div class="row mt-3">
                  <div class="col-lg-12 col-sm-12 col-md-12">
                    <form action="{{route('store-file')}}" method="POST">
                        @csrf
                        <a href="{{asset('assets/hill_view_file.xlsx')}}">Download Now</a>
                  </div>

              </div>


            </div>
          </div>

        <div class="card">
          <div class="card-datatable table-responsive p-4">

            <h5 class="pb-3">Add New File</h5>
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Form No <span class="text-danger">*</span></label>
                    <input  type="text" required class="form-control" value="{{old('form_no')}}" placeholder="Enter form_no" name="form_no" id="">
                    @error('form_no')
                            <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">ID No <span class="text-danger">*</span></label>
                    <input type="text" required class="form-control" placeholder="Enter ID no" value="{{old('id_no')}}" name="id_no" id="">
                    @error('id_no')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>


            </div>
            <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Security No <span class="text-danger">*</span></label>
                    <input type="text" required class="form-control" value="{{old('security_no')}}" placeholder="Enter security no" name="security_no" id="">
                    @error('security_no')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">File Status</label>
                   <select name="file_status" class="form-select" id="">
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

            <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Type <span class="text-danger">*</span></label>
                    <select required name="type" class="form-select" id="">
                        <option value="">Choose...</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                       </select>
                       @error('type')
                       <span class="text-danger">{{$message}}</span>
               @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label  for="">Size <span class="text-danger">*</span></label>
                    <input required type="number" name="size" value="{{old('size')}}" class="form-control" placeholder="Enter Size"  id="">
                    @error('size')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>

            </div>

            <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Unit</label>
                    <select  name="unit" class="form-select" id="">
                        <option value="">Choose...</option>
                        <option value="marla">Marla</option>
                        <option value="kanal">Kanal</option>
                       </select>
                       @error('unit')
                       <span class="text-danger">{{$message}}</span>
               @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Total Amount <span class="text-danger">*</span></label>
                    <input required type="number" value="{{old('total_amount')}}" name="total_amount" placeholder="Enter total amount" class="form-control" id="">
                    @error('total_amount')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>

            </div>

            <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Paid Amount</label>
                    <input type="number" value="{{old('paid_amount')}}" class="form-control" placeholder="Enter paid amount" name="paid_amount" id="">
                    @error('paid_amount')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">File Location</label>
                    <input type="text" value="{{old('file_location')}}" class="form-control" name="file_location" placeholder="Enter file location" id="">
                    @error('file_location')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>

            </div>

            <div class="row mt-3">

                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Assign Distributor</label>
                    <select name="distributor_id" class="form-select" id="">
                        <option value="">Choose...</option>
                        @foreach ($distributor as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                       </select>
                       @error('distributor_id')
                       <span class="text-danger">{{$message}}</span>
               @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Plot no</label>
                    <input type="text" value="{{old('plot_no')}}" name="plot_no" class="form-control" placeholder="Enter Plot no">
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

