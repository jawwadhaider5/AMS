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
                <h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Task Type</a></li>
                    <li class="breadcrumb-item active">Update</li>
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

          @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                {{ $error }}<br />
                @endforeach
            </div>
            @endif

            
          <form  method="POST" action="{{route('update-tasktype' , $tasktype->id )}}" >
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Task Type Name</label>
                    <input value="{{ $tasktype->name }}" type="text" class="form-control" name="task_type" id="">
                </div>

                <div class="col-lg-6 col-sm-12 col-md-6">
                  <label for="system_type_id">System Type</label>
                    <select name="imca_reference_id" class="form-select" id="imca_reference_id">
                    <option value="">Select IMCA Reference</option>
                        @foreach ($imca as $data) 
                            <option value="{{ $data->id }}" {{ $tasktype->imca_reference_id == $data->id ? 'selected' : '' }}>
                                {{ $data->name }}
                            </option>
                        @endforeach 
                    </select>
                </div>

                <div class="col-lg-6 col-sm-12 col-md-6 mt-3 mt-3">
                    <label for="">frequency</label>
                    <input value="{{ $tasktype->frequency }}" type="text" class="form-control" name="frequency" id="">

                </div>
                <div class="col-lg-6 col-sm-12 col-md-6 mt-3 mt-3">
                    <label for="">Expire Date</label>
                    <input value="{{$tasktype->expire_date}}" type="text" class="form-control" name="expire_date" id="">

                </div>
                <div class="col-lg-12 col-sm-12 col-md-6 mt-3 mt-3">
                    <label for="">Description</label>
                   <textarea name="description" id="" cols="30" class="form-control" rows="5">{{  $tasktype->description }}</textarea>

                </div>

            </div>
            <button type="submit" class="btn btn-primary mt-4 float-end">Upated</button>

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

