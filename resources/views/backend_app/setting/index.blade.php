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
                <h1 class="m-0">Settings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

      <div class="container-xxl flex-grow-1 container-p-y"> 
        <div class="row">
          <div class="col-md-12">


            <div class="card mb-4" id="general_setting">
              <h5 class="card-header">Software Details</h5>
              <!-- Account -->
              <div class="card-body">
                <form  action="{{route('update-setting')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                    <div class="col-lg-6 col-sm-12 col-md-6">
                <div class="d-flex align-items-start align-items-sm-center gap-4">

                    <!-- <img
                    src="{{asset('assets/logo/'.$data->logo)}}"
                    onerror="this.src='https://lh5.googleusercontent.com/proxy/t08n2HuxPfw8OpbutGWjekHAgxfPFv-pZZ5_-uTfhEGK8B5Lp-VN4VjrdxKtr8acgJA93S14m9NdELzjafFfy13b68pQ7zzDiAmn4Xg8LvsTw1jogn_7wStYeOx7ojx5h63Gliw'"
                    class="d-block w-25 rounded"
                    id="uploadedAvatar" /> -->



                  <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                      <span class="d-none d-sm-block">Upload new Logo</span>
                      <i class="ti ti-upload d-block d-sm-none"></i>
                      <input
                        type="file"
                        id="upload"
                        class="account-file-input"
                        hidden
                        name="logo"
                        />
                    </label>
                    <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                      <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                      <span class="d-none d-sm-block">Reset</span>
                    </button>

                    <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                  </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-6">
                <div class="d-flex align-items-start align-items-sm-center gap-4">

                    <img
                    src="{{asset('assets/fav_icon/'.$data->fav_icon)}}"
                    onerror="this.src='https://lh5.googleusercontent.com/proxy/t08n2HuxPfw8OpbutGWjekHAgxfPFv-pZZ5_-uTfhEGK8B5Lp-VN4VjrdxKtr8acgJA93S14m9NdELzjafFfy13b68pQ7zzDiAmn4Xg8LvsTw1jogn_7wStYeOx7ojx5h63Gliw'"
                    alt="user-avatar"
                    class="d-block w-25 rounded"
                    id="uploadedAvatar" />



                  <div class="button-wrapper">
                    <label for="fav_icon" class="btn btn-primary me-2 mb-3" tabindex="0">
                      <span class="d-none d-sm-block">Upload new Fav Icon</span>
                      <i class="ti ti-upload d-block d-sm-none"></i>
                      <input
                        type="file"
                        id="fav_icon"
                        class="account-file-input"
                        hidden
                        name="fav_icon"
                        />
                    </label>
                    <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                      <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                      <span class="d-none d-sm-block">Reset</span>
                    </button>

                    <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                  </div>
                </div>
            </div>

        </div>
              </div>
              <hr class="my-0" />
              <div class="card-body">

                  <div class="row">
                    <div class="mb-3 col-md-6">
                      <label for="firstName" class="form-label">Organization Name</label>
                      <input
                        class="form-control"
                        type="text"
                        id="firstName"
                        name="name"
                        value="{{$data->company_name}}"
                        autofocus />
                    </div>

                    <div class="mb-3 col-md-6">
                      <label for="email" class="form-label">E-mail</label>
                      <input
                        class="form-control"
                        type="text"
                        id="email"
                        name="email"
                        value="{{$data->email}}"
                       />
                    </div>

                    <div class="mb-3 col-md-6">
                      <label class="form-label" for="phoneNumber">Phone Number</label>
                      <div class="input-group input-group-merge">
                        <span class="input-group-text">PK (+92)</span>
                        <input
                          type="text"
                          id="phoneNumber"
                          name="phone_no"
                          class="form-control"
                          value="{{$data->phone_no}}" />
                      </div>
                    </div>


                    <!-- <div class="mb-3 col-md-6">
                      <label class="form-label" for="country">Country</label>
                      <select id="country" name="country" class="select2 form-select">
                        <option value="">Select</option>
                        <option value="Australia">Australia</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Brazil">Brazil</option>
                        <option value="Canada">Canada</option>
                        <option value="China">China</option>
                        <option value="France">France</option>
                        <option value="Germany">Germany</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Japan">Japan</option>
                        <option value="Korea">Korea, Republic of</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Russia">Russian Federation</option>
                        <option value="South Africa">South Africa</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                      </select>
                    </div> -->
                    <div class="mb-3 col-md-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address"  value="{{$data->address}}" />
                      </div>
                      <div class="mb-3 col-md-6">
                        <label for="address" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="address" name="meta_title" value="{{$data->meta_title}}"  />
                      </div>
                      <div class="mb-3 col-md-6">
                        <label for="address" class="form-label">Meta Description</label>
                        <input type="text" class="form-control" id="address" name="meta_description" value="{{$data->meta_description}}"/>
                      </div>


                  </div>
                  <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
                </form>
              </div>
              <!-- /Account -->
            </div>









        </div>
      </div>
      <!-- / Content -->
 

      <!-- <div class="content-backdrop fade"></div>
    </div> 
  </div>
include('backend_app.layouts.footer') -->
@endsection