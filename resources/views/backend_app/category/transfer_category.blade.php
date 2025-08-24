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
                <!--<h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>-->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inspection Requirements</a></li>
                    <li class="breadcrumb-item active">Transfer</li>
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
            
          <form method="POST" action="{{route('update-transfer-category' , $category->id )}}">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-lg- col-sm-12 col-md-6">
                <label for="">Transfer From Spread</label>
                <input type="hidden" value="{{ $sysid->id }}" name="old_system_id">
                <input value="{{ $category->name }} - {{ $sysid->system_name }}" type="text" class="form-control" name="name" id="" readonly>
              </div>
              <div class="col-lg-4 col-sm-12 col-md-6">
                <label for="system_id">Transfer To Spread</label>
                <select name="system_id" class="form-select" id="system">
                  <option value="">Select IMCA Audit Type</option>
                  @foreach ($systems as $system)
                  @if($sysid->id != $system->id)
                  <option value="{{$system->id}}"> {{$system->system_name}} - {{$system->systemtype->name}}</option>
                  @endif
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
 
    <!-- include('backend_app.layouts.footer') 
    <div class="content-backdrop fade"></div>
  </div> 
</div> -->

@endsection