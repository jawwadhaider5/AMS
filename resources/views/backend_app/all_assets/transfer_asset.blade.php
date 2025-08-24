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
          <li class="breadcrumb-item"><a href="#">Assets</a></li>
          <li class="breadcrumb-item active">Transfer</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4"><span class="text-muted fw-light">Assets /</span> Transfer</h4>

  <div class="card">
    <div class="card-datatable table-responsive p-4">
      @if($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
      </div>
      @endif
      <form method="POST" action="{{route('transfer-asset' , $assets->id )}}">
        @csrf
        @method('PUT')

        <div class="row">
          <div class="col-lg-12 col-sm-12 col-md-6">
            <label for="">Asset Description</label>
            <input value="{{ $assets->id }} - {{ $assets->description }} - {{$assets->category->name}} - {{$assets->subcategory->name}}" type="text" class="form-control" name="description" id="" readonly>
          </div>
          <div class="clearfix"><br></div>
          <div class="col-lg-4 col-sm-12 col-md-6">
            <label for="system_id">Spread Transfer</label>
            <select name="system_id" class="form-select" id="system">
              <option value="">Select Spread</option>
              @foreach ($systems as $system)
              <option value="{{$system->id}}"> {{$system->system_name}} - {{$system->systemtype->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-lg-4 col-sm-12 col-md-6">
            <label for="category_id">Inspection Requirments</label>
            <select name="category_id" class="form-select" id="category">
              <option value="">Select Inspection Requirements</option>
            </select>
          </div>
          <div class="col-lg-4 col-sm-12 col-md-6">
            <label for="sub_category_id">Inspection </label>
            <select name="sub_category_id" class="form-select" id="sub_category">
              <option value="">Select Inpection </option>
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




@push('scripts')

<script>
  $('#system').change(function() {
    var val = $(this).val();

    $('#category').html('<option value="">Select Components</option>')
    $('#sub_category').html('<option value="">Select Sub Components</option>');

    $.ajax({
      url: '/get-system-categories/' + val,
      method: 'GET',
      success: function(response) {

        $.each(response, function(index, item) {
          $('#category').append($('<option>', {
            value: item.id,
            text: item.name
          }));
        });

      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });

  $('#category').change(function() {
    var val = $(this).val();

    $('#sub_category').html('<option value="">Select Sub Components</option>');

    $.ajax({
      url: '/get-subcategories2/' + val,
      method: 'GET',
      success: function(response) {

        $.each(response, function(index, item) {
          $('#sub_category').append($('<option>', {
            value: item.id,
            text: item.name
          }));
        });

      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });
</script>



@endpush



@endsection