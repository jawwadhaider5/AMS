@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page"> 
    @include('backend_app.layouts.nav') 
    <div class="content-wrapper"> -->
      <!-- Content -->

      @section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Assets</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Assets</a></li>
          <li class="breadcrumb-item active">Assign Project</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection


      <div class="container-xxl flex-grow-1 container-p-y"> 

        <div class="card">
          <div class="card-datatable table-responsive p-4">
          <form  method="POST" action="{{route('project-asset' , $assets->id )}}" >
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Asset Description</label>
                    <input value="{{ $assets->description }}" type="text" class="form-control" name="description" id="" readonly>
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6">
                  <label for="system_type_id">Project Assign</label>
                   <select name="project_id" class="form-select" id="">
                         <option value="">Select Project</option>
                        @foreach ($projects as $project) 
                            <option value="{{$project->id}}"> {{$project->project_name}}</option>
                        @endforeach 
                    </select>
                 </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4 float-end">Update</button>

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

