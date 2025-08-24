@extends('backend_app.layouts.template')
@section('content')

<!-- <div class="layout-page">
  include('backend_app.layouts.nav')
  <div class="content-wrapper"> -->

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Spread</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Spread</a></li>
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

      @if($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
      </div>
      @endif


      <form method="POST" action="{{route('update-system' , $system->id )}}">
        @csrf
        @method('PUT')

        <div class="row">
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
            <label for="">Spread Name</label>
            <input value="{{ $system->system_name }}" type="text" class="form-control" name="system_name" id="">

          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 mt-3">
            <label for="system_type_id">IMCA Audit Type</label>
            <select name="system_type_id" class="form-select" id="system_type_id">
              <option value="">Choose</option>
              @foreach ($systemtypes as $systemtype)
              <option value="{{ $systemtype->id }}" {{ $system->system_type_id == $systemtype->id ? 'selected' : '' }}>
                {{ $systemtype->name }}
              </option>
              @endforeach
            </select>
          </div>

          <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
            <label for="">Spread Description</label>
            <textarea name="system_description" id="" class="form-control">{{ $system->system_description }}</textarea>

          </div>

          <!-- <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                <label for="system_description">Locations</label>
                <select name="system_description" class="form-select" id="system_description">
                  <option value="">Choose location</option>
                  @foreach ($locations as $location)
                  <option value="{{ $location->id }}" {{ $system->system_description == $location->id ? 'selected' : '' }}>
                    {{ $location->name }}
                  </option>
                  @endforeach
                </select>
              </div> -->


        </div>
        <button type="submit" class="btn btn-primary mt-4 float-end">Update</button>

      </form>
    </div>

  </div>
</div>

<!-- include('backend_app.layouts.footer')
    <div class="content-backdrop fade"></div>
  </div>
</div> -->

@endsection