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
                <h1 class="m-0">{{ $spreadcategory->system_description ?? 'Please Select A System' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">System</a></li>
                    <li class="breadcrumb-item active">Transfer</li>
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
            
          <form method="POST" action="{{route('update-transfer-system' , $spreadcategory->id )}}">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-lg- col-sm-12 col-md-6">
                <label for="">Transfer From Spread</label>
                <input value="{{ $spreadcategory->system_description }}" type="text" class="form-control" name="description" id="" readonly>
              </div> 
              <div class="col-lg-4 col-sm-12 col-md-6">
                <label for="system_id">Transfer To Spread</label>
                <select name="system_id" class="form-select" id="system">
                  <option value="">Select IMCA Audit Type</option>
                  @foreach ($systems as $system)
                  <option value="{{$system->id}}"> {{$system->system_name}} - {{$system->systemtype->name}}</option>
                  @endforeach
                </select>
              </div> 
            </div>
            <button type="submit" class="btn btn-primary mt-4 float-end">Transfer</button>

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