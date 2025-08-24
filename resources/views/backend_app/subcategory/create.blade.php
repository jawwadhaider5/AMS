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
                <h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Sub Component</a></li>
                    <li class="breadcrumb-item active">Add New</li>
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

            
            <form action="{{route('store-subcategory')}}" method="POST">
                @csrf

            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <label for="">Name</label>
                    <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="">

                </div>
                  
                <div class="col-lg-4 col-sm-12 col-md-6">
                <label for="system_id">Spread Type</label>
                <select name="system_id" class="form-select" id="system">
                  <option value="">Select Spread Type</option>
                  @foreach ($systemtypes as $systemtype)
                  <option value="{{$systemtype->id}}">{{$systemtype->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-lg-4 col-sm-12 col-md-6">
                <label for="category_id">Components</label>
                <select name="category_id" class="form-select" id="category">
                  <option value="">Select Components</option>
                </select>
              </div>
                 
                <div class="col-blg-12 col-sm-12 col-md-12 mt-3">
                    <label for="">Description</label>
                   <textarea name="description" id="" cols="30" class="form-control" rows="5"></textarea>
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


  

@push('scripts') 
<script>
  $('#system').change(function() {
    var val = $(this).val();

    $('#category').html('<option value="">Select Components</option>') 

    $.ajax({
      url: '/get-categories/' + val,
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
</script> 
@endpush


@endsection

