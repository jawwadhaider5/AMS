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
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Users /</span> Update User</h4>



        <div class="card">
          <div class="card-datatable table-responsive p-4">
            <form action="{{route('update-customers',['id'=>$data->id])}}" method="POST">
                @csrf

            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" id="" value="{{$data->name}}">
                    @error('name')
                            <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Father Name</label>
                    <input type="text" class="form-control" name="father_name" id="" value="{{$data->father_name}}">
                    @error('father_name')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>


            </div>
            <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Nationality</label>
                    <input type="text" class="form-control" name="nationality" id="" value="{{$data->nationality}}">
                    @error('nationality')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Email</label>
                    <input type="email" class="form-control" name="email" id="" value="{{$data->email}}">
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>

            </div>

            <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Address</label>
                    <input type="text" class="form-control" name="address" id="" value="{{$data->address}}">
                    @error('address')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Phone Number</label>
                    <input type="number" name="phone_no" class="form-control"  id=""  value="{{$data->phone_no}}">
                    @error('phone_no')
                    <span class="text-danger">{{$message}}</span>
            @enderror
                </div>

            </div>

            <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Date of birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{$data->date_of_birth}}">
                       @error('date_of_birth')
                       <span class="text-danger">{{$message}}</span>
               @enderror
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">CNIC</label>
                    <input type="text"  data-inputmask="'mask': '99999-9999999-9'" class="form-control"  placeholder="XXXXX-XXXXXXX-X"  name="cnic" required=""  value="{{$data->cnic_no}}">
                       @error('cnic')
                       <span class="text-danger">{{$message}}</span>
               @enderror
                </div>


            </div>
            <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Company</label>
                    <input type="text" name="company" class="form-control" value="{{$data->company}}">
                       @error('company')
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
  <script>
    $(":input").inputmask();

   </script>
@endsection

