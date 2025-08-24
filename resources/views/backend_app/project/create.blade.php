@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page"> 
    @include('backend_app.layouts.nav')

    <div class="content-wrapper"> -->

    @section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add new Project</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Project</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y"> 
        <div class="card">
          <div class="card-datatable table-responsive p-4">
            
            <form action="{{ route('store-project')}}" method="POST">
                @csrf

            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                    <label for="">Project Name</label>
                    <input value="{{ old('project_name') }}" type="text" class="form-control" name="project_name" id="">
                    @if($errors->has('project_name')) <div class="alert alert-danger"> {{ $errors->first('project_name') }}  </div> @endif
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
                    <label for="">Spread</label>
                    <select value="{{ old('system_id') }}" name="system_id" class="form-select" id="">
                        <option value="">select spread</option>
                        @foreach ($systems as $system) 
                            <option value="{{$system->id}}"> {{$system->system_name}} - {{$system->systemtype->name}}</option>
                        @endforeach 
                    </select>
                    @if($errors->has('system_id')) <div class="alert alert-danger"> Spread Name is required  </div> @endif
                 </div>
                <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                    <label for="">Client</label>
                    <input value="{{ old('client_name') }}" type="text" class="form-control" name="client_name" id="">
                    @if($errors->has('client_name')) <div class="alert alert-danger"> {{ $errors->first('client_name') }}  </div> @endif
                </div>
                
                <!-- <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                    <label for="">Start Date</label>
                    <input value="{{ old('start_date') }}" type="date" class="form-control" name="start_date" id="">
                    @if($errors->has('start_date')) <div class="alert alert-danger"> {{ $errors->first('start_date') }}  </div> @endif
                </div>

                <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                    <label for="">End Date</label>
                    <input value="{{ old('end_date') }}" type="date" class="form-control" name="end_date" id="end_date">
                    @if($errors->has('end_date')) <div class="alert alert-danger"> {{ $errors->first('end_date') }}  </div> @endif
                </div> -->

                <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                    <label for="">Location</label>
                    <select name="location_id" class="form-select" id="">
                        <option value="">Select Location</option>
                        @foreach ($locations as $location) 
                            <option value="{{$location->id}}"> {{$location->name}}</option>
                        @endforeach 
                    </select>
                    @if($errors->has('location_id')) <div class="alert alert-danger"> Location Name is Required  </div> @endif
                </div>

                <div class="col-lg-6 col-sm-6 col-md-6 mt-3 mt-3">
                    <label for="">Description</label>
                   <textarea name="description" id="" cols="30" class="form-control" rows="5">{{ old('description') }}</textarea>
                   @if($errors->has('desciption')) <div class="alert alert-danger"> {{ $errors->first('desciption') }}  </div> @endif

                </div>


            </div>



            <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>

        </form>
          </div>

        </div>
      </div>
      <!-- / Content -->

      <!-- Footer -->
   <!-- include('backend_app.layouts.footer') 
      <div class="content-backdrop fade"></div>
    </div> 
  </div> -->

@endsection

