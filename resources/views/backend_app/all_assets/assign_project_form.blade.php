@extends('backend_app.layouts.template')
@section('content')

<div class="layout-page">
    <!-- Navbar -->
    @include('backend_app.layouts.nav')

    <div class="content-wrapper">
      <!-- Content -->
      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Assets /</span>Project Assign</h4>

        <div class="card">
          <div class="card-datatable table-responsive p-4">
          <form  method="POST" action="{{ route('assign-bulk-project') }}" >
            @csrf
            @method('PUT')

            <div class="row">
           
                <div class="col-lg-6 col-sm-12 col-md-6">
                  <label for="system_type_id">Project Assign</label>
                   <input type="hidden" name="selected_assets" value="{{ json_encode($selectedAssets) }}" id="selected_assets">
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
       @include('backend_app.layouts.footer')
      <div class="content-backdrop fade"></div>
    </div>
  </div>

@endsection

