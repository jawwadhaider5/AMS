@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page"> 
    @include('backend_app.layouts.nav') 
    <div class="content-wrapper">  -->

@section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Update Project </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Project</a></li>
                    <li class="breadcrumb-item active">Update</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection


<div class="container-xxl flex-grow-1 container-p-y">



    <div class="card">
        <div class="card-datatable table-responsive p-4">
            <form method="POST" action="{{route('update-project' , $project->id )}}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Project Name</label>
                        <input value="{{ $project-> project_name}}" type="text" class="form-control" name="project_name" id="">
                        @if($errors->has('project_name')) <div class="alert alert-danger"> {{ $errors->first('project_name') }}  </div> @endif

                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
                        <label for="system_type_id">Spread </label>
                        <select name="system_id" class="form-select" id="system_id">
                            <option value="">select spread </option>
                            @foreach ($systems as $system)
                            <option value="{{ $system->id }}" {{ $project->system_id == $system->id ? 'selected' : '' }}>
                                {{ $system->system_name }} - {{$system->systemtype->name}}
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('system_id')) <div class="alert alert-danger"> Spread Name is required  </div> @endif
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Client</label>
                        <input value="{{ $project->client_name}}" type="text" class="form-control" name="client_name" id="">
                        @if($errors->has('client_name')) <div class="alert alert-danger"> {{ $errors->first('client_name') }}  </div> @endif

                    </div>
                    <!-- <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Start Date</label>
                        <input value="{{ date('m-d-yyyy', strtotime($project->start_date)) }}" type="date" class="form-control" name="start_date" id="">
                        @if($errors->has('start_date')) <div class="alert alert-danger"> {{ $errors->first('start_date') }}  </div> @endif

                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">End Date</label>
                        <input value="{{ date('m-d-yyyy', strtotime($project->end_date)) }}" type="date" class="form-control" name="end_date" id="end_date">
                        @if($errors->has('end_date')) <div class="alert alert-danger"> {{ $errors->first('end_date') }}  </div> @endif

                    </div> -->

                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Location</label>
                        <select name="location_id" class="form-select" id="">
                            <option value="">Select Location</option>
                            @foreach ($locations as $location)
                            <option value="{{$location->id}}" @if($location->id == $project->location) selected @endif> {{$location->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('location')) <div class="alert alert-danger"> Location name is required  </div> @endif
                    </div>

                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3 mt-3">
                        <label for="">Description</label>
                        <textarea name="description" id="" cols="30" class="form-control" rows="5">{{ $project->description }}</textarea>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>

            </form>
        </div>

    </div>
</div>

<!-- include('backend_app.layouts.footer')

      <div class="content-backdrop fade"></div>
    </div>

  </div> -->

@endsection