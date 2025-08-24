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
                <!--<h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>-->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">IMCA Reference</a></li>
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

            
          <form  method="POST" action="{{route('update-imca' , $imca->id )}}" >
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <label for="">IMCA Name</label>
                    <input value="{{ $imca->name }}" type="text" class="form-control" name="name" >

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

