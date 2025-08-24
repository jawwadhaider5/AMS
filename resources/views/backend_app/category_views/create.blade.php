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
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Category View /</span> Add New</h4>



        <div class="card">
          <div class="card-datatable table-responsive p-4">
            <form action="#" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Asset</label>
                        <input class="form-control" type="text" readonly value="1154.4584">
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Manufacturer</label>
                        <input class="form-control" type="text" readonly value="1154.4584">
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Model</label>
                        <input class="form-control" type="text" readonly value="1154.4584">
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Serial No.</label>
                        <input class="form-control" type="text" readonly value="1154.4584">
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Location.</label>
                        <input class="form-control" type="text" readonly value="1154.4584">
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Structure Group</label>
                        <input class="form-control" type="text" readonly value="1154.4584">
                    </div>

                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Safety Critical</label>
                        <input class="form-control" type="text" readonly value="1154.4584">
                    </div>
                    <div class ="col-lg-6 col-sm-12 mt-3">
                        <label for ="">Nde own or Not </label>
                        <input class ="form-control" type ="text" readonly value="1154.4584">
                        </div>
                        
                    
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Project</label>
                        <input class="form-control" type="text" readonly value="1154.4584">
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                        <label for="">Class</label>
                        <input class="form-control" type="text" readonly value="1154.4584">
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                        <label for="">Description</label>
                       <textarea name="" id="" class="form-control" cols="30" rows="3"></textarea>
                    </div>
                </div>


            <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>

        </form>
          </div>

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

@endsection

