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
                    <li class="breadcrumb-item"><a href="#">Assets</a></li>
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


            <form action="{{route('update-asset2' , $asset->id )}}" method="POST">
                @csrf
                @method('PUT')


                <div class="row">
  

                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Manufacturer</label>
                        <input value="{{ $asset->manufacturer }}" type="text" class="form-control" name="manufacturer" id="">

                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Model</label>
                        <input value="{{ $asset->system_modal }}" type="text" class="form-control" name="system_modal" id="">

                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Serial No</label>
                        <input value="{{ $asset->serial_no }}" type="text" class="form-control" name="serial_no" id="">

                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Location</label>

                        <select name="location" class="form-select" id="">
                            <option value="">Select Location</option>
                            @foreach ($locations as $loc)
                            <option value="{{$loc->id}}" {{ $asset->location == $loc->id ? 'selected' : '' }}>{{$loc->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="sefety_critical">Safety Critical</label>
                        <select name="sefety_critical" id="sefety_critical" class="form-select">
                            <option value="yes" {{ $asset->sefety_critical === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ $asset->sefety_critical === 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div class "col-lg-12 col-sm-12 col-md-6 mt-3">
                        
                        <label for ="own" >Nde Own or not</label>
                        <select name ="own" id ="own" class="form-select">
                        <option value="Nde own" {{ $asset->own === 'Nde own' ? 'selected' : '' }}>Nde own</option>
                        <option value ="Not" {{ $asset->own === 'Not' ? 'selected' : '' }}>Not </option>
                        
                    </select>
            
                            
                    </div>

                    <div class="col-lg-12 col-sm-12 col-md-6 mt-3 mt-3">
                        <label for="">Description</label>
                        <textarea name="description" id="" cols="30" class="form-control" rows="5"> {{$asset->description}}</textarea>

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


<script type="text/javascript">
    $(document).ready(function() {
        $('#category_id').change(function() {
            var category_id = $(this).val();

            if (category_id) {
                $.ajax({
                    url: '/get-subcategories/' + category_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#sub_category_id').empty();
                        $('#sub_category_id').append('<option value="">Select Sub Component</option>');
                        $.each(data, function(key, value) {
                            $('#sub_category_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_category_id').empty();
                $('#sub_category_id').append('<option value="">Select Sub Component</option>');
            }
        });
    });
</script>


@endsection