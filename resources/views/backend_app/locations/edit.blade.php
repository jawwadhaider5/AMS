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
                <h1 class="m-0">Update Location</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Location</a></li>
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
          <form  method="POST" action="{{route('update-locations' , $locations->id )}}" >
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <label for="">Spread Type Name</label>
                    <input value="{{ $locations->name }}" type="text" class="form-control" name="name" id="">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4 float-end">Upated</button>

        </form>
          </div>

        </div>
      </div>
  
      <!-- include('backend_app.layouts.footer')
      <div class="content-backdrop fade"></div>
    </div>
  </div> -->

@endsection

