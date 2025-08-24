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
                <!--<h1 class="m-0">{{ $current_sys->system_name ? $current_sys->system_name : 'Please Select A Spread' }}</h1>-->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Assets</a></li>
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


            <form action="{{ route('store-asset')}}" method="POST">
                @csrf

                <div class="row">


                <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="system_id">Select system</label>
                        <select name="system_id" class="form-select" id="system_id">
                            <option value="">Select system</option>
                            @foreach ($spreadcategories as $system)
                            <option value="{{$system->id}}">{{$system->system_description}}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="category_id">Select Component</label>
                        <select name="category_id" class="form-select" id="category_id">
                            <option value="">Select Component</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="sub_category_id">Sub Component</label>
                        <select name="sub_category_id" class="form-select" id="sub_category_id">
                            <option value="">Select Sub Components</option>
                        </select>
                    </div> -->

                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Manufacturer</label>
                        <input value="{{ old('manufacturer') }}" type="text" class="form-control" name="manufacturer" id="">

                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Model</label>
                        <input value="{{ old('system_modal') }}" type="text" class="form-control" name="system_modal" id="">

                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Serial No</label>
                        <input value="{{ old('serial_no') }}" type="text" class="form-control" name="serial_no" id="">

                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Location</label>
                        <select name="location" class="form-select" id="">
                            <option value="">Select Location</option>
                            @foreach ($locations as $loc)
                            <option value="{{$loc->id}}">{{$loc->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Sefety Critical</label>
                        <select name="sefety_critical" class="form-select" id="">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">NDE or Not</label>
                        <select name="own" class="form-select" id ="">
                            <option value ="Nde own">Nde own</option>
                            <option value="Not">Not</option>
                            
                        </select>
                        </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Project</label>
                        <select name="system_project" class="form-select" id="">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Class</label>
                        <select name="system_class" class="form-select" id="">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Class Code</label>
                        <select name="class_code" class="form-select" id="">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
                        <label for="">Status </label>
                        <select name="status" class="form-select" id="">
                            <option value="">Select Asset Status </option>
                            <option value="qurantine">Qurantine</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-md-6 mt-3 mt-3">
                        <label for="">Description</label>
                        <textarea name="description" id="" cols="30" class="form-control" rows="5"></textarea>

                    </div>


                </div>



                <button type="submit" class="btn btn-primary mt-4 float-end">Submit</button>

            </form>
        </div>

    </div>
</div>
<!-- / Content -->

@push('scripts')
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
        @endpush
        <!-- include('backend_app.layouts.footer') 
        <div class="content-backdrop fade"></div>
    </div> 
</div> -->

@endsection